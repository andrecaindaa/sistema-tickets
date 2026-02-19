<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}

