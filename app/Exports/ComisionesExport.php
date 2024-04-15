<?php

namespace App\Exports;

use App\Models\Ventas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class ComisionesExport implements FromView, WithStyles
{
    public $fechaInicio, $fechaFin, $idVendedor, $tipoComision;

    public function __construct($fecIni, $fecFin, $idVend, $tipo)
    {
        $this->fechaInicio = $fecIni;
        $this->fechaFin = $fecFin;
        $this->idVendedor = $idVend;
        $this->tipoComision = $tipo;

    }
    public function view(): View
    {
        if($this->tipoComision == 'BOLETOS'){
            if($this->fechaInicio and $this->fechaFin and $this->idVendedor){
                return view('exports.reportes.comisiones', [
                    'ventass' => DB::table('vista_comision_boletos')
                    ->where('idVendedor',$this->idVendedor)
                    ->whereBetween('FechaEmision',[$this->fechaInicio, $this->fechaFin])
                    ->orderby('FechaEmision')
                    ->get()
                ]);
            }
            if($this->fechaInicio and $this->fechaFin and !$this->idVendedor){
                return view('exports.reportes.comisiones', [
                    'ventass' => DB::table('vista_comision_boletos')
                    ->whereBetween('FechaEmision',[$this->fechaInicio, $this->fechaFin])
                    ->orderby('FechaEmision')
                    ->get()
                ]);
            }
        }else if($this->tipoComision == 'SERVICIOS'){
            if($this->fechaInicio and $this->fechaFin and $this->idVendedor){
                return view('exports.reportes.comisiones', [
                    'ventass' => DB::table('vista_comision_servicios')
                    ->where('idVendedor',$this->idVendedor)
                    ->whereBetween('FechaEmision',[$this->fechaInicio, $this->fechaFin])
                    ->orderby('FechaEmision')
                    ->get()
                ]);
            }
            if($this->fechaInicio and $this->fechaFin and !$this->idVendedor){
                return view('exports.reportes.comisiones', [
                    'ventass' => DB::table('vista_comision_servicios')
                    ->whereBetween('FechaEmision',[$this->fechaInicio, $this->fechaFin])
                    ->orderby('FechaEmision')
                    ->get()
                ]);
            }
        }else{
            session()->flash('error', 'Seleccione tipo de comisión');
        }
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar estilos y colores aquí
        $sheet->getStyle('A1:AE150')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFFFFF',
                ],
            ],
            'font' => [
                'bold' => true,
                'size' => '9',
                'color' => [
                    'argb' => '000000',
                ],
            ],
        ]);

        
        $sheet->getStyle('A1:R1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => '9',
                'color' => [
                    'argb' => 'FFFFFF',
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '06136e',
                ],
            ],
        ]);
    }
}
