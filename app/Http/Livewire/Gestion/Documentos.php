<?php

namespace App\Http\Livewire\Gestion;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Documento;

class Documentos extends Component
{
    use WithPagination;
    public $search = "";
    public $sort= 'id';
    public $direction = 'desc';

    public $idRegsitro,$idCliente,$razonSocial,$direccionFiscal,$numeroDocumentoIdentidad,$idTipoDocumento,
    $tipoDocumento,$serie,$numero,$idMoneda,$moneda,$fechaEmision,$fechaVencimiento,$detraccion,$afecto,
    $inafecto,$exonerado,$igv,$otrosImpuestos,$total,$totalLetras,$glosa,$numeroFile,$tipoServicio,
    $documentoReferencia,$idMotivoNC,$idMotivoND,$tipoCambio,$idEstado,$respuestaSunat,$usuarioCreacion,
    $usuarioModificacion;

    public function render()
    {
        $documentos = Documento::where('numero', 'like', "%$this->search%")
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(6);
        return view('livewire.gestion.documentos',compact('documentos'));
    }

    public function ver($id){
        $documento = Documento::find($id);
        
    }
}
