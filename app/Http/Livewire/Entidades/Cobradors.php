<?php

namespace App\Http\Livewire\Entidades;

use App\Exports\CobradorExport;
use App\Models\Cobrador;
use App\Models\Estado;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Cobradors extends Component
{
    use WithPagination;

    public $search = "";
    public $sort= 'nombre';
    public $direction = 'asc';

    public $idRegistro, $nombre,$estado;

    public function rules(){
        return[
            'nombre'      => 'required',
            'estado'  => 'required'
        ];
    }

    protected $messages = [
        'nombre.required' => 'El campo Nombre no puede estar en blanco.',
        'estado.required' => 'Debe seleccionar una opcion.',
    ];

    public function render()
    {
        $cobradors = Cobrador::where('nombre', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.entidades.cobradors', compact('cobradors','estados'));
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

        $cobrador = new Cobrador();
        $cobrador->nombre = $this->nombre;
        $cobrador->estado = $this->estado;
        $cobrador->usuarioCreacion = auth()->user()->id;
        $cobrador->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->nombre = "";
        $this->estado = "";
    }

    public function editar($id){
        $cobrador = Cobrador::find($id);
        $this->limpiarControles();
        $this->idRegistro = $cobrador->id;
        $this->nombre = $cobrador->nombre;
        $this->estado = $cobrador->estado;
    }

    public function actualizar($id){
        $cobrador = Cobrador::find($id);
        $cobrador->name = $this->name;
        $cobrador->estado = $this->estado;
        $cobrador->usuarioModificacion = auth()->user()->id;
        $cobrador->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $cobrador = Cobrador::find($id);
        $this->idRegistro = $cobrador->id;
        $this->nombre = $cobrador->nombre;
    }

    public function eliminar($id){
        $cobrador = Cobrador::find($id);
        $cobrador->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new CobradorExport,'Cobradores.xlsx');
    }
}
