<table class="tabla-listado">
        <thead class="thead-listado">
            <tr>
                <th scope="col" class="py-1 cursor-pointer">
                    ID 
                </th>
                <th scope="col" class="py-1 cursor-pointer">
                    Pais 
                </th>
                <th scope="col" class="py-1 cursor-pointer">
                    Moneda 
                </th>
                <th scope="col" class="py-1 cursor-pointer">
                    Codigo
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($monedas as $moneda)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-1">{{$moneda->id}}</td>
                    <td class="py-1">{{$moneda->pais}}</td>
                    <td class="py-1">{{$moneda->moneda}}</td>
                    <td class="py-1">{{$moneda->codigo}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>