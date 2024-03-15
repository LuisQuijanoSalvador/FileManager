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
    public $idTipoDocumento, $fechaInicio, $fechaFin, $idCliente;
    
    public function __construct($id, $idCliente, $fecIni, $fecFin)
    {
        $this->idTipoDocumento = $id;
        $this->idCliente = $idCliente;
        $this->fechaInicio = $fecIni;
        $this->fechaFin = $fecFin;
    }
    
    public function  view(): View
    {
        if($this->idTipoDocumento and !$this->idCliente){
            return view('exports.gestion.documentos', [
                'documentos' => Documento::where('idTipoDocumento', $this->idTipoDocumento)
                                ->whereBetween('fechaEmision', [$this->fechaInicio, $this->fechaFin])
                                ->orderBy('fechaEmision', 'asc')
                                ->get()
            ]);
        }
        if(!$this->idTipoDocumento and !$this->idCliente){
            return view('exports.gestion.documentos', [
                'documentos' => Documento::whereBetween('fechaEmision', [$this->fechaInicio, $this->fechaFin])
                                ->orderBy('fechaEmision', 'asc')
                                ->get()
            ]);
        }
        if(!$this->idTipoDocumento and $this->idCliente){
            return view('exports.gestion.documentos', [
                'documentos' => Documento::where('idCliente', $this->idCliente)
                                ->whereBetween('fechaEmision', [$this->fechaInicio, $this->fechaFin])
                                ->orderBy('fechaEmision', 'asc')
                                ->get()
            ]);
        }
        if($this->idTipoDocumento and $this->idCliente){
            return view('exports.gestion.documentos', [
                'documentos' => Documento::where('idTipoDocumento', $this->idTipoDocumento)
                                ->where('idCliente', $this->idCliente)
                                ->whereBetween('fechaEmision', [$this->fechaInicio, $this->fechaFin])
                                ->orderBy('fechaEmision', 'asc')
                                ->get()
            ]);
        }
        
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
