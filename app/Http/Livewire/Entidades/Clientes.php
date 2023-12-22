<?php

namespace App\Http\Livewire\Entidades;

use App\Exports\ClienteExport;
use App\Models\Area;
use App\Models\Cliente;
use App\Models\Cobrador;
use App\Models\Counter;
use App\Models\Estado;
use App\Models\moneda;
use App\Models\TipoCliente;
use App\Models\TipoDocumento;
use App\Models\TipoDocumentoIdentidad;
use App\Models\TipoFacturacion;
use App\Models\Vendedor;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Clientes extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'razonSocial';
    public $direction = 'asc';

    public $idRegistro, $razonSocial, $nombreComercial, $direccionFiscal, $direccionFacturacion, $tipoCliente,
            $tipoDocumentoIdentidad, $numeroDocumentoIdentidad, $numeroTelefono, $contactoComercial,
            $telefonoComercial, $correoComercial, $contactoCobranza, $telefonoCobranza, $correoCobranza,
            $montoCredito, $moneda, $diasCredito, $counter, $tipoDocumento, $vendedor, $area, $cobrador,
            $tipoFacturacion, $estado;
    
    public function rules(){
        return[
            'razonSocial'               =>   'required',
            'nombreComercial'           =>   'required',
            'direccionFiscal'           =>   'required',
            'direccionFacturacion'      =>   'required',
            'tipoCliente'               =>   'required',
            'tipoDocumentoIdentidad'    =>   'required',
            'numeroDocumentoIdentidad'  =>   'required',
            'numeroTelefono'            =>   'required',
            'correoComercial'           =>   'nullable|email',
            'correoCobranza'            =>   'nullable|email',
            'montoCredito'              =>   'required',
            'moneda'                    =>   'required',
            'diasCredito'               =>   'required',
            'counter'                   =>   'required',
            'tipoDocumento'             =>   'required',
            'vendedor'                  =>   'required',
            'area'                      =>   'required',
            'cobrador'                  =>   'required',
            'tipoFacturacion'           =>   'required',
            'estado'                    =>   'required',
        ];
    }

    protected $messages = [
        'razonSocial.required'               =>   'Este campo es requerido',
        'nombreComercial.required'           =>   'Este campo es requerido',
        'direccionFiscal.required'           =>   'Este campo es requerido',
        'direccionFacturacion.required'      =>   'Este campo es requerido',
        'tipoCliente.required'               =>   'Debe seleccionar una opción',
        'tipoDocumentoIdentidad.required'    =>   'Debe seleccionar una opción',
        'numeroDocumentoIdentidad.required'  =>   'Este campo es requerido',
        'numeroTelefono.required'            =>   'Este campo es requerido',
        'contactoComercial.required'         =>   'Este campo es requerido',
        'telefonoComercial.required'         =>   'Este campo es requerido',
        'correoComercial.email'              =>   'Este campo no tiene el formato correcto',
        'contactoCobranza.required'          =>   'Este campo es requerido',
        'telefonoCobranza.required'          =>   'Este campo es requerido',
        'correoCobranza.email'               =>   'Este campo no tiene el formato correcto',
        'montoCredito.required'              =>   'Este campo es requerido',
        'moneda.required'                    =>   'Debe seleccionar una opción',
        'diasCredito.required'               =>   'Este campo es requerido',
        'counter.required'                   =>   'Debe seleccionar una opción',
        'tipoDocumento.required'             =>   'Debe seleccionar una opción',
        'vendedor.required'                  =>   'Debe seleccionar una opción',
        'area.required'                      =>   'Debe seleccionar una opción',
        'cobrador.required'                  =>   'Debe seleccionar una opción',
        'tipoFacturacion.required'           =>   'Debe seleccionar una opción',
        'estado.required'                    =>   'Debe seleccionar una opción',
    ];
    
    public function render()
    {
        $clientes = Cliente::where('razonSocial', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        $tipoDocumentoIdentidads = TipoDocumentoIdentidad::all()->sortBy('descripcion');
        $tipoClientes = TipoCliente::all()->sortBy('descripcion');
        $monedas = moneda::all()->sortBy('codigo');
        $counters = Counter::all()->sortBy('nombres');
        $tipoDocumentos = TipoDocumento::all()->sortBy('descripcion');
        $tipoClientes = TipoCliente::all()->sortBy('descripcion');
        $vendedors = Vendedor::all()->sortBy('nombre');
        $areas = Area::all()->sortBy('descripcion');
        $cobradors = Cobrador::all()->sortBy('nombre');
        $tipoFacturacions = TipoFacturacion::all()->sortBy('descripcion');
        $estados = Estado::all()->sortBy('descripcion');
        
        return view('livewire.entidades.clientes', compact('clientes','tipoDocumentoIdentidads','estados',
                                                            'tipoClientes','monedas','counters','tipoDocumentos',
                                                        'tipoClientes','vendedors','areas','cobradors',
                                                        'tipoFacturacions'));
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

        $cliente = new Cliente();
        $cliente->razonSocial = $this->razonSocial;
        $cliente->nombreComercial = $this->nombreComercial;
        $cliente->direccionFiscal = $this->direccionFiscal;
        $cliente->direccionFacturacion = $this->direccionFacturacion;
        $cliente->tipoCliente = $this->tipoCliente;
        $cliente->tipoDocumentoIdentidad = $this->tipoDocumentoIdentidad;
        $cliente->numeroDocumentoIdentidad = $this->numeroDocumentoIdentidad;
        $cliente->numeroTelefono = $this->numeroTelefono;
        $cliente->contactoComercial = $this->contactoComercial;
        $cliente->telefonoComercial = $this->telefonoComercial;
        $cliente->correoComercial = $this->correoComercial;
        $cliente->contactoCobranza = $this->contactoCobranza;
        $cliente->telefonoCobranza = $this->telefonoCobranza;
        $cliente->correoCobranza = $this->correoCobranza;
        $cliente->montoCredito = $this->montoCredito;
        $cliente->moneda = $this->moneda;
        $cliente->diasCredito = $this->diasCredito;
        $cliente->counter = $this->counter;
        $cliente->tipoDocumento = $this->tipoDocumento;
        $cliente->vendedor = $this->vendedor;
        $cliente->area = $this->area;
        $cliente->cobrador = $this->cobrador;
        $cliente->tipoFacturacion = $this->tipoFacturacion;
        $cliente->estado = $this->estado;
        $cliente->usuarioCreacion = auth()->user()->id;
        $cliente->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function limpiarControles(){
        $this->idRegistro = 0;
        $this->razonSocial = '';
        $this->nombreComercial = '';
        $this->direccionFiscal = '';
        $this->direccionFacturacion = '';
        $this->tipoCliente = '';
        $this->tipoDocumentoIdentidad = '';
        $this->numeroDocumentoIdentidad = '';
        $this->numeroTelefono = '';
        $this->contactoComercial = '';
        $this->telefonoComercial = '';
        $this->correoComercial = '';
        $this->contactoCobranza = '';
        $this->telefonoCobranza = '';
        $this->correoCobranza = '';
        $this->montoCredito = '';
        $this->moneda = '';
        $this->diasCredito = '';
        $this->counter = '';
        $this->tipoDocumento = '';
        $this->vendedor = '';
        $this->area = '';
        $this->cobrador = '';
        $this->tipoFacturacion = '';
        $this->estado = '';
    }

    public function editar($id){
        $cliente = Cliente::find($id);
        $this->limpiarControles();
        $this->idRegistro = $cliente->id;
        $this->razonSocial = $cliente->razonSocial;
        $this->nombreComercial = $cliente->nombreComercial;
        $this->direccionFiscal = $cliente->direccionFiscal;
        $this->direccionFacturacion = $cliente->direccionFacturacion;
        $this->tipoCliente = $cliente->tipoCliente;
        $this->tipoDocumentoIdentidad = $cliente->tipoDocumentoIdentidad;
        $this->numeroDocumentoIdentidad = $cliente->numeroDocumentoIdentidad;
        $this->numeroTelefono = $cliente->numeroTelefono;
        $this->contactoComercial = $cliente->contactoComercial;
        $this->telefonoComercial = $cliente->telefonoComercial;
        $this->correoComercial = $cliente->correoComercial;
        $this->contactoCobranza = $cliente->contactoCobranza;
        $this->telefonoCobranza = $cliente->telefonoCobranza;
        $this->correoCobranza = $cliente->correoCobranza;
        $this->montoCredito = $cliente->montoCredito;
        $this->moneda = $cliente->moneda;
        $this->diasCredito = $cliente->diasCredito;
        $this->counter = $cliente->counter;
        $this->tipoDocumento = $cliente->tipoDocumento;
        $this->vendedor = $cliente->vendedor;
        $this->area = $cliente->area;
        $this->cobrador = $cliente->cobrador;
        $this->tipoFacturacion = $cliente->tipoFacturacion;
        $this->estado = $cliente->estado;
    }

    public function actualizar($id){
        $cliente = Cliente::find($id);
        $cliente->razonSocial = $this->razonSocial;
        $cliente->nombreComercial = $this->nombreComercial;
        $cliente->direccionFiscal = $this->direccionFiscal;
        $cliente->direccionFacturacion = $this->direccionFacturacion;
        $cliente->tipoCliente = $this->tipoCliente;
        $cliente->tipoDocumentoIdentidad = $this->tipoDocumentoIdentidad;
        $cliente->numeroDocumentoIdentidad = $this->numeroDocumentoIdentidad;
        $cliente->numeroTelefono = $this->numeroTelefono;
        $cliente->contactoComercial = $this->contactoComercial;
        $cliente->telefonoComercial = $this->telefonoComercial;
        $cliente->correoComercial = $this->correoComercial;
        $cliente->contactoCobranza = $this->contactoCobranza;
        $cliente->telefonoCobranza = $this->telefonoCobranza;
        $cliente->correoCobranza = $this->correoCobranza;
        $cliente->montoCredito = $this->montoCredito;
        $cliente->moneda = $this->moneda;
        $cliente->diasCredito = $this->diasCredito;
        $cliente->counter = $this->counter;
        $cliente->tipoDocumento = $this->tipoDocumento;
        $cliente->vendedor = $this->vendedor;
        $cliente->area = $this->area;
        $cliente->cobrador = $this->cobrador;
        $cliente->tipoFacturacion = $this->tipoFacturacion;
        $cliente->estado = $this->estado;
        $cliente->usuarioModificacion = auth()->user()->id;
        $cliente->save();
        $this->limpiarControles();
    }

    public function encontrar($id){
        $cliente = Cliente::find($id);
        $this->idRegistro = $cliente->id;
        $this->razonSocial = $cliente->razonSocial;
    }

    public function eliminar($id){
        $Cliente = Cliente::find($id);
        $Cliente->delete();
        $this->limpiarControles();
    }

    public function exportar(){
        return Excel::download(new ClienteExport,'Clientes.xlsx');
    }

}
