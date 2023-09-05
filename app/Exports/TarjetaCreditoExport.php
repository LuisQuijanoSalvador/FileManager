<?php

namespace App\Exports;

use App\Models\TarjetaCredito;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TarjetaCreditoExport implements FromView
{
    public function view(): View
    {
        return view('exports.tablas.tarjetaCreditos', [
            'tarjetaCreditos' => TarjetaCredito::all()
        ]);
    }
}
