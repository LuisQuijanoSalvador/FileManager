<?php

namespace App\Exports;

use App\Models\TipoPago;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TipoPagoExport implements FromView
{
   
    public function view(): View
    {
        return view('exports.tablas.tipo-pagos', [
            'tipoPagos' => TipoPago::all()
        ]);
    }
}
