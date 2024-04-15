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
    public $fechaInicio, $fechaFin, $vendedor, $tipoComision;

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
        // dd($this->tipoComision);
        if($this->tipoComision == 'BOLETOS'){
            $this->filtrarBoletos();
        }else if($this->tipoComision == 'SERVICIOS'){
            $this->filtrarServicios();
        }else{
            session()->flash('error', 'Seleccione tipo de comisión');
        }
    }
    public function filtrarBoletos(){
        if($this->fechaInicio and $this->fechaFin and $this->vendedor){
            $this->comisiones = DB::table('vista_comision_boletos')
                            ->where('idVendedor',$this->vendedor)
                            ->whereBetween('FechaEmision',[$this->fechaInicio, $this->fechaFin])
                            ->orderby('fechaEmision')
                            ->get();
        }
        if($this->fechaInicio and $this->fechaFin and !$this->vendedor){
            $this->comisiones = DB::table('vista_comision_boletos')
                            ->whereBetween('fechaEmision',[$this->fechaInicio, $this->fechaFin])
                            ->orderBy('fechaEmision')
                            ->get();
        }
    }

    public function filtrarServicios(){
        if($this->fechaInicio and $this->fechaFin and $this->vendedor){
            $this->comisiones = DB::table('vista_comision_servicios')
                            ->where('idVendedor',$this->vendedor)
                            ->whereBetween('FechaEmision',[$this->fechaInicio, $this->fechaFin])
                            ->orderby('fechaEmision')
                            ->get();
        }
        if($this->fechaInicio and $this->fechaFin and !$this->vendedor){
            $this->comisiones = DB::table('vista_comision_servicios')
                            ->whereBetween('fechaEmision',[$this->fechaInicio, $this->fechaFin])
                            ->orderBy('fechaEmision')
                            ->get();
        }
    }

    public function exportar(){
        return Excel::download(new ComisionesExport($this->fechaInicio,$this->fechaFin,$this->vendedor, $this->tipoComision),'Comision.xlsx');
    }
}
