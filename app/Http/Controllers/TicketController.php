<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inbox;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketEstado;
use App\Models\TicketTipo;
use App\Models\Entidade;
use App\Models\Contacto;
use App\Notifications\TicketCreatedNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\TicketLog;
//use App\Models\TicketPrioridade;

class TicketController extends Controller
{
    /**
     * Listagem de tickets por inbox
     */
    public function index(Request $request, Inbox $inbox)
    {
        $user = auth()->user();

        $query = $inbox->tickets()
            ->with(['estado', 'tipo', 'cliente', 'operador', 'entidade'])
            ->latest();

        // Cliente só vê os seus tickets
        if ($user->isCliente()) {
            $query->where('user_id', $user->id);
        }

        // -----------------------
        // FILTROS
        // -----------------------

        if ($request->estado) {
            $query->where('ticket_estado_id', $request->estado);
        }

        if ($request->operador) {
            $query->where('operador_id', $request->operador);
        }

        if ($request->tipo) {
            $query->where('ticket_tipo_id', $request->tipo);
        }

        if ($request->entidade) {
            $query->where('entidade_id', $request->entidade);
        }

        // -----------------------
        // PESQUISA
        // -----------------------

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                ->orWhere('assunto', 'like', "%{$search}%")
                ->orWhereHas('cliente', function ($q2) use ($search) {
                    $q2->where('email', 'like', "%{$search}%");
                })
                ->orWhereHas('entidade', function ($q3) use ($search) {
                    $q3->where('nome', 'like', "%{$search}%");
                });
            });
        }

        $tickets = $query->get();

        return view('tickets.index', [
            'inbox' => $inbox,
            'tickets' => $tickets,
            'estados' => TicketEstado::all(),
            'operadores' => User::where('role', 'operador')->get(),
            'tipos' => TicketTipo::all(),
            'entidades' => Entidade::all(),
        ]);
    }

    /**
     * Form criar ticket
     */
    public function create(Inbox $inbox)
    {
        return view('tickets.create', [
            'inbox' => $inbox,
            'tipos' => TicketTipo::all(),
            'entidades' => Entidade::all(),
            'contactos' => Contacto::all(),
        ]);
    }

    /**
     * Guardar novo ticket
     */
    public function store(Request $request, Inbox $inbox)
    {
        $validated = $request->validate([
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string',
            'ticket_tipo_id' => 'required|exists:ticket_tipos,id',
            'entidade_id' => 'required|exists:entidades,id',
            'contacto_id' => 'required|exists:contactos,id',
            'conhecimento' => 'nullable|string',
        ]);

        // Converter CC em array
        $cc = null;
        if ($request->conhecimento) {
            $cc = array_map('trim', explode(',', $request->conhecimento));
        }

        // Estado default = Aberto
        $estadoAberto = TicketEstado::where('nome', 'Aberto')->first();

       // $prioridadeMedia = TicketPrioridade::where('nome', 'Média')->first();
        $ticket = Ticket::create([
            'inbox_id' => $inbox->id,
            'user_id' => auth()->id(),
            'assunto' => $validated['assunto'],
            'descricao' => $validated['mensagem'],
            'ticket_tipo_id' => $validated['ticket_tipo_id'],
            'ticket_estado_id' => $estadoAberto->id,
            'entidade_id' => $validated['entidade_id'],
            'contacto_id' => $validated['contacto_id'],
            'conhecimento' => $cc,
            //'ticket_prioridade_id' => $prioridadeMedia->id,
        ]);



        // Criar primeira mensagem
$message = $ticket->mensagens()->create([
    'mensagem' => $validated['mensagem'],
    'user_id' => auth()->id(),
]);

// --------------------
// Upload de anexos
// --------------------

if ($request->hasFile('anexos')) {

    foreach ($request->file('anexos') as $file) {

        $path = $file->store('ticket_attachments', 'public');

        $message->attachments()->create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
        ]);
    }
}


        // -------------------------
        // NOTIFICAÇÕES
        // -------------------------

        // Notificar criador
        $ticket->cliente->notify(
            new TicketCreatedNotification($ticket)
        );

        // Notificar operador (se existir)
        if ($ticket->operador) {
            $ticket->operador->notify(
                new TicketCreatedNotification($ticket)
            );
        }

        // Notificar emails em CC
        if (!empty($ticket->conhecimento)) {
            Notification::route('mail', $ticket->conhecimento)
                ->notify(new TicketCreatedNotification($ticket));
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Ticket criado com sucesso.');
    }

    /**
     * Mostrar ticket
     */
    public function show(Ticket $ticket)
    {
        $user = auth()->user();

        // Cliente só pode ver os seus
        if ($user->isCliente() && $ticket->user_id !== $user->id) {
            abort(403);
        }

        $ticket->load([
            'cliente',
            'operador',
            'inbox',
            'mensagens.user',
            'estado',
            'tipo',
            'entidade',
            'contacto',
            'logs.user',
        ]);

        $operadores = User::where('role', 'operador')->get();
        $estados = TicketEstado::all();
        //$prioridades = TicketPrioridade::orderBy('ordem')->get();

        return view('tickets.show', compact('ticket', 'operadores', 'estados'));
    }

    /**
     * Atualizar ticket (operador)
     */
    public function update(Request $request, Ticket $ticket)
    {
        if (!auth()->user()->isOperador()) {
            abort(403);
        }

        $validated = $request->validate([
            'ticket_estado_id' => 'required|exists:ticket_estados,id',
            'operador_id' => 'nullable|exists:users,id',
            //'ticket_prioridade_id' => 'required|exists:ticket_prioridades,id',
        ]);

        // Garantir que operador tem role correta
        if (!empty($validated['operador_id'])) {
            $operador = User::where('id', $validated['operador_id'])
                ->where('role', 'operador')
                ->first();

            if (!$operador) {
                return back()->withErrors([
                    'operador_id' => 'Utilizador inválido.'
                ]);
            }
        }

        $originalEstado = $ticket->ticket_estado_id;
        $originalOperador = $ticket->operador_id;

        // Atualiza uma única vez
        $ticket->update($validated);

        // --------------------
        // LOG ESTADO
        // --------------------
        if ($originalEstado != $validated['ticket_estado_id']) {

            $novoEstado = TicketEstado::find($validated['ticket_estado_id']);

            TicketLog::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->id(),
                'acao' => 'alterou_estado',
                'descricao' => 'Alterou estado para: ' . $novoEstado->nome,
            ]);
        }

        // --------------------
        // LOG OPERADOR
        // --------------------
        if ($originalOperador != $validated['operador_id']) {

            $novoOperador = $validated['operador_id']
                ? User::find($validated['operador_id'])->name
                : 'Nenhum';

            TicketLog::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->id(),
                'acao' => 'alterou_operador',
                'descricao' => 'Alterou operador para: ' . $novoOperador,
            ]);
        }

        return back()->with('success', 'Ticket atualizado.');
    }
}
