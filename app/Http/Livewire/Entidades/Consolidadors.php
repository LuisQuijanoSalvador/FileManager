<?php

namespace App\Http\Livewire\Entidades;

use App\Exports\ConsolidadorExport;
use App\Models\Consolidador;
use App\Models\Estado;
use App\Models\moneda;
use App\Models\TipoCliente;
use App\Models\TipoDocumento;
use App\Models\TipoDocumentoIdentidad;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Consolidadors extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'razonSocial';
    public $direction = 'asc';

    public $idRegistro, $razonSocial, $nombreComercial, $direccionFiscal, $direccionFacturacion, $tipoProveedor,
            $tipoDocumentoIdentidad, $numeroDocumentoIdentidad, $numeroTelefono, $correo,
            $montoCredito, $moneda, $diasCredito, $tipoDocumento, $estado;
    
    public function rules(){
        return[
            'razonSocial'               =>   'required',
            'nombreComercial'           =>   'required',
            'direccionFiscal'           =>   'required',
            'direccionFacturacion'      =>   'required',
            'tipoProveedor'             =>   'required',
            'tipoDocumentoIdentidad'    =>   'required',
            'numeroDocumentoIdentidad'  =>   'required',
            'correo         '           =>   'email',
            'tipoDocumento'             =>   'required',
            'estado'                    =>   'required',
        ];
    }

    protected $messages = [
        'razonSocial.required'               =>   'Este campo es requerido',
        'nombreComercial.required'           =>   'Este campo es requerido',
        'direccionFiscal.required'           =>   'Este campo es requerido',
        'direccionFacturacion.required'      =>   'Este campo es requerido',
        'tipoProveedor.required'             =>   'Debe seleccionar una opción',
        'tipoDocumentoIdentidad.required'    =>   'Debe seleccionar una opción',
        'correo.email'                       =>   'Este campo no tiene el formato correcto',
        'montoCredito.required'              =>   'Este campo es requerido',
        'moneda.required'                    =>   'Debe seleccionar una opción',
        'diasCredito.required'               =>   'Este campo es requerido',
        'tipoDocumento.required'             =>   'Debe seleccionar una opción',
        'estado.required'                    =>   'Debe seleccionar una opción',
    ];
    public function render()
    {
        $consolidadors = Consolidador::where('razonSocial', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        $tipoDocumentoIdentidads = TipoDocumentoIdentidad::all()->sortBy('descripcion');
        $tipoProveedors = TipoCliente::all()->sortBy('descripcion');
        $monedas = moneda::all()->sortBy('codigo');
        $tipoDocumentos = TipoDocumento::all()->sortBy('descripcion');
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.entidades.consolidadors',compact('consolidadors','tipoDocumentoIdentidads',
                                                                'tipoProveedors','monedas','tipoDocumentos',
                                                                'estados'));
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

        $consolidador = new Consolidador();
        $consolidador->razonSocial = $this->razonSocial;
        $consolidador->nombreComercial = $this->nombreComercial;
        $consolidador->direccionFiscal = $this->direccionFiscal;
        $consolidador->direccionFacturacion = $this->direccionFacturacion;
        $consolidador->tipoProveedor = $this->tipoProveedor;
        $consolidador->tipoDocumentoIdentidad = $this->tipoDocumentoIdentidad;
        $consolidador->numeroDocumentoIdentidad = $this->numeroDocumentoIdentidad;
        $consolidador->numeroTelefono = $this->numeroTelefono;
        $consolidador->correo = $this->correo;
        $consolidador->montoCredito = $this->montoCredito;
        $consolidador->moneda = $this->moneda;
        $consolidador->diasCredito = $this->diasCredito;
        $consolidador->tipoDocumento = $this->tipoDocumento;
        $consolidador->estado = $this->estado;
        $consolidador->usuarioCreacion = auth()->user()->id;
        $consolidador->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = '';
        $this->razonSocial = '';
        $this->nombreComercial = '';
        $this->direccionFiscal = '';
        $this->direccionFacturacion = '';
        $this->tipoProveedor = '';
        $this->tipoDocumentoIdentidad = '';
        $this->numeroDocumentoIdentidad = '';
        $this->numeroTelefono = '';
        $this->correo = '';
        $this->montoCredito = '';
        $this->moneda = '';
        $this->diasCredito = '';
        $this->tipoDocumento = '';
        $this->estado = '';
    }

    public function editar($id){
        $consolidador = Consolidador::find($id);
        $this->limpiarControles();
        $this->idRegistro = $consolidador->id;
        $this->razonSocial = $consolidador->razonSocial;
        $this->nombreComercial = $consolidador->nombreComercial;
        $this->direccionFiscal = $consolidador->direccionFiscal;
        $this->direccionFacturacion = $consolidador->direccionFacturacion;
        $this->tipoProveedor = $consolidador->tipoCliente;
        $this->tipoDocumentoIdentidad = $consolidador->tipoDocumentoIdentidad;
        $this->numeroDocumentoIdentidad = $consolidador->numeroDocumentoIdentidad;
        $this->numeroTelefono = $consolidador->numeroTelefono;
        $this->correo = $consolidador->correoCobranza;
        $this->montoCredito = $consolidador->montoCredito;
        $this->moneda = $consolidador->moneda;
        $this->diasCredito = $consolidador->diasCredito;
        $this->tipoDocumento = $consolidador->tipoDocumento;
        $this->estado = $consolidador->estado;
    }

    public function actualizar($id){
        $consolidador = Consolidador::find($id);
        $consolidador->razonSocial = $this->razonSocial;
        $consolidador->nombreComercial = $this->nombreComercial;
        $consolidador->direccionFiscal = $this->direccionFiscal;
        $consolidador->direccionFacturacion = $this->direccionFacturacion;
        $consolidador->tipoProveedor = $this->tipoProveedor;
        $consolidador->tipoDocumentoIdentidad = $this->tipoDocumentoIdentidad;
        $consolidador->numeroDocumentoIdentidad = $this->numeroDocumentoIdentidad;
        $consolidador->numeroTelefono = $this->numeroTelefono;
        $consolidador->correo = $this->correo;
        $consolidador->montoCredito = $this->montoCredito;
        $consolidador->moneda = $this->moneda;
        $consolidador->diasCredito = $this->diasCredito;
        $consolidador->tipoDocumento = $this->tipoDocumento;
        $consolidador->estado = $this->estado;
        $consolidador->usuarioModificacion = auth()->user()->id;
        $consolidador->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $consolidador = Consolidador::find($id);
        $this->idRegistro = $consolidador->id;
        $this->razonSocial = $consolidador->razonSocial;
    }

    public function eliminar($id){
        $consolidador = Consolidador::find($id);
        $consolidador->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new ConsolidadorExport,'Consolidadores.xlsx');
    }
}
