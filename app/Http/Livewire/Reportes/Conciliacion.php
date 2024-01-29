<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConciliacionExport;
use Carbon\Carbon;


class Conciliacion extends Component
{
    protected $ventas;
    public $fechaInicio, $fechaFin;

    public function mount(){
        $fechaActual = Carbon::now();
        
        $this->fechaInicio = Carbon::parse($fechaActual)->format("Y-m-d");
        $this->fechaFin = Carbon::parse($fechaActual)->format("Y-m-d");
    }

    public function render()
    {
        return view('livewire.reportes.conciliacion');
    }

    public function filtrar(){
        $this->ventas = DB::select('CALL get_conciliacion_fechas(?, ?)', [$this->fechaInicio, $this->fechaFin]);
    }

    public function exportar(){
        return Excel::download(new ConciliacionExport($this->fechaInicio,$this->fechaFin),'Conciliacion.xlsx');
    }
}
