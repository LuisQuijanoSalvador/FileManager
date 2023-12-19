<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                ID 
            </th>
            <th scope="col" class="py-1 cursor-pointer" >
                Tabla 
            </th>
            <th scope="col" class="py-1 cursor-pointer" >
                Serie 
            </th>
            <th scope="col" class="py-1 cursor-pointer" >
                Numero 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Estado 
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($correlativos as $correlativo)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$correlativo->id}}</td>
            <td class="py-1">{{$correlativo->tabla}}</td>
            <td class="py-1">{{$correlativo->serie}}</td>
            <td class="py-1">{{$correlativo->numero}}</td>
            <td class="py-1">{{$correlativo->tEstado->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>