<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Ticket;

class TicketCreatedNotification extends Notification
{
    use Queueable;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Novo Ticket #' . $this->ticket->numero)
            ->greeting('Olá!')
            ->line('Foi criado um novo ticket.')
            ->line('Assunto: ' . $this->ticket->assunto)
            ->line('Estado: ' . $this->ticket->estado->nome)
            ->action('Ver Ticket', route('tickets.show', $this->ticket))
            ->line('Obrigado.');
    }
}
