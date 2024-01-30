<?php

namespace App\Http\Livewire\CuentasPorCobrar;

use Livewire\Component;

class Abonopago extends Component
{
    public $selectedIds;

    public function mount($ids){
        $this->selectedIds = $ids;
    }
    public function render()
    {
        return view('livewire.cuentas-por-cobrar.abonopago');
    }
}
