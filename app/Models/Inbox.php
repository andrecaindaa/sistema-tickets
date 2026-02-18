<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $fillable = ['nome', 'descricao', 'ativo'];

    public function operadores()
    {
        return $this->belongsToMany(User::class);
    }

}
