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
<table>
    <thead>
        <tr>
            <th scope="col">
                
            </th>
            <th scope="col">
                F. Emisión
            </th>
            <th scope="col">
                Pasajero
            </th>
            <th scope="col">
                TKT
            </th>
            <th scope="col">
                Aerolinea
            </th>
            <th scope="col">
                Ruta
            </th>
            <th scope="col">
                Tipo Ruta
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                C. Costo 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                COD1
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                COD2 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                COD3
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                COD4
            </th>
            <th scope="col">
                Neto 
            </th>
            <th scope="col">
                IGV 
            </th>
            <th scope="col">
                Total 
            </th>
            <th scope="col">
                Solicitante 
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
        {{-- @if($servicios) --}}
            @foreach ($servicios as $servicio)
                <tr>
                    <td></td>
                    <td>{{\Carbon\Carbon::parse($servicio->fechaEmision)->format('d-m-Y')}}</td>
                    <td>{{$servicio->pasajero}}</td>
                    <td>@if($servicio->tBoleto){{$servicio->tBoleto->numeroBoleto}}@else - @endif</td>
                    <td>@if($servicio->tProveedor){{$servicio->tProveedor->razonSocial}} @else AS TRAVEL PERU SAC @endif</td>
                    <td>@if($servicio->tBoleto){{$servicio->tBoleto->ruta}}@else - @endif</td>
                    <td>@if($servicio->tBoleto){{$servicio->tBoleto->tipoRuta}}@else - @endif</td>
                    <td>{{$servicio->centroCosto}}</td>
                    <td>{{$servicio->cod1}}</td>
                    <td>{{$servicio->cod2}}</td>
                    <td>{{$servicio->cod3}}</td>
                    <td>{{$servicio->cod4}}</td>
                    <td>{{$servicio->tarifaNeta}}</td>
                    <td>{{$servicio->igv}}</td>
                    <td>{{$servicio->total}}</td>
                    <td>@if($servicio->tSolicitante){{$servicio->tSolicitante->nombres}}@else -- @endif</td>
                </tr>
                {{$totalTotal += $servicio->total}}
                {{$totalInafecto += $servicio->inafecto}}
                {{$totalIgv += $servicio->igv}}
                {{$totalOtrosImpuestos += $servicio->otrosImpuestos}}
                {{$totalNeto += $servicio->tarifaNeta}}
            @endforeach
            <tr>
                <td colspan="6"></td>
                <td>Totales: </td>
                <td>{{$totalNeto}}</td>
                <td>{{$totalIgv}}</td>
                <td>{{$totalTotal}}</td>
            </tr>
        {{-- @endif --}}
    </tbody>
</table>