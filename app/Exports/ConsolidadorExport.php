<?php

namespace App\Exports;

use App\Models\Consolidador;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ConsolidadorExport implements FromView
{
    public function view(): View
    {
        return view('exports.entidades.consolidadors', [
            'consolidadores' => Consolidador::all()
        ]);
    }
}
