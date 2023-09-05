<?php

namespace App\Exports;

use App\Models\TipoDocumento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TipoDocumentoExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.tablas.tipoDocumentos', [
            'tipoDocumentos' => TipoDocumento::all()
        ]);
    }
}
