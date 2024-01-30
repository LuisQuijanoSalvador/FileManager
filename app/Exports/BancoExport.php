<?php

namespace App\Exports;

use App\Models\Banco;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BancoExport implements FromView
{
    public function view(): View
    {
        return view('exports.tablas.bancos', [
            'bancos' => Banco::all()
        ]);
    }
}
