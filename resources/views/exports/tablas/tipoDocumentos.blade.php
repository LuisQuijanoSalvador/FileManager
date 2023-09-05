
@section('css')
    <link rel="stylesheet" href="/css/estilos.css">
@stop

<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                ID 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Descripcion 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Codigo 
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tipoDocumentos as $tipoDocumento)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$tipoDocumento->id}}</td>
            <td class="py-1">{{$tipoDocumento->descripcion}}</td>
            <td class="py-1">{{$tipoDocumento->codigo}}</td>
        </tr>
        @endforeach
    </tbody>
</table>