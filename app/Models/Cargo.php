<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'idDocumento',
        'idCliente',
        'idCobrador',
        'idCounter',
        'idAerolinea',
        'isSolicitante',
        'idBoleto',
        'idServicio',
        'montoCredito',
        'diasCredito',
        'fechaEmision',
        'fechaVencimiento',
        'numeroBoleto',
        'pasajero',
        'tipoRuta',
        'ruta',
        'moneda',
        'tarifaNeta',
        'inafecto',
        'igv',
        'otrosImpuestos',
        'total',
        'tipoDocumento',
        'serieDocumento',
        'numeroDocumento',
        'montoCargo',
        'tipoCambio',
        'saldo',
        'idEstado',
        'usuarioCreacion',
        'usuarioModificacion',
    ];

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','idEstado');
    }

    public function tDocumento(){
        return $this->hasOne(Documento::class,'id','idDocumento');
    }

    public function tCliente(){
        return $this->hasOne(Cliente::class,'id','idCliente');
    }

    public function tCobrador(){
        return $this->hasOne(Cobrador::class,'id','idCobrador');
    }

    public function tCounter(){
        return $this->hasOne(Counter::class,'id','idCounter');
    }

    public function tAerolinea(){
        return $this->hasOne(Aerolinea::class,'id','idAerolinea');
    }

    public function tBoleto(){
        return $this->hasOne(Boleto::class,'id','idBoleto');
    }

    public function tServicio(){
        return $this->hasOne(Servicio::class,'id','idServicio');
    }

    public function tSolicitante(){
        return $this->hasOne(Solicitante::class,'id','idSolicitante');
    }
}
