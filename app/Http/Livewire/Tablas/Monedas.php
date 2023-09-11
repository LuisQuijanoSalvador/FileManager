<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\MonedaExport;
use App\Models\moneda;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Monedas extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'pais';
    public $direction = 'asc';
    public $idRegistro, $pais, $moneda, $codigo;

    public function rules(){
        return[
            'pais'  => 'required',
            'moneda'  => 'required',
            'codigo' => 'required|max:3'
        ];
    }

    protected $messages = [
        'pais.required' => 'El campo Pais no puede estar en blanco.',
        'moneda.required' => 'El campo Moneda no puede estar en blanco.',
        'codigo.required' => 'El campo Codigo no puede estar en blanco.',
        'codigo.max:3' => 'Máximo 3 caracteres.',
    ];

    public function render()
    {
        $monedas = moneda::where('pais', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.monedas', compact('monedas'));
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

        $moneda = new moneda();
        $moneda->pais = $this->pais;
        $moneda->moneda = $this->moneda;
        $moneda->codigo = $this->codigo;
        $moneda->usuarioCreacion = auth()->user()->id;

        $moneda->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->pais = "";
        $this->moneda = "";
        $this->codigo = "";
    }

    public function editar($id){
        $moneda = moneda::find($id);
        $this->limpiarControles();
        $this->idRegistro = $moneda->id;
        $this->pais = $moneda->pais;
        $this->moneda = $moneda->moneda;
        $this->codigo = $moneda->codigo;
    }

    public function actualizar($id){
        $moneda = moneda::find($id);
        $moneda->pais = $this->pais;
        $moneda->moneda = $this->moneda;
        $moneda->codigo = $this->codigo;
        $moneda->usuarioModificacion = auth()->user()->id;
        $moneda->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $moneda = moneda::find($id);
        $this->idRegistro = $moneda->id;
        $this->pais = $moneda->pais;
    }

    public function eliminar($id){
        $moneda = moneda::find($id);
        $moneda->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new MonedaExport,'Monedas.xlsx');
    }
}
