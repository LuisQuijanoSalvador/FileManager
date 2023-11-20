<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                ID
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Razon Social
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Num. Doc. 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Monto Credito
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Dias Credito
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Estado
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($consolidadors as $consolidador)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$consolidador->id}}</td>
            <td class="py-1">{{$consolidador->razonSocial}}</td>
            <td class="py-1">{{$consolidador->numeroDocumentoIdentidad}}</td>
            <td class="py-1">{{$consolidador->montoCredito}}</td>
            <td class="py-1">{{$consolidador->diasCredito}}</td>
            <td class="py-1">{{$consolidador->tEstado->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>