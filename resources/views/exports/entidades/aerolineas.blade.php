<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer" >
                ID 
            </th>
            <th scope="col" class="py-1 cursor-pointer" >
                Razon Social 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
            Siglas
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Código
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Ruc
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Estado 
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($aerolineas as $aerolinea)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$aerolinea->id}}</td>
            <td class="py-1">{{$aerolinea->razonSocial}}</td>
            <td class="py-1">{{$aerolinea->siglaIata}}</td>
            <td class="py-1">{{$aerolinea->codigoIata}}</td>
            <td class="py-1">{{$aerolinea->ruc}}</td>
            <td class="py-1">{{$aerolinea->tEstado->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>