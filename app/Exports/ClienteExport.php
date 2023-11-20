<?php

namespace App\Exports;

use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClienteExport implements FromView
{
    public function view(): View
    {
        return view('exports.entidades.clientes', [
            'clientes' => Cliente::all()
        ]);
    }
}
