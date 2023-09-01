<?php

namespace App\Http\Livewire\Entidades;

use App\Exports\UsersExportView;
use App\Models\Estado;
use App\Models\Rol;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Termwind\Components\Dd;

class Usuarios extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'name';
    public $direction = 'asc';

    public $idRegistro, $name, $email, $password, $estado, $rol;

    // protected $rules = [
    //     'name'      => 'required',
    //     'email'     => 'required|email',
    //     'password'     => 'required',
    // ];
    protected $messages = [
        'name.required' => 'El campo Nombre no puede estar en blanco.',
        'email.required' => 'El campo Email no puede estar en blanco.',
        'email.email' => 'El campo Email no tiene el formato correcto.',
        'password.required' => 'El campo Contraseña no puede estar en blanco.',
    ];
    public function rules(){
        return[
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required'
        ];
    }
    public function render()
    {
        $usuarios = User::where('name', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        
        $estados = Estado::all()->sortBy('descripcion');
        $roles = Rol::all()->sortBy('descripcion');

        return view('livewire.entidades.usuarios', compact('usuarios','estados','roles'));
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

        $usuario = new User();
        $usuario->name = $this->name;
        $usuario->email = $this->email;
        $usuario->password = $this->password;
        $usuario->estado = $this->estado;
        $usuario->rol = $this->rol;
        //dd($usuario);
        $usuario->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }
    public function limpiarControles(){
        $this->idRegistro = 0;
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
        $this->password = Hash::make($usuario->password);
        $this->estado = $usuario->estado;
        $this->rol = $usuario->rol;
    }
    public function actualizar($id){
        $usuario = User::find($id);
        $usuario->name = $this->name;
        // $usuario->email = $this->email;
        $usuario->password = Hash::make($this->password);
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

    public function exportar(){
        return Excel::download(new UsersExportView(),'usuarios.xlsx');
    }
    
}
