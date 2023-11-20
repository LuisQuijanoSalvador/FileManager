<?php

namespace App\Http\Livewire\Entidades;

use App\Exports\SolicitanteExport;
use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Solicitante;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Solicitantes extends Component
{
    use WithPagination;

    public $search = "";
    public $sort= 'nombres';
    public $direction = 'asc';

    public $idRegistro, $nombres, $email, $cargo, $telefono, $celular, $cliente, $estado;

    public function rules(){
        return[
            'nombres'   =>   'required',
            'email'     =>   'nullable|email',
            'cliente'   =>   'required',
            'estado'    =>   'required',
        ];
    }

    protected $messages = [
        'nombres.required'    =>   'Este campo es requerido',
        'email.email'         =>   'Este campo no tiene el formato correcto',
        'cliente.required'    =>   'Debe seleccionar una opción',
        'estado.required'     =>   'Debe seleccionar una opción',
    ];

    public function render()
    {
        $solicitantes = Solicitante::where('nombres', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        $clientes = Cliente::all()->sortBy('razonSocial');
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.entidades.solicitantes',compact('solicitantes','clientes','estados'));
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
        
        $solicitante = new Solicitante();
        $solicitante->nombres = $this->nombres;
        $solicitante->email = $this->email;
        $solicitante->cargo = $this->cargo;
        $solicitante->telefono = $this->telefono;
        $solicitante->celular = $this->celular;
        $solicitante->cliente = $this->cliente;
        $solicitante->estado = $this->estado;
        $solicitante->usuarioCreacion = auth()->user()->id;
        $solicitante->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = '';
        $this->nombres = '';
        $this->email = '';
        $this->cargo = '';
        $this->telefono = '';
        $this->celular = '';
        $this->cliente = '';
        $this->estado = '';
    }

    public function editar($id){
        $solicitante = Solicitante::find($id);
        $this->limpiarControles();
        $this->idRegistro = $solicitante->id;
        $this->nombres = $solicitante->nombres;
        $this->email = $solicitante->email;
        $this->cargo = $solicitante->cargo;
        $this->telefono = $solicitante->telefono;
        $this->celular = $solicitante->celular;
        $this->cliente = $solicitante->cliente;
        $this->estado = $solicitante->estado;
    }

    public function actualizar($id){
        $solicitante = Solicitante::find($id);
        $solicitante->nombres = $this->nombres;
        $solicitante->email = $this->email;
        $solicitante->cargo = $this->cargo;
        $solicitante->telefono = $this->telefono;
        $solicitante->celular = $this->celular;
        $solicitante->cliente = $this->cliente;
        $solicitante->estado = $this->estado;
        $solicitante->usuarioModificacion = auth()->user()->id;
        $solicitante->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $solicitante = Solicitante::find($id);
        $this->idRegistro = $solicitante->id;
        $this->nombres = $solicitante->nombres;
    }

    public function eliminar($id){
        $solicitante = Solicitante::find($id);
        $solicitante->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new SolicitanteExport,'Solicitantes.xlsx');
    }
}
