<?php

namespace App\Http\Livewire\Entidades;

use App\Exports\VendedorExport;
use App\Models\Estado;
use App\Models\Vendedor;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Vendedors extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'nombre';
    public $direction = 'asc';

    public $idRegistro, $nombre,$codigo,$comision,$comisionOver, $estado;

    public function rules(){
        return[
            'nombre'        => 'required',
            'codigo'        => 'required',
            'comision'      => 'required',
            'comisionOver'  => 'required',
            'estado'        => 'required'
        ];
    }

    protected $messages = [
        'nombre.required' => 'El campo Nombre no puede estar en blanco.',
        'codigo.required' => 'El campo Codigo no puede estar en blanco.',
        'comision.required' => 'El campo Comision no puede estar en blanco.',
        'comisionOver.required' => 'El campo Comision Over no puede estar en blanco.',
        'estado.required' => 'Debe seleccionar una opcion.',
    ];

    public function render()
    {
        $vendedors = Vendedor::where('nombre', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.entidades.vendedors', compact('vendedors','estados'));
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

        $vendedor = new Vendedor();
        $vendedor->nombre = $this->nombre;
        $vendedor->codigo = $this->codigo;
        $vendedor->comision = $this->comision;
        $vendedor->comisionOver = $this->comisionOver;
        $vendedor->estado = $this->estado;
        $vendedor->usuarioCreacion = auth()->user()->id;
        $vendedor->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->nombre = "";
        $this->codigo = "";
        $this->comision = 0;
        $this->comisionOver = "";
        $this->estado = "";
    }

    public function editar($id){
        $vendedor = Vendedor::find($id);
        $this->limpiarControles();
        $this->idRegistro = $vendedor->id;
        $this->nombre = $vendedor->nombre;
        $this->codigo = $vendedor->codigo;
        $this->comision = $vendedor->comision;
        $this->comisionOver = $vendedor->comisionOver;
        $this->estado = $vendedor->estado;
    }

    public function actualizar($id){
        $vendedor = Vendedor::find($id);
        $vendedor->nombre = $this->nombre;
        $vendedor->codigo = $this->codigo;
        $vendedor->comision = $this->comision;
        $vendedor->comisionOver = $this->comisionOver;
        $vendedor->estado = $this->estado;
        $vendedor->usuarioModificacion = auth()->user()->id;
        $vendedor->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $vendedor = Vendedor::find($id);
        $this->idRegistro = $vendedor->id;
        $this->nombre = $vendedor->nombre;
    }

    public function eliminar($id){
        $vendedor = Vendedor::find($id);
        $vendedor->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new VendedorExport,'Vendedores.xlsx');
    }
}
