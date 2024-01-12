<?php

namespace App\Exports;

use App\Models\Aerolinea;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AerolineaExport implements FromView, WithStyles
{
   
    public function view(): View
    {
        return view('exports.entidades.aerolineas', [
            'aerolineas' => Aerolinea::all()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar estilos y colores aquí
        $sheet->getStyle('A1:Z1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFFF00',
                ],
            ],
        ]);
    }
}
