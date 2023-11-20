<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use App\Models\Counter;
use App\Models\Boleto;
use App\Models\Aerolinea;
use App\Models\Cliente;
use App\Models\BoletoRuta;
use App\Models\BoletoPago;
use App\Models\TarjetaCredito;
use App\Models\MedioPago;
use App\Models\TipoCambio;
use App\Models\Area;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Integrador extends Component
{
    public $idCounter,$boleto="",$selectedGds="sabre";
    public $idRegistro,$numeroBoleto,$numeroFile,$fechaEmision,
    $idTipoFacturacion,$idTipoDocumento=6,$idArea,$idVendedor,$idConsolidador=2,$codigoReserva,
    $fechaReserva,$idGds=2,$idTipoTicket=1,$tipoRuta="NACIONAL",$tipoTarifa="NORMAL",$idAerolinea=7,
    $origen="BSP",$pasajero,
    $idTipoPasajero=1,$ruta,$destino,$idDocumento,$tipoCambio,$idMoneda=2,$tarifaNeta=0,$igv=0,
    $otrosImpuestos=0,$xm=0,$total=0,$totalOrigen=0,$porcentajeComision,$montoComision=0,
    $descuentoCorporativo,$codigoDescCorp,$tarifaNormal,$tarifaAlta,$tarifaBaja,
    $idTipoPagoConsolidador,$centroCosto,$cod1,$cod2,$cod3,$cod4,$observaciones,$estado=1,
    $usuarioCreacion,$fechaCreacion,$usuarioModificacion,$fechaModificacion;

    public $ciudadSalida,$ciudadLlegada,$idAerolineaRuta,$vuelo,$clase,$fechaSalida,$horaSalida,$fechaLlegada,
            $horaLlegada,$farebasis;

    public $idMedioPago,$idTarjetaCredito,$numeroTarjeta,$monto,$fechaVencimientoTC,$boletoPagos;

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
    // public function parsearSabre($boleto){
    //     $contador = 0;
    //     if (count($boleto) < 5) {
    //         session()->flash('error', 'Formato incorrecto del boleto.');
    //         return;
    //     }
    //     foreach ($boleto as $linea) {
    //         $contador = $contador + 1;
    //         //Obtener Pasajero
    //         $posPasajero = strpos($linea,"NAME:");
    //         if($posPasajero !== false){
    //             $this->pasajero = str_replace(" ","",$linea);
    //             $this->pasajero = str_replace("NAME:","",$this->pasajero);
    //             $this->pasajero = str_replace("/"," ",$this->pasajero);
    //         }

    //         //Obtener Aerolínea y Numero de Boleto
    //         $posBoleto = strpos($linea,"ETKT");
    //         if($posBoleto !== false){
    //             $codigoAerolinea = substr($linea,$posBoleto+10,3);
    //             $oAerolinea = Aerolinea::where('codigoIata',$codigoAerolinea)->first();
    //             $this->idAerolinea = $oAerolinea->id;

    //             $this->numeroBoleto = substr($linea,-10);
    //             $oBoleto = Boleto::where('numeroBoleto',$this->numeroBoleto)->first();
    //             if($oBoleto){
    //                 session()->flash('error', 'El boleto ya está integrado.');
    //                 return;
    //             }
    //         }
            
    //         //Obtener Código de Reserva
    //         $posPnr = strpos($linea,"BOOKING REFERENCE:");
    //         if ($posPnr !== false) {
    //             $this->codigoReserva = substr($linea,$posPnr+19,6);
    //         }

    //         //Obtener Fecha de Emision
    //         $posFechaEmision = strpos($linea,"DATE OF ISSUE:");
    //         if ($posFechaEmision !== false) {
    //             $fechaOriginal = substr($linea,$posFechaEmision+15,7);
    //             $fechaFormat = Carbon::createFromFormat('dMy',$fechaOriginal);
    //             $this->fechaEmision = $fechaFormat->format('Y-m-d');
    //         }
            
    //         //Obtener Cliente
    //         $posCliente = strpos($linea,"NAME REF:");
    //         if ($posCliente !== false) {
    //             $posRuc = strpos($linea,"RUC");
    //             if ($posRuc !== false) {
    //                 $ruc = substr($linea,$posCliente+13,11);
    //                 $oCliente = Cliente::where('numeroDocumentoIdentidad',$ruc)->first();
    //                 if ($oCliente) {
    //                     $this->idCliente = $oCliente->id;
    //                     $this->idTipoFacturacion = $oCliente->tipoFacturacion;
    //                     $this->idArea = $oCliente->area;
    //                     $this->idVendedor = $oCliente->vendedor;
    //                 }
    //             }else{
    //                 $doc = substr($linea,-8);
    //                 $oCliente = Clinte::where('numeroDocumentoIdentidad',$doc)->first();
    //                 if ($oCliente) {
    //                     $this->idCliente = $oCliente->id;
    //                     $this->idTipoFacturacion = $oCliente->tipoFacturacion;
    //                     $this->idArea = $oCliente->area;
    //                     $this->idVendedor = $oCliente->vendedor;
    //                 }
    //             }
    //         }

    //         //Obtener Ruta / Destino
    //         $posRuta = strpos($linea,"FARE CALC:");
    //         if ($posRuta !== false) {
    //             $cadena = Str::remove(range(0,9),$linea);
    //             $cadena = Str::remove(".",$cadena);
    //             $cadena = Str::remove("NUC",$cadena);
    //             $palabras = Str::of($cadena)->explode(' ');
    //             $palabras3 = $palabras->filter(function($palabra){
    //                 return Str::length($palabra) == 3;
    //             });
    //             foreach ($palabras3 as $word) {
    //                 $this->ruta = $this->ruta . $word . "/";
    //             }
    //             $this->ruta = substr($this->ruta,0,strlen($this->ruta)-1);

    //             $dest = str_replace("/","",$this->ruta);
    //             $incioCadena = round(((strlen($dest) / 3) / 2),0,PHP_ROUND_HALF_DOWN) * 3;
    //             $this->destino =  substr($dest, $incioCadena, 3);
    //         }

    //         //Obtener Forma de Pago
    //         $posFpago = strpos($linea,"FORM OF PAYMENT:");
    //         if ($posFpago !== false){
    //             if(strpos($linea,"CA")){
    //                 $oTc = TarjetaCredito::where('codigo','XX')->first();
    //                 $this->idTarjetaCredito = $oTc->id;
    //                 $oMp = MedioPago::where('codigo','009')->first();
    //                 $this->idMedioPago = $oMp->id;
    //             }
    //             if(strpos($linea,"VISA")){
    //                 $oTc = TarjetaCredito::where('codigo','VI')->first();
    //                 $this->idTarjetaCredito = $oTc->id;
    //                 $oMp = MedioPago::where('codigo','006')->first();
    //                 $this->idMedioPago = $oMp->id;
    //             }
    //             if(strpos($linea,"MASTERCARD")){
    //                 $oTc = TarjetaCredito::where('codigo','MA')->first();
    //                 $this->idTarjetaCredito = $oTc->id;
    //                 $oMp = MedioPago::where('codigo','006')->first();
    //                 $this->idMedioPago = $oMp->id;
    //             }
    //             if(strpos($linea,"MASTER CARD")){
    //                 $oTc = TarjetaCredito::where('codigo','MA')->first();
    //                 $this->idTarjetaCredito = $oTc->id;
    //                 $oMp = MedioPago::where('codigo','006')->first();
    //                 $this->idMedioPago = $oMp->id;
    //             }
    //             if(strpos($linea,"DINERS CLUB")){
    //                 $oTc = TarjetaCredito::where('codigo','DC')->first();
    //                 $this->idTarjetaCredito = $oTc->id;
    //                 $oMp = MedioPago::where('codigo','006')->first();
    //                 $this->idMedioPago = $oMp->id;
    //             }
    //             if(strpos($linea,"AMERICAN EXPRESS")){
    //                 $oTc = TarjetaCredito::where('codigo','AX')->first();
    //                 $this->idTarjetaCredito = $oTc->id;
    //                 $oMp = MedioPago::where('codigo','006')->first();
    //                 $this->idMedioPago = $oMp->id;
    //             }
    //         }
    //     }
    //     // dd($this->idAerolinea);
    // }

    public function parsearSabre($boleto){
        $area = Area::find(1);
        $boleto = new Boleto();
        $funciones = new Funciones();
        $boleto->numeroBoleto = '9159120387';

        $file = $funciones->generaFile('FILES');
        $boleto->numeroFile = $area->codigo . str_pad($file,7,"0",STR_PAD_LEFT);
        $boleto->idCliente = 2;
        $boleto->idSolicitante = 1;
        $boleto->fechaEmision = '2023-09-23';
        $boleto->idCounter = 2;
        $boleto->idTipoFacturacion = 1;
        $boleto->idTipoDocumento = 6;
        $boleto->idArea = 1;
        $boleto->idVendedor = 1;
        $boleto->idConsolidador = 1;
        $boleto->codigoReserva = 'LLTNSF';
        $boleto->fechaReserva = '2023-09-23';
        $boleto->idGds = 1;
        $boleto->idTipoTicket = 1;
        $boleto->tipoRuta = "INTERNACIONAL";
        $boleto->tipoTarifa = 'NORMAL';
        $boleto->idAerolinea = 2;
        $boleto->origen = 'BSP';
        $boleto->pasajero = 'ALZATE JORGE';
        $boleto->idTipoPasajero = 1;
        $boleto->ruta = 'BOG/LIM/BOG';
        $boleto->destino = 'LIM';
        $boleto->tipoCambio = 3.900;
        $boleto->idMoneda = 1;
        $boleto->tarifaNeta = 700.00;
        $boleto->igv = 0;
        $boleto->otrosImpuestos = 187.27;
        $boleto->xm = 0;
        $boleto->total = 887.27;
        $boleto->totalOrigen = 887.27;
        $boleto->porcentajeComision = 0;
        $boleto->montoComision = 0;
        $boleto->descuentoCorporativo = 0;
        $boleto->codigoDescCorp = ' ';
        $boleto->tarifaNormal = 0;
        $boleto->tarifaAlta = 0;
        $boleto->tarifaBaja = 0;
        $boleto->idTipoPagoConsolidador = 6;
        $boleto->centroCosto = ' ';
        $boleto->cod1 = ' ';
        $boleto->cod2 = ' ';
        $boleto->cod3 = ' ';
        $boleto->cod4 = ' ';
        $boleto->observaciones = ' ';
        $boleto->estado = 1;
        $boleto->usuarioCreacion = auth()->user()->id;
        try {
            $boleto->save();
            $this->grabarRutasSabre1($boleto->id);
            $this->grabarRutasSabre2($boleto->id);
            $this->grabarPagosSabre($boleto->id);
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrió un error intentando grabar.');
        }
    }
    public function parsearKiu($boleto){
        $area = Area::find(1);
        $boleto = new Boleto();
        $funciones = new Funciones();
        $boleto->numeroBoleto = '3104677145';

        $file = $funciones->generaFile('FILES');
        $boleto->numeroFile = $area->codigo . str_pad($file,7,"0",STR_PAD_LEFT);
        $boleto->idCliente = 3;
        $boleto->idSolicitante = 1;
        $boleto->fechaEmision = '2023-09-19';
        $boleto->idCounter = 2;
        $boleto->idTipoFacturacion = 1;
        $boleto->idTipoDocumento = 6;
        $boleto->idArea = 1;
        $boleto->idVendedor = 1;
        $boleto->idConsolidador = 1;
        $boleto->codigoReserva = 'CVWPZG';
        $boleto->fechaReserva = '2023-09-19';
        $boleto->idGds = 2;
        $boleto->idTipoTicket = 1;
        $boleto->tipoRuta = "NACIONAL";
        $boleto->tipoTarifa = 'NORMAL';
        $boleto->idAerolinea = 3;
        $boleto->origen = 'BSP';
        $boleto->pasajero = 'VASQUEZ CLARA DEL CA';
        $boleto->idTipoPasajero = 1;
        $boleto->ruta = 'IQT/PCL/IQT';
        $boleto->destino = 'PCL';
        $boleto->tipoCambio = 3.900;
        $boleto->idMoneda = 1;
        $boleto->tarifaNeta = 178.00;
        $boleto->igv = 32.04;
        $boleto->otrosImpuestos = 13.52;
        $boleto->xm = 0;
        $boleto->total = 223.56;
        $boleto->totalOrigen = 223.56;
        $boleto->porcentajeComision = 0;
        $boleto->montoComision = 0;
        $boleto->descuentoCorporativo = 0;
        $boleto->codigoDescCorp = ' ';
        $boleto->tarifaNormal = 0;
        $boleto->tarifaAlta = 0;
        $boleto->tarifaBaja = 0;
        $boleto->idTipoPagoConsolidador = 6;
        $boleto->centroCosto = ' ';
        $boleto->cod1 = ' ';
        $boleto->cod2 = ' ';
        $boleto->cod3 = ' ';
        $boleto->cod4 = ' ';
        $boleto->observaciones = ' ';
        $boleto->estado = 1;
        $boleto->usuarioCreacion = auth()->user()->id;
        try {
            $boleto->save();
            $this->grabarRutasKiu1($boleto->id);
            $this->grabarRutasKiu2($boleto->id);
            $this->grabarPagosKiu($boleto->id);
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrió un error intentando grabar.');
        }
        
    }

    public function parsearNdc($boleto){
        $area = Area::find(1);
        $boleto = new Boleto();
        $funciones = new Funciones();
        $boleto->numeroBoleto = '2127585576';

        $file = $funciones->generaFile('FILES');
        $boleto->numeroFile = $area->codigo . str_pad($file,7,"0",STR_PAD_LEFT);
        $boleto->idCliente = 1;
        $boleto->idSolicitante = 1;
        $boleto->fechaEmision = '2023-10-03';
        $boleto->idCounter = 1;
        $boleto->idTipoFacturacion = 2;
        $boleto->idTipoDocumento = 6;
        $boleto->idArea = 1;
        $boleto->idVendedor = 1;
        $boleto->idConsolidador = 1;
        $boleto->codigoReserva = 'LOIIIB';
        $boleto->fechaReserva = '2023-10-03';
        $boleto->idGds = 3;
        $boleto->idTipoTicket = 1;
        $boleto->tipoRuta = "NACIONAL";
        $boleto->tipoTarifa = 'NORMAL';
        $boleto->idAerolinea = 1;
        $boleto->origen = 'BSP';
        $boleto->pasajero = 'LOZANO MONTALVO ROGER';
        $boleto->idTipoPasajero = 1;
        $boleto->ruta = 'LIM/PCL/LIM';
        $boleto->destino = 'PCL';
        $boleto->tipoCambio = 3.900;
        $boleto->idMoneda = 1;
        $boleto->tarifaNeta = 97.00;
        $boleto->igv = 17.46;
        $boleto->otrosImpuestos = 18.89;
        $boleto->xm = 0;
        $boleto->total = 133.35;
        $boleto->totalOrigen = 133.35;
        $boleto->porcentajeComision = 0;
        $boleto->montoComision = 0;
        $boleto->descuentoCorporativo = 0;
        $boleto->codigoDescCorp = ' ';
        $boleto->tarifaNormal = 0;
        $boleto->tarifaAlta = 0;
        $boleto->tarifaBaja = 0;
        $boleto->idTipoPagoConsolidador = 6;
        $boleto->centroCosto = ' ';
        $boleto->cod1 = ' ';
        $boleto->cod2 = ' ';
        $boleto->cod3 = ' ';
        $boleto->cod4 = ' ';
        $boleto->observaciones = ' ';
        $boleto->estado = 1;
        $boleto->usuarioCreacion = auth()->user()->id;
        try {
            $boleto->save();
            $this->grabarRutasNdc1($boleto->id);
            $this->grabarRutasNdc2($boleto->id);
            $this->grabarPagosNdc($boleto->id);
            return redirect()->to('listaBoletos');
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrió un error intentando grabar.');
        }
         
    }
    public function grabarRutasNdc1($idBoleto){
        $boletoRuta = new BoletoRuta();
        $boletoRuta->idBoleto = $idBoleto;
        $boletoRuta->idAerolinea = 1;
        $boletoRuta->ciudadSalida = 'LIM';
        $boletoRuta->ciudadLlegada = 'PCL';
        $boletoRuta->vuelo = ' ';
        $boletoRuta->clase = 'S';
        $boletoRuta->fechaSalida = '2023-10-06';
        $boletoRuta->horaSalida = '1425';
        $boletoRuta->fechaLlegada = '2023-10-06';
        $boletoRuta->horaLlegada = '1545';
        $boletoRuta->farebasis = 'S00QP5ZB';
        $boletoRuta->idEstado = 1;
        $boletoRuta->usuarioCreacion = auth()->user()->id;
        $boletoRuta->save();
    }
    public function grabarRutasNdc2($idBoleto){
        $boletoRuta = new BoletoRuta();
        $boletoRuta->idBoleto = $idBoleto;
        $boletoRuta->idAerolinea = 1;
        $boletoRuta->ciudadSalida = 'PCL';
        $boletoRuta->ciudadLlegada = 'LIM';
        $boletoRuta->vuelo = ' ';
        $boletoRuta->clase = 'X';
        $boletoRuta->fechaSalida = '2023-10-15';
        $boletoRuta->horaSalida = '1310';
        $boletoRuta->fechaLlegada = '2023-10-15';
        $boletoRuta->horaLlegada = '1425';
        $boletoRuta->farebasis = 'X00QP5ZB';
        $boletoRuta->idEstado = 1;
        $boletoRuta->usuarioCreacion = auth()->user()->id;
        $boletoRuta->save();
    }
    public function grabarPagosNdc($idBoleto){
        $boletoPago = new BoletoPago();
        $boletoPago->idBoleto = $idBoleto;
        $boletoPago->idMedioPago = 6;
        $boletoPago->idTarjetaCredito = 2;
        $boletoPago->numeroTarjeta = ' ';
        $boletoPago->monto = 133.35;
        $boletoPago->fechaVencimientoTC = ' ';
        $boletoPago->idEstado = 1;
        $boletoPago->usuarioCreacion = auth()->user()->id;
        $boletoPago->save();
    }

    public function grabarRutasKiu1($idBoleto){
        $boletoRuta = new BoletoRuta();
        $boletoRuta->idBoleto = $idBoleto;
        $boletoRuta->idAerolinea = 3;
        $boletoRuta->ciudadSalida = 'IQT';
        $boletoRuta->ciudadLlegada = 'PCL';
        $boletoRuta->vuelo = '2I3132';
        $boletoRuta->clase = 'W';
        $boletoRuta->fechaSalida = '2023-09-25';
        $boletoRuta->horaSalida = '1500';
        $boletoRuta->fechaLlegada = '2023-09-25';
        $boletoRuta->horaLlegada = '1600';
        $boletoRuta->farebasis = 'WOW';
        $boletoRuta->idEstado = 1;
        $boletoRuta->usuarioCreacion = auth()->user()->id;
        $boletoRuta->save();
    }
    public function grabarRutasKiu2($idBoleto){
        $boletoRuta = new BoletoRuta();
        $boletoRuta->idBoleto = $idBoleto;
        $boletoRuta->idAerolinea = 3;
        $boletoRuta->ciudadSalida = 'PCL';
        $boletoRuta->ciudadLlegada = 'IQT';
        $boletoRuta->vuelo = '2I3131';
        $boletoRuta->clase = 'W';
        $boletoRuta->fechaSalida = '2023-09-30';
        $boletoRuta->horaSalida = '1325';
        $boletoRuta->fechaLlegada = '2023-09-30';
        $boletoRuta->horaLlegada = '1425';
        $boletoRuta->farebasis = 'WOW';
        $boletoRuta->idEstado = 1;
        $boletoRuta->usuarioCreacion = auth()->user()->id;
        $boletoRuta->save();
    }
    public function grabarPagosKiu($idBoleto){
        $boletoPago = new BoletoPago();
        $boletoPago->idBoleto = $idBoleto;
        $boletoPago->idMedioPago = 9;
        $boletoPago->idTarjetaCredito = 1;
        $boletoPago->numeroTarjeta = ' ';
        $boletoPago->monto = 223.56;
        $boletoPago->fechaVencimientoTC = ' ';
        $boletoPago->idEstado = 1;
        $boletoPago->usuarioCreacion = auth()->user()->id;
        $boletoPago->save();
    }

    public function grabarRutasSabre1($idBoleto){
        $boletoRuta = new BoletoRuta();
        $boletoRuta->idBoleto = $idBoleto;
        $boletoRuta->idAerolinea = 2;
        $boletoRuta->ciudadSalida = 'BOG';
        $boletoRuta->ciudadLlegada = 'LIM';
        $boletoRuta->vuelo = '75';
        $boletoRuta->clase = 'E';
        $boletoRuta->fechaSalida = '2023-09-20';
        $boletoRuta->horaSalida = '2130';
        $boletoRuta->fechaLlegada = '2023-09-20';
        $boletoRuta->horaLlegada = '0040';
        $boletoRuta->farebasis = 'EEOB2BRG';
        $boletoRuta->idEstado = 1;
        $boletoRuta->usuarioCreacion = auth()->user()->id;
        $boletoRuta->save();
    }
    public function grabarRutasSabre2($idBoleto){
        $boletoRuta = new BoletoRuta();
        $boletoRuta->idBoleto = $idBoleto;
        $boletoRuta->idAerolinea = 2;
        $boletoRuta->ciudadSalida = 'BOG';
        $boletoRuta->ciudadLlegada = 'LIM';
        $boletoRuta->vuelo = '52';
        $boletoRuta->clase = 'L';
        $boletoRuta->fechaSalida = '2023-09-22';
        $boletoRuta->horaSalida = '1840';
        $boletoRuta->fechaLlegada = '2023-09-22';
        $boletoRuta->horaLlegada = '2150';
        $boletoRuta->farebasis = 'LEOB2BRG';
        $boletoRuta->idEstado = 1;
        $boletoRuta->usuarioCreacion = auth()->user()->id;
        $boletoRuta->save();
    }
    public function grabarPagosSabre($idBoleto){
        $boletoPago = new BoletoPago();
        $boletoPago->idBoleto = $idBoleto;
        $boletoPago->idMedioPago = 6;
        $boletoPago->idTarjetaCredito = 2;
        $boletoPago->numeroTarjeta = ' ';
        $boletoPago->monto = 887.27;
        $boletoPago->fechaVencimientoTC = ' ';
        $boletoPago->idEstado = 1;
        $boletoPago->usuarioCreacion = auth()->user()->id;
        $boletoPago->save();
    }
}
