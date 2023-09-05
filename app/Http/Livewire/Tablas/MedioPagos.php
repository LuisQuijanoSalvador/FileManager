<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\MedioPagoExport;
use App\Models\MedioPago;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class MedioPagos extends Component
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
        $medioPagos = MedioPago::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.medio-pagos', compact('medioPagos'));
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

        $medioPago = new MedioPago();
        $medioPago->descripcion = $this->descripcion;
        $medioPago->codigo = $this->codigo;
        $medioPago->usuarioCreacion = auth()->user()->id;

        $medioPago->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->codigo = "";
    }

    public function editar($id){
        $medioPago = MedioPago::find($id);
        $this->limpiarControles();
        $this->idRegistro = $medioPago->id;
        $this->descripcion = $medioPago->descripcion;
        $this->codigo = $medioPago->codigo;
    }

    public function actualizar($id){
        $medioPago = MedioPago::find($id);
        $medioPago->descripcion = $this->descripcion;
        $medioPago->codigo = $this->codigo;
        $medioPago->usuarioModificacion = auth()->user()->id;
        $medioPago->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $medioPago = MedioPago::find($id);
        $this->idRegistro = $medioPago->id;
        $this->descripcion = $medioPago->descripcion;
    }

    public function eliminar($id){
        $medioPago = MedioPago::find($id);
        $medioPago->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new MedioPagoExport,'MediosDePago.xlsx');
    }
}
