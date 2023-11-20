<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correlativo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tabla',
        'numero',
        'estado',
        'usuarioCreacion',
        'usuarioModificacion'
    ];
    
    public function tEstado(){
        return $this->hasOne(Estado::class,'id','estado');
    }
}
