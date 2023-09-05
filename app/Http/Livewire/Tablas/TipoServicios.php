<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\TipoServicioExport;
use App\Models\TipoServicio;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TipoServicios extends Component
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
        $tipoServicios = TipoServicio::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.tipo-servicios', compact('tipoServicios'));
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

        $tipoServicio = new TipoServicio();
        $tipoServicio->descripcion = $this->descripcion;
        $tipoServicio->codigo = $this->codigo;
        $tipoServicio->usuarioCreacion = auth()->user()->id;

        $tipoServicio->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->codigo = "";
    }

    public function editar($id){
        $tipoServicio = TipoServicio::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tipoServicio->id;
        $this->descripcion = $tipoServicio->descripcion;
        $this->codigo = $tipoServicio->codigo;
    }

    public function actualizar($id){
        $tipoServicio = TipoServicio::find($id);
        $tipoServicio->descripcion = $this->descripcion;
        $tipoServicio->codigo = $this->codigo;
        $tipoServicio->usuarioModificacion = auth()->user()->id;
        $tipoServicio->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }
    
    public function encontrar($id){
        $tipoServicio = TipoServicio::find($id);
        $this->idRegistro = $tipoServicio->id;
        $this->descripcion = $tipoServicio->descripcion;
    }

    public function eliminar($id){
        $tipoServicio = TipoServicio::find($id);
        $tipoServicio->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new TipoServicioExport,'TipoServicio.xlsx');
    }
}
