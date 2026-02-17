<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Funcao extends Model
{
    protected $table = 'funcoes';

    protected $fillable = ['nome'];

    public function contactos()
    {
        return $this->hasMany(Contacto::class);
    }

}
