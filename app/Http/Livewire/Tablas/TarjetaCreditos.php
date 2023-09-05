<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\TarjetaCreditoExport;
use App\Models\TarjetaCredito;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TarjetaCreditos extends Component
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
        $tarjetaCreditos = TarjetaCredito::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.tarjeta-creditos', compact('tarjetaCreditos'));
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

        $tarjetaCredito = new TarjetaCredito();
        $tarjetaCredito->descripcion = $this->descripcion;
        $tarjetaCredito->codigo = $this->codigo;
        $tarjetaCredito->usuarioCreacion = auth()->user()->id;

        $tarjetaCredito->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->codigo = "";
    }

    public function editar($id){
        $tarjetaCredito = TarjetaCredito::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tarjetaCredito->id;
        $this->descripcion = $tarjetaCredito->descripcion;
        $this->codigo = $tarjetaCredito->codigo;
    }

    public function actualizar($id){
        $tarjetaCredito = TarjetaCredito::find($id);
        $tarjetaCredito->descripcion = $this->descripcion;
        $tarjetaCredito->codigo = $this->codigo;
        $tarjetaCredito->usuarioModificacion = auth()->user()->id;
        $tarjetaCredito->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $tarjetaCredito = TarjetaCredito::find($id);
        $this->idRegistro = $tarjetaCredito->id;
        $this->descripcion = $tarjetaCredito->descripcion;
    }

    public function eliminar($id){
        $tarjetaCredito = TarjetaCredito::find($id);
        $tarjetaCredito->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new TarjetaCreditoExport,'TarjetasCredito.xlsx');
    }
}
