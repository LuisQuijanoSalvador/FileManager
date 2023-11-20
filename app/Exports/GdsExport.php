<?php

namespace App\Exports;

use App\Models\Gds;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GdsExport implements FromView
{
   
    public function view(): View
    {
        return view('exports.tablas.gdss', [
            'gdss' => Gds::all()
        ]);
    }
}
