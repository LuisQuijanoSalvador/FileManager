<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\TipoPagoExport;
use App\Models\Estado;
use App\Models\TipoPago;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TipoPagos extends Component
{
    use WithPagination;

    public $search = "";
    public $sort= 'descripcion';
    public $direction = 'asc';

    public $idRegistro, $descripcion,$estado;

    public function rules(){
        return[
            'descripcion'   => 'required',
            'estado'        => 'required'
        ];
    }

    protected $messages = [
        'descripcion.required' => 'El campo Descripcion no puede estar en blanco.',
        'estado.required' => 'Debe seleccionar una opcion.',
    ];

    public function render()
    {
        $tipoPagos = TipoPago::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.tablas.tipo-pagos', compact('tipoPagos','estados'));
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

        $tipoPago = new TipoPago();
        $tipoPago->descripcion  = $this->descripcion;
        $tipoPago->estado = $this->estado;
        $tipoPago->usuarioCreacion = auth()->user()->id;
        $tipoPago->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->estado = "";
    }

    public function editar($id){
        $tipoPago = TipoPago::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tipoPago->id;
        $this->descripcion = $tipoPago->descripcion;
        $this->estado = $tipoPago->estado;
    }

    public function actualizar($id){
        $tipoPago = TipoPago::find($id);
        $tipoPago->descripcion  = $this->descripcion;
        $tipoPago->estado = $this->estado;
        $tipoPago->usuarioModificacion = auth()->user()->id;
        $tipoPago->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $tipoPago = TipoPago::find($id);
        $this->idRegistro = $tipoPago->id;
        $this->descripcion = $tipoPago->descripcion;
    }

    public function eliminar($id){
        $tipoPago = TipoPago::find($id);
        $tipoPago->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new TipoPagoExport,'TipoPagos.xlsx');
    }
}
