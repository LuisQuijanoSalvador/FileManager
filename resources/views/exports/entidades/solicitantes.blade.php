<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                ID
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Nombres
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Email
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Cliente
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Estado
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($solicitantes as $solicitante)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$solicitante->id}}</td>
            <td class="py-1">{{$solicitante->nombres}}</td>
            <td class="py-1">{{$solicitante->email}}</td>
            <td class="py-1">{{$solicitante->tCliente->razonSocial}}</td>
            <td class="py-1">{{$solicitante->tEstado->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>