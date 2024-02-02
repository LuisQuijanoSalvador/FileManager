<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'idCliente',
        'razonSocial',
        'direccionFiscal',
        'numeroDocumentoIdentidad',
        'idTipoDocumento',
        'tipoDocumento',
        'serie',
        'numero',
        'idMoneda',
        'moneda',
        'fechaEmision',
        'fechaVencimiento',
        'detraccion',
        'afecto',
        'inafecto',
        'exonerado',
        'igv',
        'otrosImpuestos',
        'total',
        'totalLetras',
        'glosa',
        'numeroFile',
        'tipoServicio',
        'documentoReferencia',
        'idMotivoNC',
        'idMotivoND',
        'tipoCambio',
        'idEstado',
        'jsonDoc',
        'respuestaSunat',
        'respuestaBaja',
        'usuarioCreacion',
        'usuarioModificacion',
    ];

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','idEstado');
    }

    public function tCliente(){
        return $this->hasOne(Cliente::class,'id','idCliente');
    }

    public function tTipoDocumento(){
        return $this->hasOne(TipoDocumento::class,'id','idTipoDocumento');
    }

    public function tMoneda(){
        return $this->hasOne(moneda::class,'id','idMoneda');
    }

    public function tMotivoNC(){
        return $this->hasOne(motivoCredito::class,'id','idMotivoNC');
    }

    public function tMotivoND(){
        return $this->hasOne(motivoDebito::class,'id','idMotivoND');
    }

    public function tBoleto(){
        return $this->hasOne(Boleto::class,'id','idBoleto');
    }
}
