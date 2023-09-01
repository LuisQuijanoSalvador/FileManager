<?php

namespace App\Exports;

use App\Models\TipoCambio;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TipoCambioExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.tablas.tipoCambios', [
            'tipoCambios' => TipoCambio::all()
        ]);
    }
}
