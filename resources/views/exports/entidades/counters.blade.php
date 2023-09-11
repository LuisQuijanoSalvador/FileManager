<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                ID 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Nombre 
            </th>
            <th scope="col" class="py-1 cursor-pointer" >
                Codigo 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Estado 
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($counters as $counter)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$counter->id}}</td>
            <td class="py-1">{{$counter->nombre}}</td>
            <td class="py-1">{{$counter->codigo}}</td>
            <td class="py-1">{{$counter->tEstado->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>