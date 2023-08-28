<?php

namespace App\Http\Livewire\Tablas;

use Livewire\Component;
use App\Models\Rol;
use Livewire\WithPagination;

class Roles extends Component
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
            'descripcion'  => 'required',
        ];
    }

    public function render()
    {
        $roles = Rol::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.roles', compact('roles'));
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

        $rol = new Rol();
        $rol->descripcion = $this->descripcion;

        $rol->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
    }

    public function editar($id){
        $rol = Rol::find($id);
        $this->limpiarControles();
        $this->idRegistro = $rol->id;
        $this->descripcion = $rol->descripcion;
    }
    public function actualizar($id){
        $rol = Rol::find($id);
        $rol->descripcion = $this->descripcion;
        $rol->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $rol = Rol::find($id);
        $this->idRegistro = $rol->id;
        $this->descripcion = $rol->descripcion;
    }
    
    public function eliminar($id){
        $rol = Rol::find($id);
        $rol->delete();
        $this->limpiarControles();
    }
}
