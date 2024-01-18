<table>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"> 
            <h3>LISTADO DE SERVICIOS FACTURADOS</h3>
        </td>
    </tr>
</table>
<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                File
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Cliente
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                F. Emisión
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Servicio
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Pasajero
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Neto 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Inafecto 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                IGV 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Otros Imp. 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Total 
            </th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalNeto = 0;
            $totalInafecto = 0;
            $totalIgv = 0;
            $totalOtrosImpuestos = 0;
            $totalTotal = 0;
        @endphp
        @if($servicios)
            @foreach ($servicios as $servicio)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-1"><input type="checkbox" name="chkSelect" id="" wire:model.lazy.defer="selectedRows" value="{{ $servicio->id }}"></td>
                    <td class="py-1">{{$servicio->numeroFile}}</td>
                    <td class="py-1">{{$servicio->tcliente->razonSocial}}</td>
                    <td class="py-1">{{$servicio->fechaEmision}}</td>
                    <td class="py-1">{{$servicio->tTipoServicio->descripcion}}</td>
                    <td class="py-1">{{$servicio->pasajero}}</td>
                    <td class="py-1">{{$servicio->tarifaNeta}}</td>
                    <td class="py-1">{{$servicio->inafecto}}</td>
                    <td class="py-1">{{$servicio->igv}}</td>
                    <td class="py-1">{{$servicio->otrosImpuestos}}</td>
                    <td class="py-1">{{$servicio->total}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>