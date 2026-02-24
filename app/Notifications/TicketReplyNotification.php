<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Ticket;

class TicketReplyNotification extends Notification
{
    use Queueable;

    public $ticket;
    public $mensagem;

    public function __construct(Ticket $ticket, $mensagem)
    {
        $this->ticket = $ticket;
        $this->mensagem = $mensagem;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nova resposta no Ticket #' . $this->ticket->numero)
            ->line('Nova mensagem:')
            ->line($this->mensagem)
            ->action('Ver Ticket', route('tickets.show', $this->ticket));
    }
}
