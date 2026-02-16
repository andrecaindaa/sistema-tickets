<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidade extends Model
{
   protected $fillable = [
    'nif',
    'nome',
    'telefone',
    'telemovel',
    'website',
    'email',
    'notas_internas'
];

}
