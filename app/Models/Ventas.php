<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = 'vista_ventas';
    use HasFactory;

    protected $fillable = [
        'Origen',
        'Tipo',
        'Documento',
        'TipoDoc',
        'numeroFile',
        'NumeroBoleto',
        'pasajero',
        'Solicitante',
        'Ruta',
        'TipoRuta',
        'Counter',
        'CentroCosto',
        'Cod1',
        'Cod2',
        'Cod3',
        'Cod4',
        'Cliente',
        'Proveedor',
        'Consolidador',
        'FechaEmision',
        'Moneda',
        'TarifaNeta',
        'Inafecto',
        'OtrosImpuestos',
        'IGV',
        'TotalOrigen',
        'XM',
        'Total',
        'idCliente'
    ];
}
