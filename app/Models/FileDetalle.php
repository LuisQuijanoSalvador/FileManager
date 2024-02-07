<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'idFile',
        'numeroFile',
        'idServicio',
        'idBoleto',
        'idEstado',
        'usuarioCreacion',
        'usuarioModificacion',
    ];
}
