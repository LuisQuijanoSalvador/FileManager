<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                ID 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Descripcion 
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tipoFacturacions as $tipoFacturacion)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$tipoFacturacion->id}}</td>
            <td class="py-1">{{$tipoFacturacion->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>