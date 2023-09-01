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
                Email 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Estado 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Rol 
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$usuario->id}}</td>
            <td class="py-1">{{$usuario->name}}</td>
            <td class="py-1">{{$usuario->email}}</td>
            <td class="py-1">{{$usuario->tEstado->descripcion}}</td>
            <td class="py-1">{{$usuario->tRol->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>