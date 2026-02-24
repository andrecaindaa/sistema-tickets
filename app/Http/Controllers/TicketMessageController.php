<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Notifications\TicketReplyNotification;
use Illuminate\Support\Facades\Notification;

class TicketMessageController extends Controller
{
        public function store(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'mensagem' => 'required|string',
        ]);

        $message = $ticket->mensagens()->create([
            'mensagem' => $validated['mensagem'],
            'user_id' => auth()->id(),
        ]);

        // -------------------------
        // NOTIFICAÇÕES
        // -------------------------

        // Notificar criador
        $ticket->cliente->notify(
            new TicketReplyNotification($ticket, $message->mensagem)
        );

        // Notificar CC
        if (!empty($ticket->conhecimento)) {
            Notification::route('mail', $ticket->conhecimento)
                ->notify(
                    new TicketReplyNotification($ticket, $message->mensagem)
                );
        }

        return back();
    }
}
