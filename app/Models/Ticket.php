<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    protected $fillable = [
        'inbox_id',
        'user_id',
        'operador_id',
        'assunto',
        'descricao',
        'estado',
        'prioridade',
    ];

    public function inbox()
    {
        return $this->belongsTo(Inbox::class);
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id');
    }

    public function mensagens()
    {
        return $this->hasMany(TicketMessage::class)
                    ->latest();
    }



    protected static function booted()
    {
        static::creating(function ($ticket) {

            if ($ticket->numero) {
                return;
            }

            DB::transaction(function () use ($ticket) {

                // Bloqueia tabela para evitar concorrência
                $lastNumero = DB::table('tickets')
                    ->lockForUpdate()
                    ->orderByDesc('id')
                    ->value('numero');

                if ($lastNumero) {
                    $lastNumberInt = (int) str_replace('TC-', '', $lastNumero);
                    $nextNumber = $lastNumberInt + 1;
                } else {
                    $nextNumber = 1;
                }

                $ticket->numero = 'TC-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            });
        });
    }

    public function tipo()
    {
        return $this->belongsTo(TicketTipo::class, 'ticket_tipo_id');
    }

    public function estado()
    {
        return $this->belongsTo(TicketEstado::class, 'ticket_estado_id');
    }

    public function entidade()
    {
        return $this->belongsTo(Entidade::class);
    }

    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }
}

