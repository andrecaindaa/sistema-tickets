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
        'anexos.*' => 'nullable|file|max:5120', // 5MB
    ]);

    $message = $ticket->mensagens()->create([
        'mensagem' => $validated['mensagem'],
        'user_id' => auth()->id(),
    ]);

    // Upload anexos
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
