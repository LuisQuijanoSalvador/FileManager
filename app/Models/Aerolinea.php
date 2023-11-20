<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aerolinea extends Model
{
    use HasFactory;

    protected $fillable = [
        'razonSocial',
        'nombreComercial',
        'siglaIata',
        'codigoIata',
        'ruc',
        'logo',
        'estado',
        'usuarioCreacion',
        'usuarioModificacion'
    ];

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','estado');
    }
}
