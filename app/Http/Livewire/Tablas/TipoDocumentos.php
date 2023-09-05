<?php

namespace App\Http\Livewire\Tablas;

use App\Exports\TipoDocumentoExport;
use App\Models\TipoDocumento;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TipoDocumentos extends Component
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
        $tipoDocumentos = TipoDocumento::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.tipo-documentos', compact('tipoDocumentos'));
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

        $tipoDocumento = new TipoDocumento();
        $tipoDocumento->descripcion = $this->descripcion;
        $tipoDocumento->codigo = $this->codigo;
        $tipoDocumento->usuarioCreacion = auth()->user()->id;

        $tipoDocumento->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->codigo = "";
    }

    public function editar($id){
        $tipoDocumento = TipoDocumento::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tipoDocumento->id;
        $this->descripcion = $tipoDocumento->descripcion;
        $this->codigo = $tipoDocumento->codigo;
    }

    public function actualizar($id){
        $tipoDocumento = TipoDocumento::find($id);
        $tipoDocumento->descripcion = $this->descripcion;
        $tipoDocumento->codigo = $this->codigo;
        $tipoDocumento->usuarioModificacion = auth()->user()->id;
        $tipoDocumento->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $tipoDocumento = TipoDocumento::find($id);
        $this->idRegistro = $tipoDocumento->id;
        $this->descripcion = $tipoDocumento->descripcion;
    }

    public function eliminar($id){
        $tipoDocumento = TipoDocumento::find($id);
        $tipoDocumento->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new TipoDocumentoExport,'TipoDocumentos.xlsx');
    }
}
