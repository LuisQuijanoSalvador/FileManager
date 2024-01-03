<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\moneda;
use App\Models\Boleto;
use App\Clases\Funciones;
use App\Models\Documento;
use App\Models\documentoDetalle;
use App\Models\Cliente;
use App\Models\TipoCambio;
use App\Clases\modelonumero;
use App\Models\Solicitante;

class Facturacionac extends Component
{
    use WithPagination;

    public $search = "";
    public $sort= 'numeroBoleto';
    public $direction = 'asc';
    
    public $idRegistro,$idMoneda=1,$tipoCambio,$fechaEmision,$detraccion=0,$glosa,$monedaLetra,$idCliente,
            $startDate,$endDate;
    protected $boletos=[];

    public $selectedRows = [];

    public function mount(){
        $this->boletos = Boleto::where('numeroBoleto', 'like', "%$this->search%")
                                ->whereNull('idDocumento')
                                ->where('idTipoFacturacion',2)
                                ->orderBy($this->sort, $this->direction)
                                ->paginate(10);

        $fechaActual = Carbon::now();
        
        $this->fechaEmision = Carbon::parse($fechaActual)->format("Y-m-d");

        $tipoCambio = TipoCambio::where('fechaCambio',$this->fechaEmision)->first();
        if($tipoCambio){
            $this->tipoCambio = $tipoCambio->montoCambio;
        }else{
            $this->tipoCambio = 0.00;
        }
    }

    public function render()
    {
        
        $monedas = moneda::all()->sortBy('codigo');
        $clientes = Cliente::all()->sortBy('razonSocial');

        return view('livewire.gestion.facturacionac',compact('monedas','clientes'));
    }

    public function updatedfechaEmision($fechaEmision){
        $tipoCambio = TipoCambio::where('fechaCambio',$fechaEmision)->first();
        if($tipoCambio){
            $this->tipoCambio = $tipoCambio->montoCambio;
        }else{
            $this->tipoCambio = 0.00;
        }
        //dd($this->tipoCambio);
    }

    public function filtrar(){
        if ($this->idCliente and $this->startDate and $this->endDate) {

            $this->boletos = Boleto::where('idCliente', $this->idCliente)
                                ->whereNull('idDocumento')
                                ->where('idTipoFacturacion',2)
                                ->whereBetween('fechaEmision', [$this->startDate, $this->endDate])
                                ->orderBy($this->sort, $this->direction)
                                ->paginate(10);
        }else{
            $this->boletos = Boleto::where('idTipoFacturacion',2)
                                ->whereNull('idDocumento')
                                ->whereBetween('fechaEmision', [$this->startDate, $this->endDate])
                                ->orderBy($this->sort, $this->direction)
                                ->paginate(10);
            }
    }
        

    public function emitirComprobante()
    {
        // 
        // $this->selectedRows contendrá los IDs de las filas seleccionadas
        $idsSeleccionados = $this->selectedRows;
        if (empty($idsSeleccionados)) {
            session()->flash('error', 'Debe seleccionar un boleto.');
            return false;
        } else {
            $boleto = Boleto::find($idsSeleccionados);

            $this->crearDocumento($boleto);
        }  
    }

}
