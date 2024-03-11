<div class="contenedorTablaCC">
    <table class="tabla-listado">
        <thead class="thead-listado">
            <tr>
                <th scope="col" class="py-1">
                    FECHA 
                </th>
                <th scope="col" class="py-1">
                    MONTO
                </th>
                <th scope="col" class="py-1">
                    DOCUMENTO
                </th>
                <th scope="col" class="py-1">
                    CLIENTE
                </th>
                <th scope="col" class="py-1">
                    MEDIO PAGO
                </th>
                <th scope="col" class="py-1">
                    REFERENCIA
                </th>
                <th scope="col" class="py-1 thAccion">
                    BANCO
                </th>
                <th scope="col" class="py-1 thAccion">
                    NUM. CUENTA
                </th>
                <th scope="col" class="py-1 thAccion">
                    OBSERVACIONES
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($abonos as $abono)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">{{$abono->FechaAbono}}</td>
                <td class="py-1">{{$abono->Monto}}</td>
                <td class="py-1">{{$abono->Documento}}</td>
                <td class="py-1">{{$abono->Cliente}}</td>
                <td class="py-1">{{$abono->MedioPago}}</td>
                <td class="py-1">{{$abono->Referencia}}</td>
                <td class="py-1">{{$abono->Banco}}</td>
                <td class="py-1">{{$abono->numeroCuenta}}</td>
                <td class="py-1">{{$abono->observaciones}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>