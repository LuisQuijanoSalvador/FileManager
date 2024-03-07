<?php

namespace App\Http\Livewire\Files;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Estado;
use App\Models\File;
use App\Models\Area;
use App\Models\Cliente;
use App\Clases\Funciones;
use Carbon\Carbon;

class Files extends Component
{
    use WithPagination;

    public $search = "";
    public $sort= 'numeroFile';
    public $direction = 'asc';

    public $idRegistro, $numeroFile, $idArea, $idCliente, $descripcion, $totalPago=0, $totalCobro=0 ,$idEstado,
    $mostrarPanel = false;

    public function render()
    {
        // dd(auth()->user()->role);
        $files = File::where('numeroFile', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(8);
        $estados = Estado::all()->sortBy('descripcion');
        $clientes = Cliente::all()->sortBy('razonSocial');
        $areas = Area::all()->sortBy('descripcion');
        return view('livewire.files.files',compact('files','estados','clientes','areas'));
        
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

    public function nuevo(){
        $this->mostrarPanel = true;
    }

    public function grabar(){
        // $this->validate();
        $fechaActual = Carbon::now();
        $area = Area::find($this->idArea);
        $funciones = new Funciones();
        $numfile = $funciones->generaFile('FILES');

        $file = new File();
        $file->numeroFile = $area->codigo . str_pad($numfile,7,"0",STR_PAD_LEFT);
        $file->idArea = $this->idArea;
        $file->idCliente = $this->idCliente;
        $file->descripcion = $this->descripcion;
        $file->totalPago = $this->totalPago;
        $file->totalCobro = $this->totalCobro;
        $file->fechaFile = Carbon::parse($fechaActual)->format("Y-m-d");
        $file->idEstado = 1;
        $file->usuarioCreacion = auth()->user()->id;
        $file->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
        $this->mostrarPanel = false;
    }

    public function limpiarControles(){
        $this->numeroFile = '';
        $this->idArea = '';
        $this->idCliente = '';
        $this->descripcion = '';
        $this->totalPago = 0;
        $this->totalCobro = 0;
        $this->idEstado = null;
    }

    public function editar($id){
        // $file = File::find($id);
        // $this->limpiarControles();
        // $this->idRegistro = $file->id;
        // $this->numeroFile = $file->numeroFile;
        // $this->idArea = $file->idArea;
        // $this->idCliente = $file->idCliente;
        // $this->descripcion = $file->descripcion;
        // $this->totalPago = $file->totalPago;
        // $this->totalCobro = $file->totalCobro;
        // $this->idEstado = $file->idEstado;
        return redirect()->route('editarFiles',['id'=>$id]);
    }

    public function actualizar($id){
        $file = File::find($id);
        $file->numeroFile = $this->numeroFile;
        $file->idArea = $this->idArea;
        $file->idCliente = $this->idCliente;
        $file->descripcion = $this->descripcion;
        $file->totalPago = $this->totalPago;
        $file->totalCobro = $this->totalCobro;
        $file->idEstado = $this->idEstado;
        $file->usuarioModificacion = auth()->user()->id;
        $file->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $file = File::find($id);
        $this->idRegistro = $file->id;
        $this->numeroFile = $file->numeroFile;
    }

    public function eliminar($id){
        $file = File::find($id);
        $file->delete();
        $this->limpiarControles();
    }
}
