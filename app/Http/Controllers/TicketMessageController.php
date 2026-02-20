<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketMessageController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'mensagem' => 'required|string',
        ]);

        $ticket->mensagens()->create([
            'mensagem' => $validated['mensagem'],
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
