<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                ID
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Nombre
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Codigo
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Comision
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Comision Over
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Estado
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vendedors as $vendedor)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$vendedor->id}}</td>
            <td class="py-1">{{$vendedor->nombre}}</td>
            <td class="py-1">{{$vendedor->codigo}}</td>
            <td class="py-1">{{$vendedor->comision}}</td>
            <td class="py-1">{{$vendedor->comisionOver}}</td>
            <td class="py-1">{{$vendedor->tEstado->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>