<?php

namespace App\Http\Livewire\CuentasPorCobrar;

use Livewire\Component;
use App\Models\Cargo;

class Abono extends Component
{
    protected $margenes;
    public $fechaInicio, $fechaFin;

    public function mount(){
        $fechaActual = Carbon::now();
        
        $this->fechaInicio = Carbon::parse($fechaActual)->format("Y-m-d");
        $this->fechaFin = Carbon::parse($fechaActual)->format("Y-m-d");
    }
    public function render()
    {
        return view('livewire.cuentas-por-cobrar.abono');
    }
}
