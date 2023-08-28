<?php

namespace App\Http\Livewire\Tablas;

use Livewire\Component;
use App\Models\TipoDocumentoIdentidad;
use Livewire\WithPagination;

class TipoDocIdentidad extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'descripcion';
    public $direction = 'asc';
    public $idRegistro, $descripcion, $codigo;

    protected $messages = [
        'descripcion.required' => 'El campo Descripcion no puede estar en blanco.',
        'codigo.required' => 'El campo Codigo no puede estar en blanco.',
    ];
    public function rules(){
        return[
            'descripcion'  => 'required',
            'codigo'  => 'required',
        ];
    }
    public function render()
    {
        $tipoDocumentosIdentidad = TipoDocumentoIdentidad::where('descripcion', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.tablas.tipo-doc-identidad', compact('tipoDocumentosIdentidad'));
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

        $tipoDocumentosIdentidad = new TipoDocumentoIdentidad();
        $tipoDocumentosIdentidad->descripcion = $this->descripcion;
        $tipoDocumentosIdentidad->codigo = $this->codigo;

        $tipoDocumentosIdentidad->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->descripcion = "";
        $this->codigo = "";
    }

    public function editar($id){
        $tipoDocumentosIdentidad = TipoDocumentoIdentidad::find($id);
        $this->limpiarControles();
        $this->idRegistro = $tipoDocumentosIdentidad->id;
        $this->descripcion = $tipoDocumentosIdentidad->descripcion;
        $this->codigo = $tipoDocumentosIdentidad->codigo;
    }

    public function actualizar($id){
        $tipoDocumentosIdentidad = TipoDocumentoIdentidad::find($id);
        $tipoDocumentosIdentidad->descripcion = $this->descripcion;
        $tipoDocumentosIdentidad->codigo = $this->codigo;
        $tipoDocumentosIdentidad->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $tipoDocumentosIdentidad = TipoDocumentoIdentidad::find($id);
        $this->idRegistro = $tipoDocumentosIdentidad->id;
        $this->descripcion = $tipoDocumentosIdentidad->descripcion;
    }

    public function eliminar($id){
        $tipoDocumentosIdentidad = TipoDocumentoIdentidad::find($id);
        $tipoDocumentosIdentidad->delete();
        $this->limpiarControles();
    }
}
