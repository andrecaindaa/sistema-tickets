<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'funcao_id',
        'email',
        'telefone',
        'telemovel',
        'notas_internas'
    ];

    public function funcao()
    {
        return $this->belongsTo(Funcao::class);
    }

    public function entidades()
    {
        return $this->belongsToMany(Entidade::class)
                    ->withTimestamps();
    }
}
