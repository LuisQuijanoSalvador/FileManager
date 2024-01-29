<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="row">
        <div class="col-md-3">
            <select name="vendedor" class="form-select" id="cboVendedor" wire:model.lazy="vendedor">
                <option>==Seleccione un Vendedor==</option>
                @foreach ($vendedors as $vendedor)
                    <option value={{$vendedor->id}}>{{$vendedor->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <p style="text-align:right">F. inicio:</p>
        </div>
        <div class="col-md-2">
            <input type="date" wire:model.lazy.defer="fechaInicio" id="fechaInicio">
        </div>
        <div class="col-md-1">
            <p style="text-align:right">F. Final:</p>
        </div>
        <div class="col-md-2">
            <input type="date" wire:model.lazy.defer="fechaFin" id="fechaFin">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-primary" wire:click="filtrar" >Filtrar</button>
        </div>
    </div>
    <hr>
    <button @if(!$this->comisiones) disabled @elseif(count($this->comisiones) == 0) disabled @endif type="button" class="btn btn-success rounded" wire:click='exportar'>Exportar</button>
    <div class="contenedorTablaReport">
        <table class="tabla-listado">
            <thead class="thead-listadoCC">
                <tr>
                    <th scope="col" class="py-1">
                        F. EMISION
                    </th>
                    <th scope="col" class="py-1">
                        PROVEEDOR
                    </th>
                    <th scope="col" class="py-1">
                        NUM. BOLETO
                    </th>
                    <th scope="col" class="py-1">
                        CLIENTE
                    </th>
                    <th scope="col" class="py-1">
                        PASAJERO
                    </th>
                    <th scope="col" class="py-1">
                        TIPO RUTA
                    </th>
                    <th scope="col" class="py-1">
                        RUTA
                    </th>
                    <th scope="col" class="py-1">
                        MONEDA
                    </th>
                    <th scope="col" class="py-1">
                        TARIFA
                    </th>
                    <th scope="col" class="py-1">
                        MONTO COMISION
                    </th>
                    <th scope="col" class="py-1">
                        % COMISION
                    </th>
                    <th scope="col" class="py-1">
                        OVER
                    </th>
                    <th scope="col" class="py-1">
                        OVER_
                    </th>
                    <th scope="col" class="py-1">
                        % OVER
                    </th>
                    <th scope="col" class="py-1">
                        NUM. DOCUMENTO
                    </th>
                    <th scope="col" class="py-1">
                        TOTAL
                    </th>
                    <th scope="col" class="py-1">
                        FORMA PAGO
                    </th>
                    <th scope="col" class="py-1">
                        COM. VENDEDOR
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($this->comisiones)
                    @foreach ($this->comisiones as $margen)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-1">{{$margen->Origen}}</td>
                            <td class="py-1">{{$margen->Tipo}}</td>
                            <td class="py-1">{{$margen->NumeroBoleto}}</td>
                            <td class="py-1">{{$margen->FILE}}</td>
                            <td class="py-1">{{$margen->Cliente}}</td>
                            <td class="py-1">{{$margen->Counter}}</td>
                            <td class="py-1">{{$margen->FechaEmision}}</td>
                            <td class="py-1">{{$margen->Ruta}}</td>
                            <td class="py-1">{{$margen->XM}}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
