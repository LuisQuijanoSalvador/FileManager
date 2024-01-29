<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MargenesExport;
use Carbon\Carbon;

class Margenes extends Component
{
    protected $margenes;
    public $fechaInicio, $fechaFin;

    public function mount(){
        $fechaActual = Carbon::now();
        
        $this->fechaInicio = Carbon::parse($fechaActual)->format("Y-m-d");
        $this->fechaFin = Carbon::parse($fechaActual)->format("Y-m-d");
    }

    public function render()
    {
        return view('livewire.reportes.margenes');
    }

    public function filtrar(){
        $this->margenes = DB::select('CALL get_xm_fechas(?, ?)', [$this->fechaInicio, $this->fechaFin]);
    }

    public function exportar(){
        return Excel::download(new MargenesExport($this->fechaInicio,$this->fechaFin),'Margenes.xlsx');
    }
}
