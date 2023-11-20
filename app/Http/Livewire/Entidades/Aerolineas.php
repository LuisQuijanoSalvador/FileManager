<?php

namespace App\Http\Livewire\Entidades;

use App\Exports\AerolineaExport;
use App\Models\Aerolinea;
use App\Models\Estado;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

class Aerolineas extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search = "";
    public $sort= 'razonSocial';
    public $direction = 'asc';

    public $idRegistro, $razonSocial, $nombreComercial, $siglaIata, $codigoIata, $ruc,$logo, $estado;

    public function rules(){
        return[
            'razonSocial'     =>   'required',
            'nombreComercial' =>   'required',
            'siglaIata'       =>   'required',
            'codigoIata'      =>   'required',
            'ruc'             =>   'required|numeric|digits:11',
            'logo'            =>   'required|image|max:2048',
            'estado'          =>   'required',
        ];
    }

    protected $messages = [
        'razonSocial.required'      =>   'Este campo es requerido',
        'nombreComercial.required'  =>   'Este campo es requerido',
        'siglaIata.required'        =>   'Este campo es requerido',
        'codigoIata.required'       =>   'Este campo es requerido',
        'ruc.required'              =>   'Este campo es requerido',
        'ruc.numeric'               =>   'El campo debe ser numérico',
        'ruc.size'                  =>   'El RUC debe tener 11 caracteres',
        'logo.required'             =>   'Este campo es requerido',
        'logo.image'                =>   'No es un archivo de imagen válido',
        'logo.max'                  =>   'Tamaño máximo de imagen 2mb',
        'estado.required'           =>   'Debe seleccionar una opción',
    ];
    

    public function render()
    {
        $aerolineas = Aerolinea::where('razonSocial', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        $estados = Estado::all()->sortBy('descripcion');

        return view('livewire.entidades.aerolineas', compact('aerolineas','estados'));
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

        $iLogo = $this->logo->store('public/logosAir');
        $aerolinea = new Aerolinea();
        $aerolinea->razonSocial = $this->razonSocial;
        $aerolinea->nombreComercial = $this->nombreComercial;
        $aerolinea->siglaIata = $this->siglaIata;
        $aerolinea->codigoIata = $this->codigoIata;
        $aerolinea->ruc = $this->ruc;
        $aerolinea->logo = $iLogo;
        $aerolinea->estado = $this->estado;
        $aerolinea->usuarioCreacion = auth()->user()->id;
        $aerolinea->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = '';
        $this->razonSocial = '';
        $this->nombreComercial = '';
        $this->siglaIata = '';
        $this->codigoIata = '';
        $this->ruc = '';
        $this->logo = null;
        $this->estado = '';
    }

    public function editar($id){
        $aerolinea = Aerolinea::find($id);
        $this->limpiarControles();
        $this->idRegistro = $aerolinea->id;
        $this->razonSocial = $aerolinea->razonSocial;
        $this->nombreComercial = $aerolinea->nombreComercial;
        $this->siglaIata = $aerolinea->siglaIata;
        $this->codigoIata = $aerolinea->codigoIata;
        $this->ruc = $aerolinea->ruc;
        $this->logo = $aerolinea->logo;
        $this->estado = $aerolinea->estado;
    }

    public function actualizar($id){
        $aerolinea = Aerolinea::find($id);
        $aerolinea->razonSocial = $this->razonSocial;
        $aerolinea->nombreComercial = $this->nombreComercial;
        $aerolinea->siglaIata = $this->siglaIata;
        $aerolinea->codigoIata = $this->codigoIata;
        $aerolinea->ruc = $this->ruc;
        $aerolinea->logo = $this->logo;
        $aerolinea->estado = $this->estado;
        $aerolinea->usuarioModificacion = auth()->user()->id;
        $aerolinea->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $aerolinea = Aerolinea::find($id);
        $this->idRegistro = $aerolinea->id;
        $this->razonSocial = $aerolinea->razonSocial;
    }

    public function eliminar($id){
        $aerolinea = Aerolinea::find($id);
        $aerolinea->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new AerolineaExport,'Aerolineas.xlsx');
    }
}
