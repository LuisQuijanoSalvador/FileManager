<?php

namespace App\Exports;

use App\Models\moneda;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MonedaExport implements FromView
{
    public function view(): View
    {
        return view('exports.entidades.monedas', [
            'monedas' => moneda::all()
        ]);
    }
}
