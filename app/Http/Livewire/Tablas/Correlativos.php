<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\CorrelativoExport;
use App\Models\Correlativo;
use App\Models\Estado;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Correlativos extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'tabla';
    public $direction = 'asc';

    public $idRegistro, $tabla, $numero,$estado;

    public function rules(){
        return[
            'tabla'      => 'required',
            'numero'     => 'required',
            'estado'     => 'required'
        ];
    }

    protected $messages = [
        'tabla.required' => 'Este campo es requerido.',
        'numero.required' => 'Este campo es requerido.',
        'estado.required' => 'Debe seleccionar una opcion.',
    ];

    public function render()
    {
        $correlativos = Correlativo::where('tabla', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.tablas.correlativos', compact('correlativos','estados'));
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

        $correlativos = new Correlativo();
        $correlativos->tabla  = $this->tabla;
        $correlativos->numero = $this->numero;
        $correlativos->estado = $this->estado;
        $correlativos->usuarioCreacion = auth()->user()->id;
        $correlativos->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->tabla = "";
        $this->numero = "";
        $this->estado = "";
    }

    public function editar($id){
        $correlativo = Correlativo::find($id);
        $this->limpiarControles();
        $this->idRegistro = $correlativo->id;
        $this->tabla = $correlativo->tabla;
        $this->numero = $correlativo->numero;
        $this->estado = $correlativo->estado;
    }

    public function actualizar($id){
        $correlativo = Correlativo::find($id);
        $correlativo->tabla = $this->tabla;
        $correlativo->numero = $this->numero;
        $correlativo->estado = $this->estado;
        $correlativo->usuarioModificacion = auth()->user()->id;
        $correlativo->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $correlativo = Correlativo::find($id);
        $this->idRegistro = $correlativo->id;
        $this->tabla = $correlativo->tabla;
    }

    public function eliminar($id){
        $correlativo = Correlativo::find($id);
        $correlativo->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new CorrelativoExport(),'Correlativos.xlsx');
    }
}
