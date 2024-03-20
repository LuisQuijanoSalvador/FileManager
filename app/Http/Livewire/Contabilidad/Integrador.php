<?php

namespace App\Http\Livewire\Contabilidad;

use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Documento;
use App\Models\Boleto;
use App\Models\Servicio;
use App\Models\Proveedor;
use App\Models\Cliente;
use App\Models\Abono;
use Illuminate\Support\Facades\DB;

class Integrador extends Component
{
    public $fechaIni, $fechaFin, $tipoDocumento, $correlativo, $subdiario;
    public function render()
    {
        return view('livewire.contabilidad.integrador');
    }

    public function generarArchivo(){
        if(!$this->tipoDocumento){
            session()->flash('error', 'Seleccione un tipo de documento');
            return;
        }
        if(!$this->correlativo){
            session()->flash('error', 'Debe ingresar el correlativo.');
            return;
        }
        if(!$this->fechaIni){
            session()->flash('error', 'Verifique las Fechas.');
            return;
        }
        if(!$this->fechaFin){
            session()->flash('error', 'Verifique las Fechas.');
            return;
        }

        if($this->tipoDocumento == '01' or $this->tipoDocumento == '03' or $this->tipoDocumento == '07' or $this->tipoDocumento == '08'){
            $this->subdiario = '05';
        }elseif($this->tipoDocumento == '36'){
            $this->subdiario = '04';
        }elseif($this->tipoDocumento == '21'){
            $this->subdiario = '21';
        }
        if($this->tipoDocumento == '21'){
            // // Cargar la plantilla de Excel
            // $plantilla = IOFactory::load(public_path('plantilla.xlsx'));

            // // Obtener la hoja activa
            // $hoja = $plantilla->getActiveSheet();

            // $abonos = Abono::select('fechaAbono',
            //             \DB::raw("CASE abonos.moneda WHEN 1 THEN 'US' ELSE 'MN' END AS Moneda"),
            //             'monto',
            //             'd.serie',
            //             'd.numero',
            //             \DB::raw("CASE d.tipoDocumento WHEN '36' THEN 'DC' WHEN '01' THEN 'FT' WHEN '03' THEN 'BV' END AS tipoDocumento"),
            //             'b.nombre AS banco',
            //             \DB::raw("IFNULL(b.cuentaContableDolares, b.cuentaContableSoles) AS cuentaContable"),
            //             'd.numeroDocumentoIdentidad',
            //             'mp.descripcion AS medioPago',
            //             'abonos.id AS numeroAbono')
            //     ->join('cargos as c', 'abonos.idCargo', '=', 'c.id')
            //     ->join('documentos as d', 'c.idDocumento', '=', 'd.id')
            //     ->join('monedas as m', 'abonos.moneda', '=', 'm.id')
            //     ->join('bancos as b', 'abonos.idBanco', '=', 'b.id')
            //     ->join('medio_pagos as mp', 'abonos.idMedioPago', '=', 'mp.id')
            //     ->get();
            
            // $fila = 5;
            // foreach($abonos as $abono){
            //     $fechaEntero = strtotime($abono->fechaAbono);
            //     $mes = date('m',$fechaEntero);
            //     $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
            //     $hoja->setCellValue('A' . $fila, '');
            //     $hoja->setCellValue('B' . $fila, $this->subdiario);
            //     $hoja->setCellValue('C' . $fila, $numComprobante);
            //     $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($abono->fechaAbono)));
            //     $hoja->setCellValue('E' . $fila, $abono->moneda);
            //     $hoja->setCellValue('F' . $fila, 'COBRANZAS '. $abono->serie . str_pad($abono->numero, 6, "0", STR_PAD_LEFT));
            //     $hoja->setCellValue('G' . $fila, 0);
            //     $hoja->setCellValue('H' . $fila, 'M');
            //     $hoja->setCellValue('I' . $fila, 'S');
            //     $hoja->setCellValue('J' . $fila, '');
            //     $hoja->setCellValue('K' . $fila, $abono->cuentaContable);
            //     $hoja->setCellValue('L' . $fila, $docCli);
            //     $hoja->setCellValue('M' . $fila, '100');
            //     $hoja->setCellValue('N' . $fila, 'H');
            //     $hoja->setCellValue('O' . $fila, $documento->afecto);
            //     $hoja->setCellValue('P' . $fila, 0);
            //     $hoja->setCellValue('Q' . $fila, 0);
            //     $hoja->setCellValue('R' . $fila, 'FT');
            //     $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
            //     $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
            //     $hoja->setCellValue('U' . $fila, '');
            //     $hoja->setCellValue('V' . $fila, '');
            //     $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
            // }

            // // Guardar el archivo
            // $writer = IOFactory::createWriter($plantilla, 'Xlsx');
            // $writer->save(storage_path('app/archivo_generado.xlsx'));

            // // Descargar el archivo
            // return response()->download(storage_path('app/archivo_generado.xlsx'))->deleteFileAfterSend(true);
        }else{
            // Cargar la plantilla de Excel
            $plantilla = IOFactory::load(public_path('plantilla.xlsx'));

            // Obtener la hoja activa
            $hoja = $plantilla->getActiveSheet();

            $documentos = Documento::select('fechaEmision')
            ->selectRaw("CASE moneda WHEN 'USD' THEN 'US' ELSE 'MN' END AS moneda")
            ->selectRaw("CASE tipoDocumento
                WHEN '01' THEN CONCAT(LEFT(razonSocial, 22), '-FT-', RTRIM(serie), '-', RIGHT(numero, 6))
                WHEN '03' THEN CONCAT(LEFT(razonSocial, 22), '-VB-', RTRIM(serie), '-', RIGHT(numero, 6))
                WHEN '07' THEN CONCAT(LEFT(razonSocial, 22), '-NA-', RTRIM(serie), '-', RIGHT(numero, 6))
                WHEN '08' THEN CONCAT(LEFT(razonSocial, 22), '-ND-', RTRIM(serie), '-', RIGHT(numero, 6))
                WHEN '36' THEN CONCAT('DC ', RTRIM(serie), '-', RIGHT(numero, 6), ' ', LEFT(razonSocial, 22))
            END AS glosa")
            // ->addSelect(0, 'tipoCambio', '', 'TipoConversion', 'S', '', 'FechaTipoCambio')
            ->addSelect(DB::raw("IFNULL((SELECT ts.CuentaContableDolares FROM servicios AS s
                INNER JOIN tipo_servicios AS ts ON s.idTipoServicio = ts.id
                WHERE s.IdDocumento = documentos.id LIMIT 1), '') AS CuentaContable"))
            ->addSelect(DB::raw("CASE tipoDocumento
                WHEN '36' THEN IFNULL((SELECT p.numeroDocumentoIdentidad FROM boletos AS b
                    INNER JOIN proveedors AS p ON b.idConsolidador = p.id
                    WHERE b.IdDocumento = documentos.id LIMIT 1), '')
                ELSE numeroDocumentoIdentidad
            END AS CodigoAnexo"))
            ->addSelect('afecto', 'igv', 'otrosImpuestos', 'inafecto', 'exonerado', 'total','numero', 'serie','id')
            ->addSelect(DB::raw("CONCAT(serie, '-', numero) AS numeroDocumento"), 'fechaVencimiento', 'idEstado')
            ->whereBetween('FechaEmision', [$this->fechaIni, $this->fechaFin])
            ->where('TipoDocumento', $this->tipoDocumento)
            ->orderBy('fechaEmision')
            // ->get();
            ->getQuery();
            dd($documentos->toSql());

            $fila = 5;
            if($this->tipoDocumento == '01'){
                foreach($documentos as $documento){
                    
                    $docCli = '';
                    $servicio = Servicio::where('idDocumento',$documento->id)->first();
                    
                    if(!is_null($servicio)){
                        $cliente = Cliente::find($servicio->idCliente);
                        $docCli = $cliente->numeroDocumentoIdentidad;
                    }else{
                        $docCli = '';
                    }
                    if($documento->idEstado == 1){
                        if($documento->afecto > 0){
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, $documento->CuentaContable);
                            $hoja->setCellValue('L' . $fila, $docCli);
                            $hoja->setCellValue('M' . $fila, '100');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->afecto);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'FT');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        if($documento->otrosImpuestos > 0){
                            $fila = $fila + 1;
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, $documento->CuentaContable);
                            $hoja->setCellValue('L' . $fila, $docCli);
                            $hoja->setCellValue('M' . $fila, '100');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->otrosImpuestos);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'FT');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        if($documento->inafecto > 0){
                            $fila = $fila + 1;
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, $documento->CuentaContable);
                            $hoja->setCellValue('L' . $fila, $docCli);
                            $hoja->setCellValue('M' . $fila, '100');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->inafecto);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'FT');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        if($documento->exonerado > 0){
                            $fila = $fila + 1;
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, $documento->CuentaContable);
                            $hoja->setCellValue('L' . $fila, $docCli);
                            $hoja->setCellValue('M' . $fila, '100');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->exonerado);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'FT');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        if($documento->igv > 0){
                            $fila = $fila + 1;
                            // dd($fila);
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, '401111');
                            $hoja->setCellValue('L' . $fila, '');
                            $hoja->setCellValue('M' . $fila, '0');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->igv);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'FT');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        $fila = $fila + 1;
                        $fechaEntero = strtotime($documento->fechaEmision);
                        $mes = date('m',$fechaEntero);
                        $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                        $hoja->setCellValue('A' . $fila, '');
                        $hoja->setCellValue('B' . $fila, $this->subdiario);
                        $hoja->setCellValue('C' . $fila, $numComprobante);
                        $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('E' . $fila, $documento->moneda);
                        $hoja->setCellValue('F' . $fila, $documento->glosa);
                        $hoja->setCellValue('G' . $fila, 0);
                        $hoja->setCellValue('H' . $fila, 'V');
                        $hoja->setCellValue('I' . $fila, 'S');
                        $hoja->setCellValue('J' . $fila, '');
                        if($documento->moneda == 'US'){
                            $hoja->setCellValue('K' . $fila, '121202');
                        }else{
                            $hoja->setCellValue('K' . $fila, '121201');
                        }
                        $hoja->setCellValue('L' . $fila, $docCli);
                        $hoja->setCellValue('M' . $fila, '0');
                        $hoja->setCellValue('N' . $fila, 'D');
                        $hoja->setCellValue('O' . $fila, $documento->total);
                        $hoja->setCellValue('P' . $fila, 0);
                        $hoja->setCellValue('Q' . $fila, 0);
                        $hoja->setCellValue('R' . $fila, 'FT');
                        $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                        $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('U' . $fila, date('d/m/Y', strtotime($documento->fechaVencimiento)));
                        $hoja->setCellValue('V' . $fila, '');
                        $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        
                        // $fila++;
                        // $this->correlativo = $this->correlativo +1;
                    }else{
                        // $fila = $fila + 1;
                        // $this->correlativo = $this->correlativo +1;
                        $fechaEntero = strtotime($documento->fechaEmision);
                        $mes = date('m',$fechaEntero);
                        $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                        $hoja->setCellValue('A' . $fila, '');
                        $hoja->setCellValue('B' . $fila, $this->subdiario);
                        $hoja->setCellValue('C' . $fila, $numComprobante);
                        $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('E' . $fila, $documento->moneda);
                        $hoja->setCellValue('F' . $fila, 'ANULADA FT-'.$documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                        $hoja->setCellValue('G' . $fila, 0);
                        $hoja->setCellValue('H' . $fila, 'V');
                        $hoja->setCellValue('I' . $fila, 'S');
                        $hoja->setCellValue('J' . $fila, '');
                        $hoja->setCellValue('K' . $fila, '121202');
                        $hoja->setCellValue('L' . $fila, '0001');
                        $hoja->setCellValue('M' . $fila, '0');
                        $hoja->setCellValue('N' . $fila, 'D');
                        $hoja->setCellValue('O' . $fila, 0);
                        $hoja->setCellValue('P' . $fila, 0);
                        $hoja->setCellValue('Q' . $fila, 0);
                        $hoja->setCellValue('R' . $fila, 'FT');
                        $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                        $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('U' . $fila, date('d/m/Y', strtotime($documento->fechaVencimiento)));
                        $hoja->setCellValue('V' . $fila, '');
                        $hoja->setCellValue('W' . $fila, substr('ANULADA FT-'.$documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT),0,30));
                    }
                    $fila++;
                    $this->correlativo = $this->correlativo +1;

                }
            }

            if($this->tipoDocumento == '03'){
                foreach($documentos as $documento){
                    $docCli = '';
                    $servicio = Servicio::where('idDocumento',$documento->id)->first();
                    
                    if(!is_null($servicio)){
                        $cliente = Cliente::find($servicio->idCliente);
                        $docCli = $cliente->numeroDocumentoIdentidad;
                    }else{
                        $docCli = '';
                    }
                    if($documento->idEstado == 1){
                        if($documento->afecto > 0){
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, $documento->CuentaContable);
                            $hoja->setCellValue('L' . $fila, $docCli);
                            $hoja->setCellValue('M' . $fila, '100');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->afecto);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'BV');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        if($documento->otrosImpuestos > 0){
                            $fila = $fila + 1;
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, $documento->CuentaContable);
                            $hoja->setCellValue('L' . $fila, $docCli);
                            $hoja->setCellValue('M' . $fila, '100');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->otrosImpuestos);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'BV');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        if($documento->inafecto > 0){
                            $fila = $fila + 1;
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, $documento->CuentaContable);
                            $hoja->setCellValue('L' . $fila, $docCli);
                            $hoja->setCellValue('M' . $fila, '100');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->inafecto);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'BV');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        if($documento->exonerado > 0){
                            $fila = $fila + 1;
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, $documento->CuentaContable);
                            $hoja->setCellValue('L' . $fila, $docCli);
                            $hoja->setCellValue('M' . $fila, '100');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->exonerado);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'BV');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        if($documento->igv > 0){
                            $fila = $fila + 1;
                            // dd($fila);
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            $hoja->setCellValue('K' . $fila, '401111');
                            $hoja->setCellValue('L' . $fila, '');
                            $hoja->setCellValue('M' . $fila, '0');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->igv);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'BV');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, '');
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                        }
                        $fila = $fila + 1;
                        $fechaEntero = strtotime($documento->fechaEmision);
                        $mes = date('m',$fechaEntero);
                        $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                        $hoja->setCellValue('A' . $fila, '');
                        $hoja->setCellValue('B' . $fila, $this->subdiario);
                        $hoja->setCellValue('C' . $fila, $numComprobante);
                        $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('E' . $fila, $documento->moneda);
                        $hoja->setCellValue('F' . $fila, $documento->glosa);
                        $hoja->setCellValue('G' . $fila, 0);
                        $hoja->setCellValue('H' . $fila, 'V');
                        $hoja->setCellValue('I' . $fila, 'S');
                        $hoja->setCellValue('J' . $fila, '');
                        if($documento->moneda == 'US'){
                            $hoja->setCellValue('K' . $fila, '121202');
                        }else{
                            $hoja->setCellValue('K' . $fila, '121201');
                        }
                        $hoja->setCellValue('L' . $fila, $docCli);
                        $hoja->setCellValue('M' . $fila, '0');
                        $hoja->setCellValue('N' . $fila, 'D');
                        $hoja->setCellValue('O' . $fila, $documento->total);
                        $hoja->setCellValue('P' . $fila, 0);
                        $hoja->setCellValue('Q' . $fila, 0);
                        $hoja->setCellValue('R' . $fila, 'BV');
                        $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                        $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('U' . $fila, date('d/m/Y', strtotime($documento->fechaVencimiento)));
                        $hoja->setCellValue('V' . $fila, '');
                        $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                    }else{
                        // $fila = $fila + 1;
                        // $this->correlativo = $this->correlativo +1;
                        $fechaEntero = strtotime($documento->fechaEmision);
                        $mes = date('m',$fechaEntero);
                        $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                        $hoja->setCellValue('A' . $fila, '');
                        $hoja->setCellValue('B' . $fila, $this->subdiario);
                        $hoja->setCellValue('C' . $fila, $numComprobante);
                        $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('E' . $fila, $documento->moneda);
                        $hoja->setCellValue('F' . $fila, 'ANULADA BV-'.$documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                        $hoja->setCellValue('G' . $fila, 0);
                        $hoja->setCellValue('H' . $fila, 'V');
                        $hoja->setCellValue('I' . $fila, 'S');
                        $hoja->setCellValue('J' . $fila, '');
                        $hoja->setCellValue('K' . $fila, '121202');
                        $hoja->setCellValue('L' . $fila, '0001');
                        $hoja->setCellValue('M' . $fila, '0');
                        $hoja->setCellValue('N' . $fila, 'D');
                        $hoja->setCellValue('O' . $fila, 0);
                        $hoja->setCellValue('P' . $fila, 0);
                        $hoja->setCellValue('Q' . $fila, 0);
                        $hoja->setCellValue('R' . $fila, 'BV');
                        $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                        $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('U' . $fila, date('d/m/Y', strtotime($documento->fechaVencimiento)));
                        $hoja->setCellValue('V' . $fila, '');
                        $hoja->setCellValue('W' . $fila, substr('ANULADA BV-'.$documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT),0,30));
                    }
                    $fila++;
                    $this->correlativo = $this->correlativo +1;
                }
            }

            if($this->tipoDocumento == '36'){
                foreach($documentos as $documento){
                    $docCons = '';
                    $docCli = '';
                    $boleto = Boleto::where('idDocumento',$documento->id)->first();
                    // dd($boleto);
                    if(!is_null($boleto)){
                        $proovedor = Proveedor::find($boleto->idConsolidador);
                        if(!is_null($proovedor)){
                            $docCons = $proovedor->numeroDocumentoIdentidad;
                        }else{
                            $docCons = '';
                        }
                    }else{
                        $docCons = '';
                    }
                    if(!is_null($boleto)){
                        $cliente = Cliente::find($boleto->idCliente);
                        $docCli = $cliente->numeroDocumentoIdentidad;
                    }else{
                        $docCli = '';
                    }
                    
                    
                    if($documento->idEstado == 1){
                        $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            if($documento->moneda == 'US'){
                                $hoja->setCellValue('K' . $fila, '168321');
                            }else{
                                $hoja->setCellValue('K' . $fila, '168311');
                            }
                            $hoja->setCellValue('L' . $fila, $cliente->numeroDocumentoIdentidad);
                            $hoja->setCellValue('M' . $fila, '0');
                            $hoja->setCellValue('N' . $fila, 'D');
                            $hoja->setCellValue('O' . $fila, $documento->total);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'DC');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, date('d/m/Y', strtotime($documento->fechaVencimiento)));
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
        
                            $fila = $fila + 1;
        
                            $fechaEntero = strtotime($documento->fechaEmision);
                            $mes = date('m',$fechaEntero);
                            $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                            $hoja->setCellValue('A' . $fila, '');
                            $hoja->setCellValue('B' . $fila, $this->subdiario);
                            $hoja->setCellValue('C' . $fila, $numComprobante);
                            $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('E' . $fila, $documento->moneda);
                            $hoja->setCellValue('F' . $fila, $documento->glosa);
                            $hoja->setCellValue('G' . $fila, 0);
                            $hoja->setCellValue('H' . $fila, 'V');
                            $hoja->setCellValue('I' . $fila, 'S');
                            $hoja->setCellValue('J' . $fila, '');
                            if($documento->moneda == 'US'){
                                $hoja->setCellValue('K' . $fila, '469912');
                            }else{
                                $hoja->setCellValue('K' . $fila, '469911');
                            }
                            $hoja->setCellValue('L' . $fila, $docCons);
                            $hoja->setCellValue('M' . $fila, '0');
                            $hoja->setCellValue('N' . $fila, 'H');
                            $hoja->setCellValue('O' . $fila, $documento->total);
                            $hoja->setCellValue('P' . $fila, 0);
                            $hoja->setCellValue('Q' . $fila, 0);
                            $hoja->setCellValue('R' . $fila, 'DC');
                            $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                            $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                            $hoja->setCellValue('U' . $fila, date('d/m/Y', strtotime($documento->fechaVencimiento)));
                            $hoja->setCellValue('V' . $fila, '');
                            $hoja->setCellValue('W' . $fila, substr($documento->glosa,0,30));
                    }
                    else{
                        // $fila = $fila + 1;
                        // $this->correlativo = $this->correlativo +1;
                        $fechaEntero = strtotime($documento->fechaEmision);
                        $mes = date('m',$fechaEntero);
                        $numComprobante = $mes . str_pad($this->correlativo, 4, "0", STR_PAD_LEFT);
                        $hoja->setCellValue('A' . $fila, '');
                        $hoja->setCellValue('B' . $fila, $this->subdiario);
                        $hoja->setCellValue('C' . $fila, $numComprobante);
                        $hoja->setCellValue('D' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('E' . $fila, $documento->moneda);
                        $hoja->setCellValue('F' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT).' ****ANULADO****');
                        $hoja->setCellValue('G' . $fila, 0);
                        $hoja->setCellValue('H' . $fila, 'V');
                        $hoja->setCellValue('I' . $fila, 'S');
                        $hoja->setCellValue('J' . $fila, '');
                        $hoja->setCellValue('K' . $fila, '121202');
                        $hoja->setCellValue('L' . $fila, '0001');
                        $hoja->setCellValue('M' . $fila, '0');
                        $hoja->setCellValue('N' . $fila, 'D');
                        $hoja->setCellValue('O' . $fila, 0);
                        $hoja->setCellValue('P' . $fila, 0);
                        $hoja->setCellValue('Q' . $fila, 0);
                        $hoja->setCellValue('R' . $fila, 'FT');
                        $hoja->setCellValue('S' . $fila, $documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT));
                        $hoja->setCellValue('T' . $fila, date('d/m/Y', strtotime($documento->fechaEmision)));
                        $hoja->setCellValue('U' . $fila, date('d/m/Y', strtotime($documento->fechaVencimiento)));
                        $hoja->setCellValue('V' . $fila, '');
                        $hoja->setCellValue('W' . $fila, substr($documento->serie . '-' . str_pad($documento->numero, 6, "0", STR_PAD_LEFT),0,30).' ****ANULADO****');
                    }
                    $fila++;
                    $this->correlativo = $this->correlativo +1;
                }
                
            }
            
            // Guardar el archivo
            $writer = IOFactory::createWriter($plantilla, 'Xlsx');
            $writer->save(storage_path('app/archivo_generado.xlsx'));

            // Descargar el archivo
            return response()->download(storage_path('app/archivo_generado.xlsx'))->deleteFileAfterSend(true);
        }
    }
}
