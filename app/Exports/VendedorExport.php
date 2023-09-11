<?php

namespace App\Exports;

use App\Models\Vendedor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VendedorExport implements FromView
{
    public function view(): View
    {
        return view('exports.entidades.vendedors', [
            'vendedors' => Vendedor::all()
        ]);
    }
}
