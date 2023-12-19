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

class Facturacion extends Component
{
    use WithPagination;

    public $search = "";
    public $sort= 'numeroBoleto';
    public $direction = 'asc';
    
    public $idRegistro,$idMoneda=2,$tipoCambio,$fechaEmision,$detraccion=0,$glosa,$monedaLetra;
    protected $boletos=[];

    public $selectedRows = [];

    public $startDate;// = Carbon::parse($fechaActual->subDays(7))->format("Y-m-d");
    public $endDate;// = Carbon::parse($fechaActual2)->format("Y-m-d");
    
    public function mount(){
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
        
        $this->boletos = Boleto::where('numeroBoleto', 'like', "%$this->search%")
                            ->whereNull('idDocumento')
                            ->where('idTipoFacturacion',1)
                            ->orderBy($this->sort, $this->direction)
                            ->paginate(10);
        $monedas = moneda::all()->sortBy('codigo');
        
        return view('livewire.gestion.facturacion',compact('monedas'));
    }

    public function filtrarFechas(){
        $this->boletos = Boleto::whereBetween('fechaEmision', [$this->startDate, $this->endDate])->get();
        // dd($this->boletos);
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

    public function crearDocumento($dataBoleto){
        $documento = new Documento();
        $funciones = new Funciones();
        $numLetras = new modelonumero();
        $numComprobante = $funciones->numeroComprobante('DOCUMENTO DE COBRANZA');
        $cliente = Cliente::find($dataBoleto->idCliente);
        $fechaVencimiento = Carbon::parse($this->fechaEmision)->addDays($cliente->diasCredito);
        if ($dataBoleto->tMoneda->codigo == 'USD') {
            $this->monedaLetra = 'DOLARES AMERICANOS';
        } elseif($dataBoleto->tMoneda->codigo == 'PEN'){
            $this->monedaLetra = 'SOLES';
        }
        
        $totalLetras = $numLetras->numtoletras($dataBoleto->total,$this->monedaLetra);
        
        $documento->idCliente = $dataBoleto->idCliente;
        $documento->razonSocial = $dataBoleto->tCliente->razonSocial;
        $documento->direccionFiscal = $dataBoleto->tCliente->direccionFiscal;
        $documento->numeroDocumentoIdentidad = $dataBoleto->tCliente->numeroDocumentoIdentidad;
        $documento->idTipoDocumento = $dataBoleto->idTipoDocumento;
        $documento->tipoDocumento = $dataBoleto->tTipoDocumento->codigo;
        $documento->serie = '0001';
        $documento->numero = $numComprobante;
        $documento->idMoneda = $dataBoleto->idMoneda;
        $documento->moneda = $dataBoleto->tMoneda->codigo;
        $documento->fechaEmision = $this->fechaEmision;
        $documento->fechaVencimiento = Carbon::parse($fechaVencimiento)->format("Y-m-d");
        $documento->detraccion = $this->detraccion;
        $documento->afecto = $dataBoleto->tarifaNeta;
        $documento->inafecto = $dataBoleto->inafecto;
        $documento->exonerado = 0;
        $documento->igv = $dataBoleto->igv;
        $documento->otrosImpuestos = $dataBoleto->otrosImpuestos;
        $documento->total = $dataBoleto->total;
        $documento->totalLetras = $totalLetras;
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
        $documento->save();

        $idsSeleccionados = $this->selectedRows;
        $boleto = Boleto::find($idsSeleccionados);
        $boleto->idDocumento = $documento->id;
        $boleto->save();

        $this->enviaDC($documento);
    }

    public function enviaDC($comprobante){

        // Datos a enviar en formato JSON
        $dataToSend = [
            "cabecera" => [
                "ruc_emisor" => "20604309027" ,
                "razonsocial_emisor"=> "AS TRAVEL PERU S.A.C",
                "direccion_emisor"=> "CAL.CALLE MARQUES DE MONTESCLAROS NRO. 165 DPTO. 104 URB. LA VIRREYNA LIMA - LIMA - SANTIAGO DE SURCO",
                "telefono_emisor"=> "(01) 972197067",
                "email_emisor"=> "facturaselectronicas@astravel.com.pe",
                "cod_domifiscal"=> "0000",
                "tiop_codi"=> "0101",
                "fecha"=> $comprobante->fechaEmision,
                "fvenci"=> $comprobante->fechaVencimiento,
                "tipodocu"=> $comprobante->tipoDocumento,
                "nro_serie_efact"=> "0001",
                "tipo_moneda"=> $comprobante->moneda,
                "numero"=> str_pad($comprobante->numero,8,"0",STR_PAD_LEFT),
                "tipodocurefe"=> "",
                "numerorefe"=> "",
                "motivo_07_08"=> "",
                "descripcion_07_08"=> "",
                "fecharefe"=> "1900-01-01T00=>00=>00",
                "tipodoi"=> 6,
                "numerodoi"=> $comprobante->numeroDocumentoIdentidad,
                "desc_tipodocu"=> "RUC",
                "razonsocial"=> $comprobante->razonSocial,
                "direccion"=> $comprobante->direccionFiscal,
                "cliente"=> $comprobante->razonSocial,
                "email_cliente"=> "",
                "email_cc"=> "",
                "codigo_cliente"=> $comprobante->idCliente,
                "rec_tele"=> null,
                "rec_ubigeo"=> "",
                "rec_pais"=> "",
                "rec_depa"=> "",
                "rec_provi"=> "",
                "rec_distri"=> "",
                "rec_urb"=> "",
                "vendedor"=> "AS TRAVEL",
                "metodo_pago"=> "CONTADO",
                "codigo_metodopago"=> "CON",
                "desc_metodopago"=> "",
                "totalpagado_efectivo"=> "0.00",
                "vuelto"=> "0.00",
                "file_nro"=> $comprobante->numeroFile,
                "centro_costo"=> "",
                "nro_pedido"=> "",
                "local"=> "",
                "caja"=> "",
                "cajero"=> "",
                "nro_transaccion"=> "",
                "orden_compra"=> "",
                "glosa"=> $comprobante->glosa,
                "glosa_refe"=> "",
                "glosa_pie_pagina"=> "",
                "mensaje"=> "",
                "numero_gr"=> "",
                "ant_numero"=> "",
                "docurela_numero"=> "",
                "ant_monto"=> "0.00",
                "op_exportacion"=> "0.00",
                "op_exonerada"=> 0.00,
                "op_inafecta"=> 0,
                "op_gravada"=> $comprobante->afecto,
                "tot_valorventa"=> $comprobante->afecto,
                "tot_precioventa"=> $comprobante->total,
                "isc"=> "0.00",
                "igv"=> $comprobante->igv,
                "porc_igv"=> "18.00",
                "igv_gratuita"=> "0.00",
                "importe_total"=> $comprobante->total,
                "total_pagar"=> $comprobante->total,
                "redondeo"=> "0.00",
                "total_otros_tributos"=> "0.00",
                "total_otros_cargos"=> 0,
                "cargodesc_motivo"=> "",
                "cargodesc_base"=> "0.00",
                "porc_dsctoglobal"=> "0.00",
                "total_descuento"=> 0,
                "descto_global"=> "0.00",
                "total_gratuitas"=> 0.00,
                "importe_letras"=> $comprobante->totalLetras,
                "total_icbper"=> "0.00",
                "usuario"=> "luis.quijano@hardnetconsulting.com",
                "tipocambio"=> $comprobante->tipoCambio,
                "codigo_sucu"=> "",
                "detraccion_bs"=> "",
                "detraccion_nrocta"=> "",
                "detraccion_porc"=> "",
                "detraccion_monto"=> "",
                "detraccion_moneda"=> "",
                "detraccion_mediopago"=> "",
                "almacen_id"=> null,
                "icoterms"=> "",
                "glosa_detraccion"=> ""
            ],
            "items" => [
                [
                    "tipodocu" => $comprobante->tipoDocumento,
                    "codigo" => "P00001",
                    "codigo_sunat" => "95101501",
                    "codigo_gs1" => "",
                    "descripcion" => "POR LA COMPRA DE BOLETO AEREO",
                    "cantidad" => "1.0000000000",
                    "unid" => "NIU",
                    "tipoprecioventa" => "01",
                    "tipo_afect_igv" => "10",
                    "codigo_tributo" => "1000",
                    "is_anticipo" => 0,
                    "valorunitbruto" => $comprobante->afecto,
                    "valorunit" => $comprobante->afecto,
                    "valorventabruto" => $comprobante->afecto,
                    "valorventa" => $comprobante->afecto,
                    "preciounitbruto" => $comprobante->total,
                    "preciounit" => $comprobante->total,
                    "precioventa" => $comprobante->total,
                    "precioventabruto" => $comprobante->total,
                    "igv" => $comprobante->igv,
                    "porc_igv" => "18.00",
                    "isc" => "0.00",
                    "porc_isc" => "0.00",
                    "dscto_unit" => "0.00",
                    "porc_dscto_unit" => "0.00",
                    "cod_cargodesc" => "",
                    "base_cargodesc" => "0.00",
                    "otrostributos_porc" => "0.00",
                    "otrostributos_monto" => "0.00",
                    "otrostributos_base" => "0.00",
                    "placavehiculo" => "",
                    "tot_impuesto" => "0.00",
                    "tipo_operacion" => "OP_GRAV",
                    "opt_tipodoi"  => "",
                    "opt_numerodoi"  => "",
                    "opt_pasaportepais"  => "",
                    "opt_huesped"  => "",
                    "opt_huespedpais"  => "",
                    "opt_fingresopais"  => "",
                    "opt_fcheckin"  => "",
                    "opt_fcheckout"  => "",
                    "opt_fconsumo" => "",
                    "opt_diaspermanencia" => "" 
                ]
            ]
        ];
        $funciones = new Funciones();

        $file = $funciones->enviarDC($dataToSend);

        if ($file['type'] == 'success') {
            $doc = Documento::find($comprobante->id);
            $doc->respuestaSunat = $file['type'];
            $doc->save();

        } else {
            session()->flash('error', 'Ocurrió un error enviando a Sunat');
        }
        
    } 
}
