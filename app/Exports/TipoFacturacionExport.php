<?php

namespace App\Exports;

use App\Models\TipoFacturacion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TipoFacturacionExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.tablas.tipoFacturacions', [
            'tipoFacturacions' => TipoFacturacion::all()
        ]);
    }
}
