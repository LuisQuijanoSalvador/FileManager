<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class motivoDebito extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'codigo',
        'idEstado',
        'usuarioCreacion',
        'usuarioModificacion'
    ];
    public function tEstado(){
        return $this->hasOne(Estado::class,'id','idEstado');
    }
}
