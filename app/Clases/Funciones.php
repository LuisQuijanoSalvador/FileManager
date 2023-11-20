<?php
namespace App\Clases;

use App\Models\Correlativo;

class Funciones
{
    public $numero,$idRegistro;

    public function generaFile($tabla){
        $this->numero = 0;
        $this->idRegistro = 0;
        $file = Correlativo::where('tabla',$tabla)->first();
        // $file = Correlativo::find()
        $this->numero = $file->numero;
        $this->idRegistro = $file->id;

        //$correlativo = Correlativo::find($this->idRegistro);
        $nuevoNumero = $this->numero + 1;
        $file->numero =$nuevoNumero;
        $file->usuarioModificacion = auth()->user()->id;
        $file->save();
        
        return $this->numero;
    }
}