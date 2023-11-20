<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\TipoTicketExport;
use App\Models\Estado;
use App\Models\TipoTicket;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TipoTickets extends Component
{
    use WithPagination;

    public $search = "";
    public $sort= 'descripcion';
    public $direction = 'asc';

    public $idRegistro, $descripcion,$estado;

    public function rules(){
        return[
            'descripcion'   => 'required',
            'estado'        => 'required'
        ];
    }

    protected $messages = [
        'descripcion.required' => 'El campo Descripcion no puede estar en blanco.',
        'estado.required' => 'Debe seleccionar una opcion.',
    ];

    public function render()
    {
        $tipoTickets = TipoTicket::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.tablas.tipo-tickets', compact('tipoTickets','estados'));
    }

    public function order($sort){
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'desc';
        }
    }

    public function grabar(){
        $this->validate();

        $tipoTicket = new TipoTicket();
        $tipoTicket->descripcion  = $this->descripcion;
        $tipoTicket->estado = $this->estado;
        $tipoTicket->usuarioCreacion = auth()->user()->id;
        $tipoTicket->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->estado = "";
    }

    public function editar($id){
        $tipoTicket = TipoTicket::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tipoTicket->id;
        $this->descripcion = $tipoTicket->descripcion;
        $this->estado = $tipoTicket->estado;
    }

    public function actualizar($id){
        $tipoTicket = TipoTicket::find($id);
        $tipoTicket->descripcion  = $this->descripcion;
        $tipoTicket->estado = $this->estado;
        $tipoTicket->usuarioModificacion = auth()->user()->id;
        $tipoTicket->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $tipoTicket = TipoTicket::find($id);
        $this->idRegistro = $tipoTicket->id;
        $this->descripcion = $tipoTicket->descripcion;
    }

    public function eliminar($id){
        $tipoTicket = TipoTicket::find($id);
        $tipoTicket->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new TipoTicketExport(),'TipoTickets.xlsx');
    }
}
