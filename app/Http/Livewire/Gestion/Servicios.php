<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use Livewire\WithPagination;

class Servicios extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.gestion.servicios');
    }
}
