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
        @foreach ($tipoPasajeros as $tipoPasajero)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$tipoPasajero->id}}</td>
            <td class="py-1">{{$tipoPasajero->descripcion}}</td>
            <td class="py-1">{{$tipoPasajero->codigo}}</td>
        </tr>
        @endforeach
    </tbody>
</table>