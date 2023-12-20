<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Aerolinea;
use App\Models\Area;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\Counter;
use App\Models\Estado;
use App\Models\Gds;
use App\Models\moneda;
use App\Models\Proveedor;
use App\Models\Solicitante;
use App\Models\TipoDocumento;
use App\Models\TipoFacturacion;
use App\Models\TipoPasajero;
use App\Models\TipoServicio;
use App\Models\Vendedor;
use App\Clases\Funciones;
use App\Exports\BoletoExport;
use App\Models\MedioPago;
use App\Models\TipoCambio;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BoletoRuta;
use App\Models\BoletoPago;
use App\Models\TarjetaCredito;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class Servicios extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'numeroServicio';
    public $direction = 'asc';
    public $clientes;
    public $solicitantes;
    public $selectedCliente = NULL;
    public $selectedSolicitante = 0;

    public $idRegistro,$numeroServicio,$numeroFile,$fechaEmision,$idCounter,
            $idTipoFacturacion,$idTipoDocumento=6,$idArea,$idVendedor,$idProveedor=0,
            $fechaReserva,$fechaIn,$fechaOut,$idTipoServicio=1,$tipoRuta="NACIONAL",$tipoTarifa="NORMAL",
            $origen="BSP",$pasajero,$idDocumento,$tipoCambio,$idMoneda=2,$tarifaNeta=0,$inafecto=0,$igv=0,
            $otrosImpuestos=0,$xm=0,$total=0,$totalOrigen=0,$porcentajeComision,$montoComision=0,
            $descuentoCorporativo,$codigoDescCorp,$tarifaNormal,$tarifaAlta,$tarifaBaja,
            $centroCosto,$cod1,$cod2,$cod3,$cod4,$observaciones,$estado=1,
            $usuarioCreacion,$fechaCreacion,$usuarioModificacion,$fechaModificacion;

    public $idMedioPago,$idTarjetaCredito,$numeroTarjeta,$monto,$fechaVencimientoTC,$servicioPagos;

    public function rules(){
        return[
            'numeroServicio' => 'required',
            'selectedCliente' => 'required',
            'fechaEmision' => 'required',
            'idCounter' => 'required',
            'idTipoFacturacion' => 'required',
            'idTipoDocumento' => 'required',
            'idArea' => 'required',
            'idVendedor' => 'required',
            'idProveedor' => 'required',
            'fechaReserva' => 'required',
            'idTipoServicio' => 'required',
            'pasajero' => 'required',
            'tipoCambio' => 'required',
            'idMoneda' => 'required',
            'tarifaNeta' => 'required',
            'igv' => 'required',
            'total' => 'required',
            'totalOrigen' => 'required',
            'estado' => 'required',

            'idMedioPago' => 'required',
            'monto' => 'required',
        ];
    }

    protected $messages = [
        'numeroServicio.required' => 'Este campo es requerido',
        'selectedCliente.required' => 'Este campo es requerido',
        'fechaEmision.required' => 'Este campo es requerido',
        'idCounter.required' => 'Este campo es requerido',
        'idTipoFacturacion.required' => 'Este campo es requerido',
        'idTipoDocumento.required' => 'Este campo es requerido',
        'idArea.required' => 'Este campo es requerido',
        'idVendedor.required' => 'Este campo es requerido',
        'idProveedor.required' => 'Este campo es requerido',
        'fechaReserva.required' => 'Este campo es requerido',
        'idTipoServicio.required' => 'Este campo es requerido',
        'pasajero.required' => 'Este campo es requerido',
        'tipoCambio.required' => 'Este campo es requerido',
        'idMoneda.required' => 'Este campo es requerido',
        'tarifaNeta.required' => 'Este campo es requerido',
        'igv.required' => 'Este campo es requerido',
        'total.required' => 'Este campo es requerido',
        'totalOrigen.required' => 'Este campo es requerido',
        'idTipoPagoConsolidador.required' => 'Este campo es requerido',
        'estado.required' => 'Este campo es requerido',

        'idMedioPago.required' => 'Requerido',
        'monto.required' => 'Requerido',
    ];

    public function mount(){
        $this->clientes = Cliente::all()->sortBy('razonSocial');
        $this->solicitantes = collect();
        $this->servicioPagos = new Collection();
    }

    public function updatedselectedCliente($cliente_id){
        $this->solicitantes = Solicitante::where('cliente', $cliente_id)->get();
        $cliente = Cliente::find($cliente_id);
        $this->idCounter = $cliente->counter;
        $this->idVendedor = $cliente->vendedor;
        $this->idArea = $cliente->area;
        $this->idTipoFacturacion = $cliente->tipoFacturacion;
    }

    public function updatedfechaEmision($fechaEmision){
        // dd($fechaCambio);
        $tipoCambio = TipoCambio::where('fechaCambio',$fechaEmision)->first();
        if($tipoCambio){
            $this->tipoCambio = $tipoCambio->montoCambio;
        }else{
            $this->tipoCambio = 0.00;
        }
        $this->fechaReserva = $fechaEmision;
        $this->fechaIn = $fechaEmision;
        $this->fechaOut = $fechaEmision;
    }
    
    public function render()
    {
        $servicios = Servicio::where('numeroFile', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        $counters = Counter::all()->sortBy('nombre');
        $tipoFacturacions = TipoFacturacion::all()->sortBy('descripcion');
        $tipoDocumentos = TipoDocumento::all()->sortBy('descripcion');
        $tipoServicios = TipoServicio::all()->sortBy('descripcion');
        $areas = Area::all()->sortBy('descripcion');
        $vendedors = Vendedor::all()->sortBy('nombre');
        $proveedors = Proveedor::where('esConsolidador',0)->get();
        $tipoPasajeros = TipoPasajero::all()->sortBy('descripcion');
        //ToDo: Agregar Documentos
        $monedas = moneda::all()->sortBy('codigo');
        $estados = Estado::all()->sortBy('descripcion');
        $usuarios = User::all()->sortBy('name');
        $medioPagos = MedioPago::all()->sortBy('descripcion');
        $tarjetaCreditos = TarjetaCredito::all()->sortBy('descripcion');
        return view('livewire.gestion.servicios', compact('servicios','counters','tipoFacturacions','tipoDocumentos',
                                                            'areas','medioPagos','vendedors','proveedors','tipoServicios',
                                                            'monedas','estados','usuarios','tarjetaCreditos','tipoPasajeros'));
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
        //$area = Area::find($this->idArea);
        $servicio = new Servicio();
        $funciones = new Funciones();
        $servicio->numeroServicio = $this->numeroServicio;

        $numServ = $funciones->numeroServicio('SERVICIOS');
        $servicio->numeroServicio = $numServ;
        $servicio->numeroFile = $this->numeroFile;
        $servicio->idCliente = $this->selectedCliente;
        $servicio->idSolicitante = $this->selectedSolicitante;
        $servicio->fechaEmision = $this->fechaEmision;
        $servicio->idCounter = $this->idCounter;
        $servicio->idTipoFacturacion = $this->idTipoFacturacion;
        $servicio->idTipoDocumento = $this->idTipoDocumento;
        $servicio->idArea = $this->idArea;
        $servicio->idVendedor = $this->idVendedor;
        $servicio->idProveedor = $this->idProveedor;
        $servicio->fechaReserva = $this->fechaReserva;
        $servicio->idTipoServicio = $this->idTipoServicio;
        $servicio->tipoRuta = $this->tipoRuta;
        $servicio->tipoTarifa = $this->tipoTarifa;
        $servicio->origen = $this->origen;
        $servicio->pasajero = $this->pasajero;
        $servicio->tipoCambio = $this->tipoCambio;
        $servicio->idMoneda = $this->idMoneda;
        $servicio->tarifaNeta = $this->tarifaNeta;
        $servicio->igv = $this->igv;
        $servicio->otrosImpuestos = $this->otrosImpuestos;
        $servicio->xm = $this->xm;
        $servicio->total = $this->total;
        $servicio->totalOrigen = $this->totalOrigen;
        $servicio->porcentajeComision = $this->porcentajeComision;
        $servicio->montoComision = $this->montoComision;
        $servicio->descuentoCorporativo = $this->descuentoCorporativo;
        $servicio->codigoDescCorp = $this->codigoDescCorp;
        $servicio->tarifaNormal = $this->tarifaNormal;
        $servicio->tarifaAlta = $this->tarifaAlta;
        $servicio->tarifaBaja = $this->tarifaBaja;
        $servicio->centroCosto = $this->centroCosto;
        $servicio->cod1 = $this->cod1;
        $servicio->cod2 = $this->cod2;
        $servicio->cod3 = $this->cod3;
        $servicio->cod4 = $this->cod4;
        $servicio->observaciones = $this->observaciones;
        $servicio->estado = $this->estado;
        $servicio->usuarioCreacion = auth()->user()->id;
        try {
            $boleto->save();
            $this->grabarPagos($servicio->id);
        } catch (\Throwable $th) {
            session()->flash('error', 'Ocurrió un error intentando grabar.');
        }
         
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han guardado exitosamente.');
    }

    public function grabarPagos($idServicio){
        $servicioPago = new ServicioPago();
        $servicioPago->idServicio = $idServicio;
        $servicioPago->idMedioPago = $this->idMedioPago;
        $servicioPago->idTarjetaCredito = $this->idTarjetaCredito;
        $servicioPago->numeroTarjeta = $this->numeroTarjeta;
        $servicioPago->monto = $this->monto;
        $servicioPago->fechaVencimientoTC = $this->fechaVencimientoTC;
        $servicioPago->idEstado = 1;
        $servicioPago->usuarioCreacion = auth()->user()->id;
        $servicioPago->save();
    }

    public function limpiarControles(){
        $this->idRegistro = '';
        $this->numeroServicio = '';
        $this->numeroFile = '';
        $this->fechaEmision = '';
        $this->idCounter = '';
        $this->idTipoFacturacion = '';
        $this->idTipoDocumento = '';
        $this->idArea = '';
        $this->idVendedor = '';
        $this->idProveedor = '';
        $this->fechaReserva = '';
        $this->idTipoServicio = '';
        $this->tipoRuta = '';
        $this->tipoTarifa = '';
        $this->origen = '';
        $this->pasajero = '';
        $this->idDocumento = '';
        $this->tipoCambio = '';
        $this->idMoneda = '';
        $this->tarifaNeta = '';
        $this->igv = '';
        $this->otrosImpuestos = '';
        $this->xm = '';
        $this->total = '';
        $this->totalOrigen = '';
        $this->porcentajeComision = '';
        $this->montoComision = '';
        $this->descuentoCorporativo = '';
        $this->codigoDescCorp = '';
        $this->tarifaNormal = '';
        $this->tarifaAlta = '';
        $this->tarifaBaja = '';
        $this->centroCosto = '';
        $this->cod1 = '';
        $this->cod2 = '';
        $this->cod3 = '';
        $this->cod4 = '';
        $this->observaciones = '';
        $this->estado = '';
        $this->usuarioCreacion = '';
        $this->fechaCreacion = '';
        $this->usuarioModificacion = '';
        $this->fechaModificacion = '';
        $this->idMedioPago = '';
        $this->idTarjetaCredito = '';
        $this->numeroTarjeta = '';
        $this->monto = '';
        $this->fechaVencimientoTC = '';
        $this->servicioPagos = '';
    }

    public function editar($id){
        $servicio = Servicio::find($id);
        $this->limpiarControles();
        $this->idRegistro = $servicio->idRegistro;
        $this->numeroServicio = $servicio->numeroServicio;
        $this->numeroFile = $servicio->numeroFile;
        $this->fechaEmision = $servicio->fechaEmision;
        $this->idCounter = $servicio->idCounter;
        $this->idTipoFacturacion = $servicio->idTipoFacturacion;
        $this->idTipoDocumento = $servicio->idTipoDocumento;
        $this->idArea = $servicio->idArea;
        $this->idVendedor = $servicio->idVendedor;
        $this->idProveedor = $servicio->idProveedor;
        $this->fechaReserva = $servicio->fechaReserva;
        $this->idTipoServicio = $servicio->idTipoServicio;
        $this->tipoRuta = $servicio->tipoRuta;
        $this->tipoTarifa = $servicio->tipoTarifa;
        $this->origen = $servicio->origen;
        $this->pasajero = $servicio->pasajero;
        $this->idDocumento = $servicio->idDocumento;
        $this->tipoCambio = $servicio->tipoCambio;
        $this->idMoneda = $servicio->idMoneda;
        $this->tarifaNeta = $servicio->tarifaNeta;
        $this->igv = $servicio->igv;
        $this->otrosImpuestos = $servicio->otrosImpuestos;
        $this->xm = $servicio->xm;
        $this->total = $servicio->total;
        $this->totalOrigen = $servicio->totalOrigen;
        $this->porcentajeComision = $servicio->porcentajeComision;
        $this->montoComision = $servicio->montoComision;
        $this->descuentoCorporativo = $servicio->descuentoCorporativo;
        $this->codigoDescCorp = $servicio->codigoDescCorp;
        $this->tarifaNormal = $servicio->tarifaNormal;
        $this->tarifaAlta = $servicio->tarifaAlta;
        $this->tarifaBaja = $servicio->tarifaBaja;
        $this->centroCosto = $servicio->centroCosto;
        $this->cod1 = $servicio->cod1;
        $this->cod2 = $servicio->cod2;
        $this->cod3 = $servicio->cod3;
        $this->cod4 = $servicio->cod4;
        $this->observaciones = $servicio->observaciones;
        $this->estado = $servicio->estado;
        $this->usuarioCreacion = $servicio->usuarioCreacion;
        $this->fechaCreacion = Carbon::parse($servicio->created_at)->format("Y-m-d");
        $this->usuarioModificacion = $servicio->usuarioModificacion;
        $this->fechaModificacion = Carbon::parse($servicio->updated_at)->format("Y-m-d");
    }

    public function actualizar($id){
        $servicio = Servicio::find($id);
        $servicio->numeroServicio = $this->numeroServicio;
        $servicio->numeroFile = $this->numeroFile;
        $servicio->fechaEmision = $this->fechaEmision;
        $servicio->idCounter = $this->idCounter;
        $servicio->idTipoFacturacion = $this->idTipoFacturacion;
        $servicio->idTipoDocumento = $this->idTipoDocumento;
        $servicio->idArea = $this->idArea;
        $servicio->idVendedor = $this->idVendedor;
        $servicio->idProveedor = $this->idProveedor;
        $servicio->fechaReserva = $this->fechaReserva;
        $servicio->idTipoServicio = $this->idTipoServicio;
        $servicio->tipoRuta = $this->tipoRuta;
        $servicio->tipoTarifa = $this->tipoTarifa;
        $servicio->origen = $this->origen;
        $servicio->pasajero = $this->pasajero;
        $servicio->idDocumento = $this->idDocumento;
        $servicio->tipoCambio = $this->tipoCambio;
        $servicio->idMoneda = $this->idMoneda;
        $servicio->tarifaNeta = $this->tarifaNeta;
        $servicio->igv = $this->igv;
        $servicio->otrosImpuestos = $this->otrosImpuestos;
        $servicio->xm = $this->xm;
        $servicio->total = $this->total;
        $servicio->totalOrigen = $this->totalOrigen;
        $servicio->porcentajeComision = $this->porcentajeComision;
        $servicio->montoComision = $this->montoComision;
        $servicio->descuentoCorporativo = $this->descuentoCorporativo;
        $servicio->codigoDescCorp = $this->codigoDescCorp;
        $servicio->tarifaNormal = $this->tarifaNormal;
        $servicio->tarifaAlta = $this->tarifaAlta;
        $servicio->tarifaBaja = $this->tarifaBaja;
        $servicio->centroCosto = $this->centroCosto;
        $servicio->cod1 = $this->cod1;
        $servicio->cod2 = $this->cod2;
        $servicio->cod3 = $this->cod3;
        $servicio->cod4 = $this->cod4;
        $servicio->observaciones = $this->observaciones;
        $servicio->estado = $this->estado;
        $servicio->usuarioModificacion = auth()->user()->id;
        $servicio->save();
        $this->limpiarControles();
        session()->flash('success', 'Los datos se han actualizado exitosamente.');
    }

    public function encontrar($id){
        $servicio = Servicio::find($id);
        $this->idRegistro = $servicio->id;
        $this->numeroBoleto = $servicio->numeroServicio;
    }

    public function eliminar($id){
        $servicio = Servicio::find($id);
        $servicio->delete();
        $this->limpiarControles();
    }

    public function addPago(){
        if ($this->idMedioPago !== null && $this->idTarjetaCredito  !== null && $this->monto  !== null) {
            $mp = MedioPago::find($this->idMedioPago);
            $tc = TarjetaCredito::find($this->idTarjetaCredito);
            $this->servicioPagos->add(array(
                'idMedioPago' => $this->idMedioPago,
                'medioPago' => $mp->descripcion,
                'idTarjetaCredito' => $this->idTarjetaCredito,
                'tarjetaCredito' => $tc->descripcion,
                'numeroTarjeta' => $this->numeroTarjeta,
                'monto' => $this->monto,
                'fechaVencimientoTC' => $this->fechaVencimientoTC
            ));
            $this->resetPagos();
        }
    }

    public function resetPagos(){
        $this->idMedioPago = '';
        $this->idTarjetaCredito = '';
        $this->numeroTarjeta = '';
        $this->monto = '';
        $this->fechaVencimientoTC = '';
    }

    public function quitarPago($indice){
        unset($this->servicioPagos[$indice]);
    }
}