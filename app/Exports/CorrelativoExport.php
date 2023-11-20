<?php

namespace App\Exports;

use App\Models\Correlativo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CorrelativoExport implements FromView
{
   
    public function view(): View
    {
        return view('exports.tablas.correlativos', [
            'correlativos' => Correlativo::all()
        ]);
    }
}
