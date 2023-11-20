<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                ID
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Razon Social
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Num. Doc.
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Monto Credito
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Dias Credito
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Estado
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($proveedors as $proveedor)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$proveedor->id}}</td>
            <td class="py-1">{{$proveedor->razonSocial}}</td>
            <td class="py-1">{{$proveedor->numeroDocumentoIdentidad}}</td>
            <td class="py-1">{{$proveedor->montoCredito}}</td>
            <td class="py-1">{{$proveedor->diasCredito}}</td>
            <td class="py-1">{{$proveedor->tEstado->descripcion}}</td>
        </tr>
        @endforeach
    </tbody>
</table>