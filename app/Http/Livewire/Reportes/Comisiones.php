<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComisionesExport;
use Carbon\Carbon;
use App\Models\Vendedor;

class Comisiones extends Component
{
    protected $comisiones;
    public $fechaInicio, $fechaFin;

    public function mount(){
        $fechaActual = Carbon::now();
        
        $this->fechaInicio = Carbon::parse($fechaActual)->format("Y-m-d");
        $this->fechaFin = Carbon::parse($fechaActual)->format("Y-m-d");
    }
    public function render()
    {
        $vendedors = Vendedor::all()->sortBy('nombre');
        return view('livewire.reportes.comisiones',compact('vendedors'));
    }

    public function filtrar(){
        // $this->comisiones = DB::select('CALL get_comision_fechas(?, ?)', [$this->fechaInicio, $this->fechaFin]);
    }

    public function exportar(){
        // return Excel::download(new ComisionesExport($this->fechaInicio,$this->fechaFin),'Comision.xlsx');
    }
}
