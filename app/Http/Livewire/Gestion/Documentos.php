<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Documento;
use App\Models\TipoDocumento;
use App\Models\Estado;
use App\Models\Cliente;
use Carbon\Carbon;
use App\Clases\Funciones;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentoExport;

class Documentos extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'id';
    public $direction = 'desc';
    public $filtroCliente;

    public $idRegistro,$idCliente,$razonSocial,$direccionFiscal,$numeroDocumentoIdentidad,$idTipoDocumento,
    $tipoDocumento,$serie,$numero,$idMoneda,$moneda,$fechaEmision,$fechaVencimiento,$detraccion,$afecto,
    $inafecto,$exonerado,$igv,$otrosImpuestos,$total,$totalLetras,$glosa,$numeroFile,$tipoServicio,
    $documentoReferencia,$idMotivoNC,$idMotivoND,$tipoCambio,$idEstado,$respuestaSunat,$usuarioCreacion,
    $usuarioModificacion,$numeroCompleto,$comprobante,$motivoBaja,$codigoDoc,$fechaBaja,$respSenda,
    $startDate,$endDate;

    protected $documentos;

    public function mount(){
        $fechaActual = Carbon::now();
        
        $this->endDate = Carbon::parse($fechaActual)->format("Y-m-d");
        $this->startDate = $fechaActual->subDay(15)->format("Y-m-d");
        

        $this->documentos = Documento::query()
            ->when($this->filtroCliente, function($query){
                $query->where('idCliente', $this->filtroCliente);
            })
            ->when($this->search, function($query){
                $query->where('numero', 'like', '%'. $this->search . '%');
            })
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(8);
    }
    public function render()
    {
        if (strlen($this->search)> 0){
            $this->documentos = Documento::query()
            ->when($this->search, function($query){
                $query->where('numero', 'like', '%'. $this->search . '%');
            })
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(8);
        }
        $this->filtrar();
        
        // $documentos = Documento::where('numero', 'like', "%$this->search%")
        // $documentos = $this->documentos;
        // $this->documentos = Documento::query()
        //     ->when($this->filtroCliente, function($query){
        //         $query->where('idCliente', $this->filtroCliente);
        //     })
        //     ->when($this->search, function($query){
        //         $query->where('numero', 'like', '%'. $this->search . '%');
        //     })
        //                     ->orderBy($this->sort, $this->direction)
        //                     ->paginate(8);
        // // $documentos = $this->documentos;
        $tipoDocumentos = TipoDocumento::all()->sortBy('descripcion');
        $estados = Estado::all()->sortBy('descripcion');
        $clientes = Cliente::all()->sortBy('razonSocial');
        return view('livewire.gestion.documentos',compact('tipoDocumentos','estados','clientes'));
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

    public function filtrar(){
        // dd($this->filtroCliente);
        if($this->filtroCliente){
            $this->documentos = Documento::whereBetween('fechaEmision', [$this->startDate, $this->endDate])
            ->where('idCliente',$this->filtroCliente)
            ->paginate(8);
        }else{
            $this->documentos = Documento::whereBetween('fechaEmision', [$this->startDate, $this->endDate])
            ->paginate(8);
        }
        
        // dd($this->documentos);
    }

    public function ver($id){
        $documento = Documento::find($id);
        $this->idRegistro = $documento->id;
        $this->idCliente = $documento->idCliente;
        $this->razonSocial = $documento->razonSocial;
        $this->direccionFiscal = $documento->direccionFiscal;
        $this->numeroDocumentoIdentidad = $documento->numeroDocumentoIdentidad;
        $this->idTipoDocumento = $documento->idTipoDocumento;
        $this->tipoDocumento = $documento->tipoDocumento;
        $this->serie = $documento->serie;
        $this->numero = $documento->numero;
        $this->idMoneda = $documento->idMoneda;
        $this->moneda = $documento->moneda;
        $this->fechaEmision = $documento->fechaEmision;
        $this->fechaVencimiento = $documento->fechaVencimiento;
        $this->detraccion = $documento->detraccion;
        $this->afecto = $documento->afecto;
        $this->inafecto = $documento->inafecto;
        $this->exonerado = $documento->exonerado;
        $this->igv = $documento->igv;
        $this->otrosImpuestos = $documento->otrosImpuestos;
        $this->total = $documento->total;
        $this->totalLetras = $documento->totalLetras;
        $this->glosa = $documento->glosa;
        $this->numeroFile = $documento->numeroFile;
        $this->tipoServicio = $documento->tipoServicio;
        $this->documentoReferencia = $documento->documentoReferencia;
        $this->idMotivoNC = $documento->idMotivoNC;
        $this->idMotivoND = $documento->idMotivoND;
        $this->tipoCambio = $documento->tipoCambio;
        $this->idEstado = $documento->idEstado;
        $this->respuestaSunat = $documento->respuestaSunat;
        $this->usuarioCreacion = $documento->usuarioCreacion;
        $this->usuarioModificacion = $documento->usuarioModificacion;
    }

    public function encontrar($id){
        $documento = Documento::find($id);
        $this->idRegistro = $documento->id;
        $this->numero = $documento->numero;
        $this->numeroCompleto = str_pad($documento->numero,8,"0",STR_PAD_LEFT);
        $this->serie = $documento->serie;
        $this->comprobante = $documento->tTipoDocumento->descripcion;
        $tipoDoc = TipoDocumento::find($documento->idTipoDocumento);
        $this->codigoDoc = $tipoDoc->codigo;

        $fechaActual = Carbon::now();
        $this->fechaBaja = Carbon::parse($fechaActual)->format("Y-m-d");
    }

    public function anular(){
        $dataToSend = [
            "ruc_emisor" => "20604309027",
            "nro_efact" => $this->serie . $this->numeroCompleto,
            "tipodocu" => $this->codigoDoc, 
            "fechabaja" => $this->fechaBaja, 
            "motivobaja" => $this->motivoBaja 
        ];

        $funciones = new Funciones();
        $this->respSenda = $funciones->anularCPE($dataToSend);

        if ($this->respSenda['type'] == 'success') {
            $doc = Documento::find($this->idRegistro);
            $doc->respuestaBaja = $this->respSenda;
            $doc->idEstado = 2;
            $doc->save();

            session()->flash('success', 'El documento se ha anulado correctamente');

        } else {
            session()->flash('error', 'Ocurrió un error enviando a Sunat');
        }

    }

    public function limpiarControles(){

    }

    public function exportar(){
        return Excel::download(new DocumentoExport($this->filtroCliente,$this->startDate,$this->endDate),'Documentos.xlsx');
    }
}
