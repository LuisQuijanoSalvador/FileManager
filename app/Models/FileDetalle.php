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

    public function tFile(){
        return $this->hasOne(File::class,'id','idFile');
    }

    public function tServicio(){
        return $this->hasOne(Servicio::class,'id','idServicio');
    }

    public function tBoleto(){
        return $this->hasOne(Boleto::class,'id','idBoleto');
    }

    public function tEstado(){
        return $this->hasOne(Estado::class,'id','idEstado');
    }
}
