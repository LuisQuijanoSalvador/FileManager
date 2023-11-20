<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gds extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'estado',
        'usuarioCreacion',
        'usuarioModificacion'
    ];

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','estado');
    }
}
