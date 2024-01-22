<?php

namespace App\Exports;

use App\Models\Documento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DocumentoExport implements FromView, WithStyles
{
    public $idCliente, $fechaInicio, $fechaFin, $razonSocial;
    
    public function __construct($id, $fecIni, $fecFin)
    {
        $this->idCliente = $id;
        $this->fechaInicio = $fecIni;
        $this->fechaFin = $fecFin;
    }
    
    public function  view(): View
    {
        return view('exports.gestion.documentos', [
            'documentos' => Documento::where('idCliente', $this->idCliente)
                            ->whereBetween('fechaEmision', [$this->fechaInicio, $this->fechaFin])
                            ->orderBy('fechaEmision', 'asc')
                            ->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar estilos y colores aquí
        
        $sheet->getStyle('B3:H3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => '12',
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
