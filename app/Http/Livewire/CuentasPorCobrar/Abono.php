<?php

namespace App\Http\Livewire\CuentasPorCobrar;

use Livewire\Component;
use App\Models\Cargo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\MedioPago;
use App\Models\TarjetaCredito;
use App\Models\Banco;
use App\Models\moneda;
use App\Models\TipoCambio;

class Abono extends Component
{
    protected $cargos;
    public $fechaInicio, $fechaFin, $idCliente;
    public $fechaAbono, $monto, $moneda=1, $tipoCambio, $idMedioPago=3, $referencia,
            $idBanco, $numeroCuenta, $idTarjetaCredito=1, $observaciones, $idEstado;
    protected $cargosAbono=[];

    public $selectedRows = [];

    public function mount(){
        $fechaActual = Carbon::now();
        $fecIni = Carbon::now();
        $this->fechaInicio = Carbon::parse($fecIni->subDays(15))->format("Y-m-d");
        $this->fechaFin = Carbon::parse($fechaActual)->format("Y-m-d");
        $this->fechaAbono = Carbon::parse($fechaActual)->format("Y-m-d");

        $this->cargos = DB::select('CALL get_cargos_fechas(?, ?)', [$this->fechaInicio, $this->fechaFin]);

        $tipoCambio = TipoCambio::where('fechaCambio',$this->fechaAbono)->first();
        if($tipoCambio){
            $this->tipoCambio = $tipoCambio->montoCambio;
        }else{
            $this->tipoCambio = 0.00;
        }

    }

    public function updatedfechaAbono($fechaAbono){
        $tipoCambio = TipoCambio::where('fechaCambio',$fechaAbono)->first();
        if($tipoCambio){
            $this->tipoCambio = $tipoCambio->montoCambio;
        }else{
            $this->tipoCambio = 0.00;
        }
        $this->dispatchBrowserEvent('tipoCambioUpdated');
    }

    public function render()
    {
        $medioPagos = MedioPago::all()->sortBy('descripcion');
        $monedas = moneda::all()->sortBy('codigo');
        $bancos = Banco::all()->sortBy('nombre');
        $tarjetaCreditos = TarjetaCredito::all()->sortBy('descripcion');
        $clientes = Cliente::all()->sortBy('razonSocial');
        return view('livewire.cuentas-por-cobrar.abono', compact('clientes','medioPagos','tarjetaCreditos',
                                                                'bancos','monedas'));
    }

    public function filtrar(){
        $this->cargos = DB::select('CALL get_cargos_fechasCliente(?, ?, ?)', [$this->fechaInicio, $this->fechaFin, $this->idCliente]);
    }

    public function abrirModal(){
        // $this->cargosAbono =Cargo::whereIn('id',$this->selectedRows);
        // $serializedIds = serialize($this->selectedRows);
        $jsonIds = json_encode($this->selectedRows);
        // return redirect()->route('rAbonopago', ['ids' => $jsonIds]);
        return redirect()->route('rAbonopago');
    }

}
