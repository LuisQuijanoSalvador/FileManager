<?php

namespace App\Exports;

use App\Models\Abono;
use App\Models\MedioPago;
use App\Models\Banco;
use App\Models\Cargo;
use App\Models\Documento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class AbonoExport implements  FromView, WithStyles
{
    public $fechaInicio, $fechaFin;

    public function __construct($fecIni, $fecFin)
    {
        $this->fechaInicio = $fecIni;
        $this->fechaFin = $fecFin;

        
    }
    public function  view(): View
    {
        return view('exports.ctasCobrar.abonos', [
            'abonos' => Abono::select('abonos.fechaAbono as FechaAbono', 'abonos.monto as Monto', 
                    DB::raw("CONCAT(documentos.tipoDocumento, ' ', documentos.serie, '-', LPAD(documentos.numero, 8, '0')) as Documento"),
                    'documentos.razonSocial as Cliente', 'medio_pagos.descripcion as MedioPago', 
                    'abonos.referencia as Referencia', 'bancos.nombre as Banco', 'abonos.numeroCuenta', 'abonos.observaciones')
                    ->join('medio_pagos', 'abonos.idMedioPago', '=', 'medio_pagos.id')
                    ->join('bancos', 'abonos.idBanco', '=', 'bancos.id')
                    ->join('cargos', 'abonos.idCargo', '=', 'cargos.id')
                    ->join('documentos', 'cargos.idDocumento', '=', 'documentos.id')
                    ->where('abonos.idEstado', 1)
                    ->whereBetween('abonos.fechaAbono', [$this->fechaInicio, $this->fechaFin])
                    ->orderBy('abonos.fechaAbono')
                    ->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar estilos y colores aquí
        $sheet->getStyle('A1:I1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '06136e',
                ],
            ],
            'font' => [
                'bold' => true,
                'size' => '10',
                'color' => [
                    'argb' => 'FFFFFF',
                ],
            ],
        ]);

    }
}
