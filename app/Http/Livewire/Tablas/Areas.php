<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\AreaExport;
use App\Models\Area;
use App\Models\Estado;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Areas extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'descripcion';
    public $direction = 'asc';

    public $idRegistro, $descripcion, $codigo,$estado;

    public function rules(){
        return[
            'descripcion'      => 'required',
            'codigo'     => 'required',
            'estado'  => 'required'
        ];
    }

    protected $messages = [
        'descripcion.required' => 'El campo Descripcion no puede estar en blanco.',
        'codigo.required' => 'El campo Codigo no puede estar en blanco.',
        'estado.required' => 'Debe seleccionar una opcion.',
    ];

    public function render()
    {
        $areas = Area::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.tablas.areas', compact('areas','estados'));
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

        $area = new Area();
        $area->descripcion  = $this->descripcion;
        $area->codigo = $this->codigo;
        $area->estado = $this->estado;
        $area->usuarioCreacion = auth()->user()->id;
        $area->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->codigo = "";
        $this->estado = "";
    }

    public function editar($id){
        $area = Area::find($id);
        $this->limpiarControles();
        $this->idRegistro = $area->id;
        $this->descripcion = $area->descripcion;
        $this->codigo = $area->codigo;
        $this->estado = $area->estado;
    }

    public function actualizar($id){
        $area = Area::find($id);
        $area->descipcion = $this->descripcion;
        $area->codigo = $this->codigo;
        $area->estado = $this->estado;
        $area->usuarioModificacion = auth()->user()->id;
        $area->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $area = Area::find($id);
        $this->idRegistro = $area->id;
        $this->descripcion = $area->descripcion;
    }

    public function eliminar($id){
        $area = Area::find($id);
        $area->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new AreaExport(),'Areas.xlsx');
    }
}
