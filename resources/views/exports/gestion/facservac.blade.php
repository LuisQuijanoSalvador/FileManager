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
                Servicio
            </th>
            <th scope="col">
                Proveedor
            </th>
            <th scope="col">
                Cliente
            </th>
            <th scope="col">
                Neto 
            </th>
            <th scope="col">
                Inafecto 
            </th>
            <th scope="col">
                IGV 
            </th>
            <th scope="col">
                Otros Imp. 
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
                    <td>{{$servicio->tTipoServicio->descripcion}}</td>
                    <td>@if($servicio->tProveedor){{$servicio->tProveedor->razonSocial}} @else AS TRAVEL PERU SAC @endif</td>
                    <td>{{$servicio->tcliente->razonSocial}}</td>
                    <td>{{$servicio->tarifaNeta}}</td>
                    <td>{{$servicio->inafecto}}</td>
                    <td>{{$servicio->igv}}</td>
                    <td>{{$servicio->otrosImpuestos}}</td>
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
                <td colspan="5"></td>
                <td>Totales: </td>
                <td>{{$totalNeto}}</td>
                <td>{{$totalInafecto}}</td>
                <td>{{$totalIgv}}</td>
                <td>{{$totalOtrosImpuestos}}</td>
                <td>{{$totalTotal}}</td>
            </tr>
        {{-- @endif --}}
    </tbody>
</table>