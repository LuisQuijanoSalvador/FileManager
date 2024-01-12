<?php

namespace App\Http\Livewire\CuentasPorCobrar;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Cargo;

class EstadoCuenta extends Component
{
    public $clientes, $idCliente, $fechaInicio, $fechaFinal;

    public function mount(){
        $this->clientes = Cliente::all()->sortBy('razonSocial');
    }

    public function render()
    {
        return view('livewire.cuentas-por-cobrar.estado-cuenta');
    }

    public function buscar(){

    }
}
