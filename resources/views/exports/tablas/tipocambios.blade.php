<table class="tabla-listado">
    <thead class="thead-listado">
        <tr>
            <th scope="col" class="py-1 cursor-pointer">
                ID 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Fecha 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Monto 
            </th>
            <th scope="col" class="py-1 cursor-pointer">
                Monto Sunat
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tipoCambios as $tipoCambio)

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <td class="py-1">{{$tipoCambio->id}}</td>
            <td class="py-1">{{$tipoCambio->fechaCambio}}</td>
            <td class="py-1">{{$tipoCambio->montoCambio}}</td>
            <td class="py-1">{{$tipoCambio->montoSunat}}</td>
        </tr>
        @endforeach
    </tbody>
</table>