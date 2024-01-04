<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Documento;
use App\Models\TipoDocumento;
use App\Models\Estado;
use App\Models\Cliente;

class Documentos extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'id';
    public $direction = 'desc';

    public $idRegistro,$idCliente,$razonSocial,$direccionFiscal,$numeroDocumentoIdentidad,$idTipoDocumento,
    $tipoDocumento,$serie,$numero,$idMoneda,$moneda,$fechaEmision,$fechaVencimiento,$detraccion,$afecto,
    $inafecto,$exonerado,$igv,$otrosImpuestos,$total,$totalLetras,$glosa,$numeroFile,$tipoServicio,
    $documentoReferencia,$idMotivoNC,$idMotivoND,$tipoCambio,$idEstado,$respuestaSunat,$usuarioCreacion,
    $usuarioModificacion;

    public function render()
    {
        $documentos = Documento::where('numero', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(8);
        $tipoDocumentos = TipoDocumento::all()->sortBy('descripcion');
        $estados = Estado::all()->sortBy('descripcion');
        $clientes = Cliente::all()->sortBy('razonSocial');
        return view('livewire.gestion.documentos',compact('documentos','tipoDocumentos','estados','clientes'));
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

    public function limpiarControles(){

    }
}
