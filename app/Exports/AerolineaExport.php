<?php

namespace App\Exports;

use App\Models\Aerolinea;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AerolineaExport implements FromView
{
   
    public function view(): View
    {
        return view('exports.entidades.aerolineas', [
            'aerolineas' => Aerolinea::all()
        ]);
    }
}
