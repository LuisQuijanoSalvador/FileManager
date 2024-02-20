<?php

namespace App\Http\Livewire\CuentasPorCobrar;

use Livewire\Component;
use App\Models\MedioPago;
use App\Models\TarjetaCredito;
use App\Models\Banco;
use App\Models\moneda;
use App\Models\TipoCambio;
use Carbon\Carbon;
use App\Models\Cargo;
use App\Models\Abono;

class Abonopago extends Component
{
    public $selectedIds, $datos, $fechaAbono, $tipoCambio, $moneda = 1, $idBanco = 2, $idTarjetaCredito = 1,
    $idMedioPago = 1, $observaciones = '', $referencia = '';
    public $pagos = [];

    public function mount(){
        $fechaActual = Carbon::now();
        
        $this->fechaAbono = Carbon::parse($fechaActual)->format("Y-m-d");

        $tipoCambio = TipoCambio::where('fechaCambio',$this->fechaAbono)->first();
        if($tipoCambio){
            $this->tipoCambio = $tipoCambio->montoCambio;
        }else{
            $this->tipoCambio = 0.00;
        }
    }

    public function render()
    {
        $medioPagos = MedioPago::all()->sortBy('descripcion');
        $tarjetaCreditos = TarjetaCredito::all()->sortBy('descripcion');
        $bancos = Banco::all()->sortBy('nombre');
        $monedas = moneda::all()->sortBy('codigo');
        $cargos = Cargo::whereIn('id', $this->datos)->get();
        // dd($cargos);
        return view('livewire.cuentas-por-cobrar.abonopago',compact('medioPagos','tarjetaCreditos','bancos',
                                                            'monedas','cargos'));
    }

    public function abonar(){
        foreach ($this->pagos as $id => $pago) {
            // Guarda el pago correspondiente al ID en tu base de datos o en otra ubicación
            // Por ejemplo:
            // Cargo::find($id)->update(['saldo' => $pago]);
            $cargo = Cargo::find($id);
            $cargo->saldo = $cargo->montoCargo - $pago;
            $cargo->save();
            
            $abono = new Abono();
            $abono->idCargo = $id;
            $abono->fechaAbono = $this->fechaAbono;
            $abono->monto = $pago;
            $abono->moneda = $this->moneda;
            $abono->tipoCambio = $this->tipoCambio;
            $abono->idMedioPago = $this->idMedioPago;
            $abono->referencia = $this->referencia;
            $abono->idBanco = $this->idBanco;
            $banco = Banco::find($this->idBanco);
            $abono->numeroCuenta = $banco->numeroCuenta;
            $abono->idTarjetaCredito = $this->idTarjetaCredito;
            $abono->observaciones = $this->observaciones;
            $abono->idEstado = 1;
            $abono->usuarioCreacion = auth()->user()->id;
            $abono->save();

            return redirect()->route('rAbonos');
        }
    }
}
