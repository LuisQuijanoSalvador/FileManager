<?php

namespace App\Http\Livewire\Files;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Solicitante;

class EditarFiles extends Component
{
    public $solicitantes;
    public function render()
    {
        $clientes = Cliente::all()->sortBy('razonSocial');
        return view('livewire.files.editar-files',compact('clientes'));
    }

    public function buscar(){
        
        $this->solicitantes = Solicitante::where('cliente', $cliente_id)->get();
    }
}
