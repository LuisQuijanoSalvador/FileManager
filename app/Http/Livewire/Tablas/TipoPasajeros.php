<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\TipoPasajeroExport;
use App\Models\TipoPasajero;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TipoPasajeros extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'descripcion';
    public $direction = 'asc';
    public $idRegistro, $descripcion, $codigo;

    public function rules(){
        return[
            'descripcion'  => 'required',
            'codigo' => 'required'
        ];
    }

    protected $messages = [
        'descripcion.required' => 'El campo Descripcion no puede estar en blanco.',
        'codigo.required' => 'El campo Codigo no puede estar en blanco.',
    ];

    public function render()
    {
        $tipoPasajeros = TipoPasajero::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.tipo-pasajeros', compact('tipoPasajeros'));
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

        $tipoPasajero = new TipoPasajero();
        $tipoPasajero->descripcion = $this->descripcion;
        $tipoPasajero->codigo = $this->codigo;
        $tipoPasajero->usuarioCreacion = auth()->user()->id;

        $tipoPasajero->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->codigo = "";
    }

    public function editar($id){
        $tipoPasajero = TipoPasajero::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tipoPasajero->id;
        $this->descripcion = $tipoPasajero->descripcion;
        $this->codigo = $tipoPasajero->codigo;
    }

    public function actualizar($id){
        $tipoPasajero = TipoPasajero::find($id);
        $tipoPasajero->descripcion = $this->descripcion;
        $tipoPasajero->codigo = $this->codigo;
        $tipoPasajero->usuarioModificacion = auth()->user()->id;
        $tipoPasajero->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $tipoPasajero = TipoPasajero::find($id);
        $this->idRegistro = $tipoPasajero->id;
        $this->descripcion = $tipoPasajero->descripcion;
    }

    public function eliminar($id){
        $tipoPasajero = TipoPasajero::find($id);
        $tipoPasajero->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new TipoPasajeroExport,'TipoPasajero.xlsx');
    }
}
