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
    
    public $idRegistro,$idMoneda=1,$tipoCambio,$fechaEmision,$detraccion=0,$glosa,$monedaLetra;
    protected $boletos=[];

    public $selectedRows = [];
    
    public function render()
    {
        return view('livewire.gestion.facturacionac');
    }
}
