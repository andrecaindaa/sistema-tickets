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

        // ADMIN PODE VER TUDO - sem restrições
        if ($user->isAdmin()) {
            // Admin tem acesso total
        }
        // OPERADOR SÓ PODE ACEDER ÀS SUAS INBOXES
        elseif ($user->isOperador() && !$user->inboxes->contains($inbox->id)) {
            abort(403);
        }
        // CLIENTE não deve aceder a esta view (será redirecionado)
        elseif ($user->isCliente()) {
            return redirect()->route('meus.tickets');
        }

        $query = $inbox->tickets()
            ->with(['estado', 'tipo', 'cliente', 'operador', 'entidade'])
            ->latest();

        // Cliente só vê os seus tickets (caso não tenha sido redirecionado)
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
        $user = auth()->user();

        // ADMIN PODE CRIAR EM QUALQUER INBOX
        if ($user->isAdmin()) {
            // Admin tem acesso total
        }
        // OPERADOR só pode criar na sua inbox
        elseif ($user->isOperador() && !$user->inboxes->contains($inbox->id)) {
            abort(403);
        }
        // CLIENTE não pode criar tickets diretamente
        elseif ($user->isCliente()) {
            abort(403);
        }

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
        ]);

        // Criar primeira mensagem
        $message = $ticket->mensagens()->create([
            'mensagem' => $validated['mensagem'],
            'user_id' => auth()->id(),
        ]);

        // Upload de anexos
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $file) {
                $path = $file->store('ticket_attachments', 'public');
                $message->attachments()->create([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                ]);
            }
        }

        // NOTIFICAÇÕES
        $ticket->cliente->notify(new TicketCreatedNotification($ticket));

        if ($ticket->operador) {
            $ticket->operador->notify(new TicketCreatedNotification($ticket));
        }

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

        // ADMIN PODE VER TUDO
        if ($user->isAdmin()) {
            // Admin tem acesso total
        }
        // OPERADOR só vê se tiver acesso à inbox
        elseif ($user->isOperador() && !$user->inboxes->contains($ticket->inbox_id)) {
            abort(403);
        }
        // CLIENTE só vê os seus tickets
        elseif ($user->isCliente() && $ticket->user_id !== $user->id) {
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

        return view('tickets.show', compact('ticket', 'operadores', 'estados'));
    }

    /**
     * Atualizar ticket
     */
    public function update(Request $request, Ticket $ticket)
    {
        $user = auth()->user();

        // ADMIN PODE ATUALIZAR QUALQUER TICKET
        if ($user->isAdmin()) {
            // Admin tem permissão total
        }
        // OPERADOR só pode atualizar se tiver acesso à inbox
        elseif ($user->isOperador()) {
            if (!$user->inboxes->contains($ticket->inbox_id)) {
                abort(403);
            }
        }
        // CLIENTE não pode atualizar tickets
        else {
            abort(403);
        }

        $validated = $request->validate([
            'ticket_estado_id' => 'required|exists:ticket_estados,id',
            'operador_id' => 'nullable|exists:users,id',
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

        // LOG ESTADO
        if ($originalEstado != $validated['ticket_estado_id']) {
            $novoEstado = TicketEstado::find($validated['ticket_estado_id']);
            TicketLog::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->id(),
                'acao' => 'alterou_estado',
                'descricao' => 'Alterou estado para: ' . $novoEstado->nome,
            ]);
        }

        // LOG OPERADOR
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

    public function meusTickets()
    {
        $user = auth()->user();

        $tickets = Ticket::with(['estado', 'tipo', 'inbox'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('tickets.meus', compact('tickets'));
    }

    /**
     * Eliminar ticket
     */
    public function destroy(Ticket $ticket)
    {
        $user = auth()->user();

        // ADMIN PODE ELIMINAR QUALQUER TICKET
        if ($user->isAdmin()) {
            // Admin tem permissão total
        }
        // OPERADOR só pode eliminar se tiver acesso à inbox
        elseif ($user->isOperador()) {
            if (!$user->inboxes->contains($ticket->inbox_id)) {
                abort(403, 'Não tem permissão para eliminar tickets desta inbox.');
            }
        }
        // CLIENTE não pode eliminar tickets
        else {
            abort(403, 'Apenas administradores e operadores podem eliminar tickets.');
        }

        // Guardar o inbox_id para redirecionamento
        $inboxId = $ticket->inbox_id;

        // Eliminar o ticket (e relacionados por cascade)
        $ticket->delete();

        return redirect()
            ->route('inboxes.tickets.index', $inboxId)
            ->with('success', 'Ticket eliminado com sucesso.');
    }
}
