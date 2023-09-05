<?php

namespace App\Exports;

use App\Models\TipoServicio;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TipoServicioExport implements FromView
{
    
    public function view(): View
    {
        return view('exports.tablas.tipoServicios', [
            'tipoServicios' => TipoServicio::all()
        ]);
    }
}
