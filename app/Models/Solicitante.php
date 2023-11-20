<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'email',
        'cargo',
        'telefono',
        'celular',
        'cliente',
        'estado'
    ];

    public function tCliente(){
        return $this->hasOne(Cliente::class,'id','cliente');
    }

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','estado');
    }
}
