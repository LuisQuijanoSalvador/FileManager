<?php

namespace App\Http\Livewire\CuentasPorCobrar;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Cargo;

class EstadoCuenta extends Component
{
    public $clientes, $idCliente, $fechaInicio, $fechaFinal,$estadoCuentas;
    // protected $estadoCuenta = null;

    public function mount(){
        $this->clientes = Cliente::all()->sortBy('razonSocial');
        // $this->estadoCuenta = collect();
    }

    public function render()
    {
        // $estCuentas = $this->estadoCuenta;
        return view('livewire.cuentas-por-cobrar.estado-cuenta');
        
    }

    public function buscar(){
        $this->estadoCuentas = NULL;
        // dd($this->estadoCuenta);
        $this->estadoCuentas = Cargo::where('idCliente', $this->idCliente)
                                    ->where('idEstado',1)
                                    ->where('saldo','>',0)
                                    ->whereBetween('fechaEmision', [$this->fechaInicio, $this->fechaFinal])
                                    ->orderBy('fechaEmision', 'asc')
                                    ->get();
        // dd($this->estadoCuentas);      
    }
}
