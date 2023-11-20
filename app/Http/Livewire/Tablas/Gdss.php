<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\GdsExport;
use App\Models\Estado;
use App\Models\Gds;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Gdss extends Component
{
    use WithPagination;

    public $search = "";
    public $sort= 'descripcion';
    public $direction = 'asc';

    public $idRegistro, $descripcion,$estado;

    public function rules(){
        return[
            'descripcion'      => 'required',
            'estado'  => 'required'
        ];
    }

    protected $messages = [
        'descripcion.required' => 'El campo Descripcion no puede estar en blanco.',
        'estado.required' => 'Debe seleccionar una opcion.',
    ];

    public function render()
    {
        $gdss = Gds::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.tablas.gdss', compact('gdss','estados'));
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

        $gds = new Gds();
        $gds->descripcion  = $this->descripcion;
        $gds->estado = $this->estado;
        $gds->usuarioCreacion = auth()->user()->id;
        $gds->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->estado = "";
    }

    public function editar($id){
        $gds = Gds::find($id);
        $this->limpiarControles();
        $this->idRegistro = $gds->id;
        $this->descripcion = $gds->descripcion;
        $this->estado = $gds->estado;
    }

    public function actualizar($id){
        $gds = Gds::find($id);
        $gds->descripcion  = $this->descripcion;
        $gds->estado = $this->estado;
        $gds->usuarioModificacion = auth()->user()->id;
        $gds->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $gds = Gds::find($id);
        $this->idRegistro = $gds->id;
        $this->descripcion = $gds->descripcion;
    }

    public function eliminar($id){
        $gds = Gds::find($id);
        $gds->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new GdsExport(),'Gds.xlsx');
    }
}
