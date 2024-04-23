<?php

namespace App\Http\Livewire\Files;

use Livewire\Component;
use App\Models\File;
use App\Models\Cliente;
use App\Models\Solicitante;
use App\Models\Counter;
use App\Models\Area;
use App\Models\Vendedor;
use App\Models\Proveedor;
use App\Models\TipoTicket;
use App\Models\Aerolinea;
use App\Models\moneda;
use App\Models\User;
use App\Models\Boleto;

class EditarFiles extends Component
{
    public $clientes;
    public $selectedCliente = NULL;
    public $selectedSolicitante = 0;

    public $idRegistro,$numeroBoleto,$idCounter, $idArea=1,$idVendedor,$idConsolidador=2,
            $idTipoTicket=1,$idAerolinea=7,$pasajero,$idMoneda=1,$tarifaNeta=0,$xm=0,$total=0,$totalOrigen=0,
            $porcentajeComision,$montoComision=0,$idSolicitante,
            $centroCosto,$cod1,$cod2,$cod3,$cod4,$usuarioModificacion,$fechaModificacion;
    public $numeroFile, $descripcion, $cliente, $area;
    public $solicitantes;

    public function mount(){
        $this->idRegistro = request()->route('id');
        $file = File::find($this->idRegistro);
        $this->numeroFile = $file->numeroFile;
        $this->descripcion = $file->descripcion;
        $this->cliente = $file->tCliente->razonSocial;
        $this->area = $file->tArea->descripcion;
        $this->solicitantes = collect();
        $this->clientes = Cliente::all()->sortBy('razonSocial');
    }

    public function updatedselectedCliente($cliente_id){
        $this->solicitantes = Solicitante::where('cliente', $cliente_id)->get();
        
        
    }
    public function render()
    {
        $counters = Counter::all()->sortBy('nombre');
        $areas = Area::all()->sortBy('descripcion');
        $vendedors = Vendedor::all()->sortBy('nombre');
        $consolidadors = Proveedor::where('esConsolidador',1)->get();
        $tipoTickets = TipoTicket::all()->sortBy('descripcion');
        $aerolineas = Aerolinea::all()->sortBy('razonSocial');
        $monedas = moneda::all()->sortBy('codigo');
        $usuarios = User::all()->sortBy('name');
        $clientes = Cliente::all()->sortBy('razonSocial');
        return view('livewire.files.editar-files',compact('clientes','counters',
                'areas','vendedors','consolidadors','tipoTickets',
                'aerolineas','monedas','usuarios'));
    }

    public function buscar(){
        $boleto = Boleto::where('numeroBoleto',$this->numeroBoleto)->first();
        if(!$boleto){
            session()->flash('error', 'Boleto no existe');
            return;
        }
        $this->idAerolinea = $boleto->idAerolinea;
        $this->selectedCliente = $boleto->idCliente;
        $this->idCounter = $boleto->idCounter;
        $this->idArea = $boleto->idArea;
        $this->idVendedor = $boleto->idVendedor;
        $this->idTipoTicket = $boleto->idTipoTicket;
        $this->selectedSolicitante = $boleto->idSolicitante;
        $this->pasajero = $boleto->pasajero;
        $this->idMoneda = $boleto->idMoneda;
        $this->tarifaNeta = $boleto->tarifaNeta;
        $this->total = $boleto->total;
        $this->totalOrigen = $boleto->totalOrigen;
        $this->xm = $boleto->xm;
        $this->montoComision = $boleto->montoComision;
        $this->solicitantes = Solicitante::where('cliente', $boleto->idCliente)->get();
        $this->idSolicitante = $boleto->idSolicitante;

    }

    public function guardarBoleto(){
        $fileDetalle = new FileDetalle();
        $fileDetalle->idFile = $this->idRegistro;
        $fileDetalle->numeroFile = $this->numeroFile;
        $fileDetalle->idBoleto = $boleto->id;
        $fileDetalle->idEstado = 1;
        $fileDetalle->usuarioCreacion = auth()->user()->id;
        $fileDetalle->save();
        
    }

    public function actualizar(){
        
    }
    public function limpiarControles(){

    }
}
