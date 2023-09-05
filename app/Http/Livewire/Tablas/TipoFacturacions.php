<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\TipoFacturacionExport;
use App\Models\TipoFacturacion;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TipoFacturacions extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'descripcion';
    public $direction = 'asc';
    public $idRegistro, $descripcion;

    public function rules(){
        return[
            'descripcion'  => 'required'
        ];
    }

    protected $messages = [
        'descripcion.required' => 'El campo Descripcion no puede estar en blanco.'
    ];

    public function render()
    {
        $tipoFacturacions = TipoFacturacion::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.tipo-facturacions', compact('tipoFacturacions'));
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

        $tipoFacturacion = new TipoFacturacion();
        $tipoFacturacion->descripcion = $this->descripcion;
        $tipoFacturacion->usuarioCreacion = auth()->user()->id;

        $tipoFacturacion->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
    }

    public function editar($id){
        $tipoFacturacion = TipoFacturacion::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tipoFacturacion->id;
        $this->descripcion = $tipoFacturacion->descripcion;
    }

    public function actualizar($id){
        $tipoFacturacion = TipoFacturacion::find($id);
        $tipoFacturacion->descripcion = $this->descripcion;
        $tipoFacturacion->usuarioModificacion = auth()->user()->id;
        $tipoFacturacion->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $tipoFacturacion = TipoFacturacion::find($id);
        $this->idRegistro = $tipoFacturacion->id;
        $this->descripcion = $tipoFacturacion->descripcion;
    }

    public function eliminar($id){
        $tipoFacturacion = TipoFacturacion::find($id);
        $tipoFacturacion->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new TipoFacturacionExport,'TipoFacturacion.xlsx');
    }
}
