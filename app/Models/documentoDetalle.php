<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentoDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'idDocumento',
        'idBoleto',
        'idMoneda',
        'tarifaNeta',
        'igv',
        'otrosImpuestos',
        'inafecto',
        'total',
        'idEstado',
        'usuarioCreacion',
        'usuarioModificacion'
    ];

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','idEstado');
    }
    public function tBoleto(){
        return $this->hasOne(Boleto::class,'id','idBoleto');
    }
    public function tMoneda(){
        return $this->hasOne(moneda::class,'id','idMoneda');
    }
}
