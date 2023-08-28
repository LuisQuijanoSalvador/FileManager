<?php

namespace App\Http\Livewire\Tablas;

use Livewire\Component;
use App\Models\Estado;
use Livewire\WithPagination;

class Estados extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'descripcion';
    public $direction = 'asc';
    public $idRegistro, $descripcion;

    protected $messages = [
        'descripcion.required' => 'El campo Descripcion no puede estar en blanco.',
    ];
    public function rules(){
        return[
            'descripcion'      => 'required',
        ];
    }
    public function render()
    {
        $estados = Estado::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.estados', compact('estados'));
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

        $estado = new Estado();
        $estado->descripcion = $this->descripcion;

        $estado->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }
    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
    }
    public function editar($id){
        $estado = Estado::find($id);
        $this->limpiarControles();
        $this->idRegistro = $estado->id;
        $this->descripcion = $estado->descripcion;
    }
    public function actualizar($id){
        $estado = Estado::find($id);
        $estado->descripcion = $this->descripcion;
        $estado->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }
    public function encontrar($id){
        $estado = Estado::find($id);
        $this->idRegistro = $estado->id;
        $this->descripcion = $estado->descripcion;
    }
    public function eliminar($id){
        $estado = Estado::find($id);
        $estado->delete();
        $this->limpiarControles();
    }
}
