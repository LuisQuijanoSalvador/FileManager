<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\TipoCambioExport;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TipoCambio;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class TipoCambios extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'fechaCambio';
    public $direction = 'asc';
    public $idRegistro, $fechaCambio, $montoCambio, $montoSunat;

    public function rules(){
        return[
            'fechaCambio'  => 'required',
            'montoCambio' => 'required',
            'montoSunat' => 'required'
        ];
    }

    protected $messages = [
        'fechaCambio.required' => 'El campo Fecha de Cambio no puede estar en blanco.',
        'nomtoCambio.required' => 'El campo Monto de Cambio no puede estar en blanco.',
        'montoSunat.required' => 'El campo Cambio Sunat no puede estar en blanco.',
    ];

    public function mount(){
        $fecha = Carbon::now();
        $this->fechaCambio = $fecha->format('Y-m-d');
    }

    public function render()
    {
        $tipoCambios = TipoCambio::where('fechaCambio', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.tipo-cambios', compact('tipoCambios'));
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

        $tipoCambio = new TipoCambio();
        $tipoCambio->fechaCambio = $this->fechaCambio;
        $tipoCambio->montoCambio = $this->montoCambio;
        $tipoCambio->montoSunat = $this->montoSunat;
        $tipoCambio->usuarioCreacion = auth()->user()->id;
        $tipoCambio->usuarioModificacion = auth()->user()->id;

        $tipoCambio->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->fechaCambio = "";
        $this->montoCambio = "";
        $this->montoSunat = "";
    }

    public function editar($id){
        $tipoCambio = TipoCambio::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tipoCambio->id;
        $this->fechaCambio = $tipoCambio->fechaCambio;
        $this->montoCambio = $tipoCambio->montoCambio;
        $this->montoSunat = $tipoCambio->montoSunat;
    }

    public function actualizar($id){
        $tipoCambio = TipoCambio::find($id);
        $tipoCambio->fechaCambio = $this->fechaCambio;
        $tipoCambio->montoCambio = $this->montoCambio;
        $tipoCambio->montoSunat = $this->montoSunat;
        $tipoCambio->usuarioModificacion = auth()->user()->id;
        $tipoCambio->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $tipoCambio = TipoCambio::find($id);
        $this->idRegistro = $tipoCambio->id;
        $this->fechaCambio = $tipoCambio->fechaCambio;
    }

    public function eliminar($id){
        $tipoCambio = TipoCambio::find($id);
        $tipoCambio->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new TipoCambioExport,'TipoDeCambio.xlsx');
    }
}
