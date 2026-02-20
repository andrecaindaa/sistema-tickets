<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inbox;
use App\Models\Ticket;
use App\Models\User;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Inbox $inbox)
    {
        $user = auth()->user();

        if ($user->isCliente()) {
            $tickets = $inbox->tickets()
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        } else {
            $tickets = $inbox->tickets()
                ->latest()
                ->get();
        }

        return view('tickets.index', compact('inbox', 'tickets'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Inbox $inbox)
    {
        return view('tickets.create', compact('inbox'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Inbox $inbox)
    {
        $validated = $request->validate([
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade' => 'required|in:baixa,media,alta',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['inbox_id'] = $inbox->id;

        Ticket::create($validated);

        return redirect()
            ->route('inboxes.tickets.index', $inbox)
            ->with('success', 'Ticket criado com sucesso.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $user = auth()->user();

        if ($user->isCliente() && $ticket->user_id !== $user->id) {
            abort(403);
        }

        $ticket->load(['cliente', 'operador', 'inbox', 'mensagens.user']);
        //$ticket->load(['cliente', 'operador', 'inbox']);

        $operadores = User::where('role', 'operador')->get();

        return view('tickets.show', compact('ticket', 'operadores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        if (!auth()->user()->isOperador()) {
            abort(403);
        }

        $validated = $request->validate([
            'estado' => 'required|in:aberto,em_atendimento,resolvido,fechado',
            'operador_id' => 'nullable|exists:users,id',
        ]);

        $ticket->update($validated);

        return back()->with('success', 'Ticket atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
