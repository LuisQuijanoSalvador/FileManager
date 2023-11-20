<?php

namespace App\Exports;

use App\Models\Solicitante;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SolicitanteExport implements FromView
{
 
    public function view(): View
    {
        return view('exports.entidades.solicitantes', [
            'solicitantes' => Solicitante::all()
        ]);
    }
}
