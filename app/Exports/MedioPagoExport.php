<?php

namespace App\Exports;

use App\Models\MedioPago;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MedioPagoExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function  view(): View
    {
        return view('exports.tablas.medioPagos', [
            'medioPagos' => MedioPago::all()
        ]);
    }
}
