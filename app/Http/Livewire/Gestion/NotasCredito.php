<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use App\Models\Documento;
use App\Models\TipoDocumento;
use App\Models\motivoCredito;
use App\Models\TipoCambio;
use Carbon\Carbon;

class NotasCredito extends Component
{
    public $idTipoDocumento=1,$fechaEmision,$tipoCambio=0,$numeroDocumento,$glosa,$motivo=1,$monto=0;
    protected $documentos;

    public function updatedfechaEmision($fechaEmision){
        // dd($fechaCambio);
        $tipoCambio = TipoCambio::where('fechaCambio',$fechaEmision)->first();
        if($tipoCambio){
            $this->tipoCambio = $tipoCambio->montoCambio;
        }else{
            $this->tipoCambio = 0.00;
        }
        $this->fechaReserva = $fechaEmision;
    }

    public function mount(){
        $fechaActual = Carbon::now();
        
        $this->fechaEmision = Carbon::parse($fechaActual)->format("Y-m-d");
    }

    public function render()
    {
        $tipoDocumentos = TipoDocumento::all()->sortBy('descripcion');
        $motivos = motivoCredito::all()->sortBy('descripcion');
        return view('livewire.gestion.notas-credito', compact('tipoDocumentos','motivos'));
    }

    public function buscar(){
        $this->documentos = Documento::where('numero',$this->numeroDocumento)
                                    ->where('idTipoDocumento',$this->idTipoDocumento)
                                    ->get();
        
    }

    public function emitir(){
        if($this->monto==0){
            session()->flash('error', 'Verificar el monto.');
            $this->buscar();
            return;
        }
        $documento = new Documento();
        $totalLetras = $numLetras->numtoletras($this->totalTotal,$this->monedaLetra);
        
        $documento->idCliente = $dataBoleto->idCliente;
        $documento->razonSocial = $dataBoleto->tCliente->razonSocial;
        $documento->direccionFiscal = $dataBoleto->tCliente->direccionFiscal;
        $documento->numeroDocumentoIdentidad = $dataBoleto->tCliente->numeroDocumentoIdentidad;
        $documento->idTipoDocumento = $dataBoleto->idTipoDocumento;
        $documento->tipoDocumento = $dataBoleto->tTipoDocumento->codigo;
        $documento->serie = $numSerie;
        $documento->numero = $numComprobante;
        $documento->idMoneda = $dataBoleto->idMoneda;
        $documento->moneda = $dataBoleto->tMoneda->codigo;
        $documento->fechaEmision = $this->fechaEmision;
        $documento->fechaVencimiento = Carbon::parse($fechaVencimiento)->format("Y-m-d");
        $documento->detraccion = $this->detraccion;
        $documento->afecto = $this->totalNeto;
        $documento->inafecto = $this->totalInafecto;
        $documento->exonerado = 0;
        $documento->igv = $this->totalIGV;
        $documento->otrosImpuestos = $this->totalOtrosImpuestos;
        $documento->total = $this->totalTotal;
        $documento->totalLetras = $totalLetras;
        $documento->idMedioPago = $this->idMedioPago;
        $documento->glosa = $this->glosa;
        $documento->numeroFile = $dataBoleto->numeroFile;
        $documento->tipoServicio = 1;
        $documento->documentoReferencia = "";
        $documento->idMotivoNC = 0;
        $documento->idMotivoND = 0;
        $documento->tipoCambio = $this->tipoCambio;
        $documento->idEstado = 1;
        $documento->usuarioCreacion = auth()->user()->id;
        $documento->usuarioModificacion = auth()->user()->id;
        
        // $documento->save();
        
    }
}
