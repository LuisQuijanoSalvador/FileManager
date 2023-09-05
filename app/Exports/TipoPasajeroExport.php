<?php

namespace App\Exports;

use App\Models\TipoPasajero;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TipoPasajeroExport implements FromView
{
    
    public function view(): View
    {
        return view('exports.tablas.tipoPasajeros', [
            'tipoPasajeros' => TipoPasajero::all()
        ]);
    }
}
