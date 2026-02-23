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

class TicketController extends Controller
{
    /**
     * Listagem de tickets por inbox
     */
    public function index(Inbox $inbox)
    {
        $user = auth()->user();

        $query = $inbox->tickets()->latest();

        // Cliente só vê tickets da sua entidade
        if ($user->isCliente()) {
            $query->where('user_id', $user->id);
        }

        $tickets = $query->with(['estado', 'tipo'])->get();

        return view('tickets.index', compact('inbox', 'tickets'));
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
        ]);

        $operadores = User::where('role', 'operador')->get();
        $estados = TicketEstado::all();

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
        ]);

        $ticket->update($validated);

        return back()->with('success', 'Ticket atualizado.');
    }
}
