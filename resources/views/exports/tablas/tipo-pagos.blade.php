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
                Estado
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tipoPagos as $tipoPago)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$tipoPago->id}}</td>
            <td class="py-1">{{$tipoPago->descripcion}}</td>
            <td class="py-1">{{$tipoPago->tEstado->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>