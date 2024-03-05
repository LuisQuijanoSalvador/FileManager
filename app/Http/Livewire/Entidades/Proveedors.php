<?php

namespace App\Http\Livewire\Entidades;

use App\Exports\ProveedorExport;
use App\Models\Estado;
use App\Models\moneda;
use App\Models\Proveedor;
use App\Models\TipoCliente;
use App\Models\TipoDocumento;
use App\Models\TipoDocumentoIdentidad;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Proveedors extends Component
{
    use WithPagination;

    public $search = "";
    public $sort= 'razonSocial';
    public $direction = 'asc';

    public $idRegistro, $razonSocial, $nombreComercial, $direccionFiscal, $direccionFacturacion, $tipoProveedor,
            $esConsolidador=0,$comision=0,$tipoDocumentoIdentidad, $numeroDocumentoIdentidad, $numeroTelefono, 
            $correo,$montoCredito=0, $moneda, $diasCredito=0, $tipoDocumento, $estado;

    public function rules(){
        return[
            'razonSocial'               =>   'required',
            'nombreComercial'           =>   'required',
            'direccionFiscal'           =>   'required',
            'direccionFacturacion'      =>   'required',
            'tipoProveedor'             =>   'required',
            'tipoDocumentoIdentidad'    =>   'required',
            'numeroDocumentoIdentidad'  =>   'required',
            'correo'                    =>   'nullable|email',
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
        $proveedors = Proveedor::where('razonSocial', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        $tipoDocumentoIdentidads = TipoDocumentoIdentidad::all()->sortBy('descripcion');
        $tipoProveedors = TipoCliente::all()->sortBy('descripcion');
        $monedas = moneda::all()->sortBy('codigo');
        $tipoDocumentos = TipoDocumento::all()->sortBy('descripcion');
        $estados = Estado::all()->sortBy('descripcion');
        return view('livewire.entidades.proveedors',compact('proveedors','tipoDocumentoIdentidads',
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

        $proveedor = new Proveedor();
        $proveedor->razonSocial = $this->razonSocial;
        $proveedor->nombreComercial = $this->nombreComercial;
        $proveedor->direccionFiscal = $this->direccionFiscal;
        $proveedor->direccionFacturacion = $this->direccionFacturacion;
        $proveedor->tipoProveedor = $this->tipoProveedor;
        $proveedor->esConsolidador = $this->esConsolidador;
        $proveedor->comision = $this->comision;
        $proveedor->tipoDocumentoIdentidad = $this->tipoDocumentoIdentidad;
        $proveedor->numeroDocumentoIdentidad = $this->numeroDocumentoIdentidad;
        $proveedor->numeroTelefono = $this->numeroTelefono;
        $proveedor->correo = $this->correo;
        $proveedor->montoCredito = $this->montoCredito;
        $proveedor->moneda = $this->moneda;
        $proveedor->diasCredito = $this->diasCredito;
        $proveedor->tipoDocumento = $this->tipoDocumento;
        $proveedor->estado = $this->estado;
        $proveedor->usuarioCreacion = auth()->user()->id;
        $proveedor->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->razonSocial = '';
        $this->nombreComercial = '';
        $this->direccionFiscal = '';
        $this->direccionFacturacion = '';
        $this->tipoProveedor = '';
        $this->esConsolidador = '';
        $this->comision = '';
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
        $proveedor = Proveedor::find($id);
        $this->limpiarControles();
        $this->idRegistro = $proveedor->id;
        $this->razonSocial = $proveedor->razonSocial;
        $this->nombreComercial = $proveedor->nombreComercial;
        $this->direccionFiscal = $proveedor->direccionFiscal;
        $this->direccionFacturacion = $proveedor->direccionFacturacion;
        $this->tipoProveedor = $proveedor->tipoProveedor;
        $this->esConsolidador = $proveedor->esConsolidador;
        $this->comision = $proveedor->comision;
        $this->tipoDocumentoIdentidad = $proveedor->tipoDocumentoIdentidad;
        $this->numeroDocumentoIdentidad = $proveedor->numeroDocumentoIdentidad;
        $this->numeroTelefono = $proveedor->numeroTelefono;
        $this->correo = $proveedor->correoCobranza;
        $this->montoCredito = $proveedor->montoCredito;
        $this->moneda = $proveedor->moneda;
        $this->diasCredito = $proveedor->diasCredito;
        $this->tipoDocumento = $proveedor->tipoDocumento;
        $this->estado = $proveedor->estado;
    }

    public function actualizar($id){
        $proveedor = Proveedor::find($id);
        $proveedor->razonSocial = $this->razonSocial;
        $proveedor->nombreComercial = $this->nombreComercial;
        $proveedor->direccionFiscal = $this->direccionFiscal;
        $proveedor->direccionFacturacion = $this->direccionFacturacion;
        $proveedor->tipoProveedor = $this->tipoProveedor;
        $proveedor->esConsolidador = $this->esConsolidador;
        $proveedor->comision = $this->comision;
        $proveedor->tipoDocumentoIdentidad = $this->tipoDocumentoIdentidad;
        $proveedor->numeroDocumentoIdentidad = $this->numeroDocumentoIdentidad;
        $proveedor->numeroTelefono = $this->numeroTelefono;
        $proveedor->correo = $this->correo;
        $proveedor->montoCredito = $this->montoCredito;
        $proveedor->moneda = $this->moneda;
        $proveedor->diasCredito = $this->diasCredito;
        $proveedor->tipoDocumento = $this->tipoDocumento;
        $proveedor->estado = $this->estado;
        $proveedor->usuarioModificacion = auth()->user()->id;
        $proveedor->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $proveedor = Proveedor::find($id);
        $this->idRegistro = $proveedor->id;
        $this->razonSocial = $proveedor->razonSocial;
    }

    public function eliminar($id){
        $proveedor = Proveedor::find($id);
        $proveedor->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new ProveedorExport,'Proveedores.xlsx');
    }
}
