<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $fillable = [
        'razonSocial',
        'nombreComercial',
        'direccionFiscal',
        'direccionFacturacion',
        'tipoProveedor',
        'esConsolidador',
        'comision',
        'tipoDocumentoIdentidad',
        'numeroDocumentoIdentidad',
        'numeroTelefono',
        'correo',
        'montoCredito',
        'moneda',
        'diasCredito',
        'tipoDocumento',
        'estado'
    ];

    public function tTipoDocumento(){
        return $this->hasOne(TipoDocumento::class,'id','tipoDocumento');
    }

    public function tTipoDocumentoIdentidad(){
        return $this->hasOne(TipoDocumentoIdentidad::class,'id','tipoDocumentoIdentidad');
    }

    public function tTipoProveedor(){
        return $this->hasOne(TipoCliente::class,'id','tipoProveedor');
    }

    public function tMoneda(){
        return $this->hasOne(moneda::class,'id','moneda');
    }

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','estado');
    }
}

