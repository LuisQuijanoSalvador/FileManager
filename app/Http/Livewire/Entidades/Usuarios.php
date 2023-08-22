<?php

namespace App\Http\Livewire\Entidades;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Usuarios extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'name';
    public $direction = 'asc';

    public $idRegistro, $name, $email, $password, $estado, $rol;

    public function render()
    {
        $usuarios = User::where('name', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);

        return view('livewire.entidades.usuarios', compact('usuarios'));
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
        $usuario = new User();
        $usuario->name = $this->name;
        $usuario->email = $this->email;
        $usuario->password = $this->password;
        $usuario->estado = $this->estado;
        $usuario->rol = $this->rol;

        $usuario->save();
        $this->limpiarControles();
    }
    public function limpiarControles(){
        $this->name = "";
        $this->email = "";
        $this->password = "";
        $this->estado = "";
        $this->rol = "";
    }

    public function editar($id){
        $usuario = User::find($id);
        $this->limpiarControles();
        $this->idRegistro = $usuario->id;
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->password = $usuario->password;
        $this->estado = $usuario->estado;
        $this->rol = $usuario->rol;
    }
    public function actualizar($id){
        $usuario = User::find($id);
        $usuario->name = $this->name;
        // $usuario->email = $this->email;
        $usuario->password = $this->password;
        $usuario->estado = $this->estado;
        $usuario->rol = $this->rol;
        $usuario->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $usuario = User::find($id);
        $this->idRegistro = $usuario->id;
        $this->name = $usuario->name;
    }
    public function eliminar($id){
        $usuario = User::find($id);
        $usuario->delete();
        $this->limpiarControles();
    }
    
}
