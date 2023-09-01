<?php

namespace App\Http\Livewire\Tablas;

use Livewire\Component;
use App\Models\TipoCliente;
use Livewire\WithPagination;

class TipoClientes extends Component
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
        $tipoClientes = TipoCliente::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.tipo-clientes', compact('tipoClientes'));
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

        $tipoCliente = new TipoCliente();
        $tipoCliente->descripcion = $this->descripcion;

        $tipoCliente->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
    }

    public function editar($id){
        $tipoCliente = TipoCliente::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tipoCliente->id;
        $this->descripcion = $tipoCliente->descripcion;
    }

    public function actualizar($id){
        $tipoCliente = TipoCliente::find($id);
        $tipoCliente->descripcion = $this->descripcion;
        $tipoCliente->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $tipoCliente = TipoCliente::find($id);
        $this->idRegistro = $tipoCliente->id;
        $this->descripcion = $tipoCliente->descripcion;
    }

    public function eliminar($id){
        $tipoCliente = TipoCliente::find($id);
        $tipoCliente->delete();
        $this->limpiarControles();
    }
}
