<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'numeroCuenta',
        'cci',
        'idEstado',
        'usuarioCreacion',
        'usuarioModificacion',
    ];

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','idEstado');
    }
}
