<?php

namespace App\Exports;

use App\Models\Cobrador;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CobradorExport implements FromView
{
    public function view(): View
    {
        return view('exports.entidades.cobradors', [
            'cobradors' => Cobrador::all()
        ]);
    }
}
