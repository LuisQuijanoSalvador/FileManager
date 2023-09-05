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
        @foreach ($medioPagos as $medioPago)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$medioPago->id}}</td>
            <td class="py-1">{{$medioPago->descripcion}}</td>
            <td class="py-1">{{$medioPago->codigo}}</td>
        </tr>
        @endforeach
    </tbody>
</table>