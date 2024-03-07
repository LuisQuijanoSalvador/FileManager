<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'numeroFile',
        'idArea',
        'idCliente',
        'descripcion',
        'fechaFile',
        'totalPago',
        'totalCobro',
        'idEstado',
        'usuarioCreacion',
        'usuarioModificacion',
    ];

    public function tArea(){
        return $this->hasOne(Area::class,'id','idArea');
    }
    public function tCliente(){
        return $this->hasOne(Cliente::class,'id','idCliente');
    }
    public function tEstado(){
        return $this->hasOne(Estado::class,'id','idEstado');
    }
}
