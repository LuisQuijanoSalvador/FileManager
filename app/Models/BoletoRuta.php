<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoletoRuta extends Model
{
    use HasFactory;

    protected $fillable = [
        'idBoleto',
        'idAerolinea',
        'ciudadSalida',
        'ciudadLlegada',
        'vuelo',
        'clase',
        'fechaSalida',
        'horaSalida',
        'fechaLlegada',
        'horaLlegada',
        'farebasis',
        'idEstado',
        'usuarioCreacion',
        'usuarioModificacion'
    ];

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','idEstado');
    }

    public function tAerolinea(){
        return $this->hasOne(Aerolinea::class,'id','idAerolinea');
    }

    public function tBoleto(){
        return $this->hasOne(Boleto::class,'id','idBoleto');
    }
}
