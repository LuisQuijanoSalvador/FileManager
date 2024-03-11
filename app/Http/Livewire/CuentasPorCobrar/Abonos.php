<?php

namespace App\Http\Livewire\CuentasPorCobrar;

use Livewire\Component;
use App\Models\Abono;
use App\Models\MedioPago;
use App\Models\Banco;
use App\Models\Cargo;
use App\Models\Documento;
use Illuminate\Support\Facades\DB;
use App\Exports\AbonoExport;
use Maatwebsite\Excel\Facades\Excel;

class Abonos extends Component
{
    public $abonos,$fechaInicio,$fechaFin;
    public function mount(){
        $this->abonos = Abono::select('abonos.fechaAbono as FechaAbono', 'abonos.monto as Monto', 
        DB::raw("CONCAT(documentos.tipoDocumento, ' ', documentos.serie, '-', LPAD(documentos.numero, 8, '0')) as Documento"),
        'documentos.razonSocial as Cliente', 'medio_pagos.descripcion as MedioPago', 
        'abonos.referencia as Referencia', 'bancos.nombre as Banco', 'abonos.numeroCuenta', 'abonos.observaciones')
        ->join('medio_pagos', 'abonos.idMedioPago', '=', 'medio_pagos.id')
        ->join('bancos', 'abonos.idBanco', '=', 'bancos.id')
        ->join('cargos', 'abonos.idCargo', '=', 'cargos.id')
        ->join('documentos', 'cargos.idDocumento', '=', 'documentos.id')
        ->where('abonos.idEstado', 1)
        ->orderBy('abonos.fechaAbono')
        ->get();
    }
    public function render()
    {
        return view('livewire.cuentas-por-cobrar.abonos');
    }
    
    public function filtrar(){
        
        if(!$this->fechaInicio or !$this->fechaFin){
            session()->flash('error', 'Fechas no validas');
            return;
        }
        $this->abonos = Abono::select('abonos.fechaAbono as FechaAbono', 'abonos.monto as Monto', 
        DB::raw("CONCAT(documentos.tipoDocumento, ' ', documentos.serie, '-', LPAD(documentos.numero, 8, '0')) as Documento"),
        'documentos.razonSocial as Cliente', 'medio_pagos.descripcion as MedioPago', 
        'abonos.referencia as Referencia', 'bancos.nombre as Banco', 'abonos.numeroCuenta', 'abonos.observaciones')
        ->join('medio_pagos', 'abonos.idMedioPago', '=', 'medio_pagos.id')
        ->join('bancos', 'abonos.idBanco', '=', 'bancos.id')
        ->join('cargos', 'abonos.idCargo', '=', 'cargos.id')
        ->join('documentos', 'cargos.idDocumento', '=', 'documentos.id')
        ->where('abonos.idEstado', 1)
        ->whereBetween('abonos.fechaAbono', [$this->fechaInicio, $this->fechaFin])
        ->orderBy('abonos.fechaAbono')
        ->get();
    }

    public function exportar(){
        if(!$this->fechaInicio or !$this->fechaFin){
            session()->flash('error', 'Fechas no validas');
            return;
        }
        return Excel::download(new AbonoExport($this->fechaInicio,$this->fechaFin),'Abonos.xlsx');
    }
}
