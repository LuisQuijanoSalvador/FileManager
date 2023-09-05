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
        @foreach ($tipoServicios as $tipoServicio)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$tipoServicio->id}}</td>
            <td class="py-1">{{$tipoServicio->descripcion}}</td>
            <td class="py-1">{{$tipoServicio->codigo}}</td>
        </tr>
        @endforeach
    </tbody>
</table>