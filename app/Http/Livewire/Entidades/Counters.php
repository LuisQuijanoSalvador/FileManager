<?php

namespace App\Http\Livewire\Entidades;

use App\Exports\CounterExport;
use App\Models\Counter;
use App\Models\Estado;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Counters extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'nombre';
    public $direction = 'asc';

    public $idRegistro, $nombre, $codigo,$estado;

    public function rules(){
        return[
            'nombre'      => 'required',
            'codigo'     => 'required',
            'estado'  => 'required'
        ];
    }

    protected $messages = [
        'nombre.required' => 'El campo Nombre no puede estar en blanco.',
        'codigo.required' => 'El campo Codigo no puede estar en blanco.',
        'estado.required' => 'Debe seleccionar una opcion.',
    ];

    public function render()
    {
        $counters = Counter::where('nombre', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        
        $estados = Estado::all()->sortBy('descripcion');

        return view('livewire.entidades.counters', compact('counters','estados'));
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

        $counter = new Counter();
        $counter->nombre = $this->nombre;
        $counter->codigo = $this->codigo;
        $counter->estado = $this->estado;
        $counter->usuarioCreacion = auth()->user()->id;
        $counter->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->nombre = "";
        $this->codigo = "";
        $this->estado = "";
    }

    public function editar($id){
        $counter = Counter::find($id);
        $this->limpiarControles();
        $this->idRegistro = $counter->id;
        $this->nombre = $counter->nombre;
        $this->codigo = $counter->codigo;
        $this->estado = $counter->estado;
    }

    public function actualizar($id){
        $counter = Counter::find($id);
        $counter->name = $this->name;
        $counter->codigo = $this->codigo;
        $counter->estado = $this->estado;
        $counter->usuarioModificacion = auth()->user()->id;
        $counter->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $counter = Counter::find($id);
        $this->idRegistro = $counter->id;
        $this->nombre = $counter->nombre;
    }

    public function eliminar($id){
        $counter = Counter::find($id);
        $counter->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new CounterExport(),'Counters.xlsx');
    }
}
