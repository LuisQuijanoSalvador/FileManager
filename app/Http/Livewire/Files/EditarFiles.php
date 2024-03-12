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
            $porcentajeComision,$montoComision=0,
            $centroCosto,$cod1,$cod2,$cod3,$cod4,$usuarioModificacion,$fechaModificacion;
    public $numeroFile, $descripcion, $cliente, $area;
    public $solicitantes;

    public function mount(){
        $file = File::find(request()->route('id'));
        $this->numeroFile = $file->numeroFile;
        $this->descripcion = $file->descripcion;
        $this->cliente = $file->tCliente->razonSocial;
        $this->area = $file->tArea->descripcion;
        $this->solicitantes = collect();
        $this->clientes = Cliente::all()->sortBy('razonSocial');
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
        // $this->solicitantes = Solicitante::where('cliente', $cliente_id)->get();
    }

    public function limpiarControles(){

    }
}
