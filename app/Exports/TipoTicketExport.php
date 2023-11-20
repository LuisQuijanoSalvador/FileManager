<?php

namespace App\Exports;

use App\Models\TipoTicket;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TipoTicketExport implements FromView
{
   
    public function view(): View
    {
        return view('exports.tablas.tipo-tickets', [
            'tipoTickets' => TipoTicket::all()
        ]);
    }
}
