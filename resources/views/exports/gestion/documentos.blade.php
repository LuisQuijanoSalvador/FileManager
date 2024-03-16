<div>
    <h1>Listado de Documentos</h1>
</div>
<br>
<table>
    <thead>
        <tr>
            <th scope="col" >
                
            </th>
            <th scope="col">
                Tipo 
            </th>
            <th scope="col" >
                Serie 
            </th>
            <th scope="col">
                Numero
            </th>
            
            <th scope="col">
                Cliente
            </th>
            <th scope="col">
                F. Emisión
            </th>
            <th scope="col">
                Boleto
            </th>
            <th scope="col">
                Total
            </th>
            <th scope="col">
                Estado
            </th>
        </tr>
    </thead>
    <tbody>
        @if($documentos)
            @foreach ($documentos as $documento)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">
                    
                </td>
                <td class="py-1">{{$documento->tTipoDocumento->descripcion}}</td>
                <td class="py-1">{{$documento->serie}}</td>
                <td class="py-1">{{$documento->numero}}</td>
                <td class="py-1">{{$documento->tcliente->razonSocial}}</td>
                <td class="py-1">{{\Carbon\Carbon::parse($documento->fechaEmision)->format('d-m-Y')}}</td>
                <td class="py-1">@if($documento->tBoleto){{ $documento->tBoleto->numeroBoleto}} @endif</td>
                <td class="py-1">{{$documento->total}}</td>
                <td class="py-1">{{$documento->tEstado->descripcion}}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>