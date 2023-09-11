<?php

namespace App\Exports;

use App\Models\Area;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AreaExport implements FromView
{
    public function view(): View
    {
        return view('exports.tablas.areas', [
            'areas' => Area::all()
        ]);
    }
}
