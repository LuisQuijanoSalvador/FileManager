<?php

namespace App\Exports;

use App\Models\Counter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CounterExport implements FromView
{
    public function view(): View
    {
        return view('exports.entidades.counters', [
            'counters' => Counter::all()
        ]);
    }
}
