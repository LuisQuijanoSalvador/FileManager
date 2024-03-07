<?php

namespace App\Http\Livewire\Files;

use Livewire\Component;
use App\Models\File;
use App\Models\Cliente;
use App\Models\Solicitante;

class EditarFiles extends Component
{
    public $numeroFile, $descripcion, $cliente, $area;
    public $solicitantes;

    public function mount(){
        $file = File::find(request()->route('id'));
        $this->numeroFile = $file->numeroFile;
        $this->descripcion = $file->descripcion;
        $this->cliente = $file->tCliente->razonSocial;
        $this->area = $file->tArea->descripcion;
    }
    public function render()
    {
        
        $clientes = Cliente::all()->sortBy('razonSocial');
        return view('livewire.files.editar-files',compact('clientes'));
    }

    public function buscar(){
        
        $this->solicitantes = Solicitante::where('cliente', $cliente_id)->get();
    }
}
