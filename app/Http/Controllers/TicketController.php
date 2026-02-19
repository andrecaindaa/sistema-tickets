<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Inbox;
use app\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
