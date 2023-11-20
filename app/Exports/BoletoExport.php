<?php

namespace App\Exports;

use App\Models\Boleto;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BoletoExport implements FromView
{

    public function view(): View
    {
        return view('exports.entidades.boletos', [
            'boletos' => Boleto::all()
        ]);
    }
}
