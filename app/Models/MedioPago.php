<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedioPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'codigo',
        'usuarioCreacion',
        'usuarioModificacion'
    ];
}
