<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use App\Models\Counter;
use App\Models\Boleto;
use App\Models\Aerolinea;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Integrador extends Component
{
    public $idCounter,$boleto="",$selectedGds="sabre";
    public $pasajero,$idAerolinea,$numeroBoleto,$fechaEmision,$codigoReserva,$idCliente, 
    $idTipoFacturacion,$idTipoDocumento=6,$idArea,$idVendedor,$ruta,$destino;

    public function render()
    {
        $counters = Counter::all()->sortBy('nombre');
        return view('livewire.gestion.integrador',compact('counters'));
    }

    public function obtenerBoleto(){
        $lineas = explode("\n",$this->boleto);
        $lineasBoleto = array_values($lineas);
        if ($this->selectedGds == 'sabre') {
            $this->parsearSabre($lineasBoleto);
        }else if($this->selectedGds == 'kiu'){
            $this->parsearKiu($lineasBoleto);
        }
        else if($this->selectedGds == 'ndc'){
            $this->parsearNdc($lineasBoleto);
        }
    }
    public function parsearSabre($boleto){
        $contador = 0;
        if (count($boleto) < 5) {
            session()->flash('error', 'Formato incorrecto del boleto.');
            return;
        }
        foreach ($boleto as $linea) {
            $contador = $contador + 1;
            //Obtener Pasajero
            $posPasajero = strpos($linea,"NAME:");
            if($posPasajero !== false){
                $this->pasajero = str_replace(" ","",$linea);
                $this->pasajero = str_replace("NAME:","",$this->pasajero);
                $this->pasajero = str_replace("/"," ",$this->pasajero);
            }

            //Obtener Aerolínea y Numero de Boleto
            $posBoleto = strpos($linea,"ETKT");
            if($posBoleto !== false){
                $codigoAerolinea = substr($linea,$posBoleto+10,3);
                $oAerolinea = Aerolinea::where('codigoIata',$codigoAerolinea)->first();
                $this->idAerolinea = $oAerolinea->id;

                $this->numeroBoleto = substr($linea,-10);
                $oBoleto = Boleto::where('numeroBoleto',$this->numeroBoleto)->first();
                if($oBoleto){
                    session()->flash('error', 'El boleto ya está integrado.');
                    return;
                }
            }
            
            //Obtener Código de Reserva
            $posPnr = strpos($linea,"BOOKING REFERENCE:");
            if ($posPnr !== false) {
                $this->codigoReserva = substr($linea,$posPnr+19,6);
            }

            //Obtener Fecha de Emision
            $posFechaEmision = strpos($linea,"DATE OF ISSUE:");
            if ($posFechaEmision !== false) {
                $fechaOriginal = substr($linea,$posFechaEmision+15,7);
                $fechaFormat = Carbon::createFromFormat('dMy',$fechaOriginal);
                $this->fechaEmision = $fechaFormat->format('Y-m-d');
            }
            
            //Obtener Cliente
            $posCliente = strpos($linea,"NAME REF:");
            if ($posCliente !== false) {
                $posRuc = strpos($linea,"RUC");
                if ($posRuc !== false) {
                    $ruc = substr($linea,$posCliente+13,11);
                    $oCliente = Cliente::where('numeroDocumentoIdentidad',$ruc)->first();
                    if ($oCliente) {
                        $this->idCliente = $oCliente->id;
                        $this->idTipoFacturacion = $oCliente->tipoFacturacion;
                        $this->idArea = $oCliente->area;
                        $this->idVendedor = $oCliente->vendedor;
                    }
                }else{
                    $doc = substr($linea,-8);
                    $oCliente = Clinte::where('numeroDocumentoIdentidad',$doc)->first();
                    if ($oCliente) {
                        $this->idCliente = $oCliente->id;
                        $this->idTipoFacturacion = $oCliente->tipoFacturacion;
                        $this->idArea = $oCliente->area;
                        $this->idVendedor = $oCliente->vendedor;
                    }
                }
            }

            //Obtener Ruta / Destino
            $posRuta = strpos($linea,"FARE CALC:");
            if ($posRuta !== false) {
                $cadena = Str::remove(range(0,9),$linea);
                $cadena = Str::remove(".",$cadena);
                $cadena = Str::remove("NUC",$cadena);
                $palabras = Str::of($cadena)->explode(' ');
                $palabras3 = $palabras->filter(function($palabra){
                    return Str::length($palabra) == 3;
                });
                foreach ($palabras3 as $word) {
                    $this->ruta = $this->ruta . $word . "/";
                }
                $this->ruta = substr($this->ruta,0,strlen($this->ruta)-1);

                $dest = str_replace("/","",$this->ruta);
                $incioCadena = round(((strlen($dest) / 3) / 2),0,PHP_ROUND_HALF_DOWN) * 3;
                $this->destino =  substr($dest, $incioCadena, 3);
            }
        }
        // dd($this->idAerolinea);
    }

    public function parsearKiu($boleto){
        
    }

    public function parsearNdc($boleto){
        
    }
}
