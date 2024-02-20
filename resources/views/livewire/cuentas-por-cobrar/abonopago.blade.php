<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <hr>
    <div class="">
        <div class="row">
            <div class="col-md-4">
                <label for="txtFechaAbono" class="form-label">F. Abono:</label>
                <input type="date" class="" style="width: 100%; display:block;font-size: 0.8em;font-size: 0.8em;" id="txtFechaAbono" wire:model.lazy.defer="fechaAbono">
            </div>
            <div class="col-md-4">
                <label for="idMedioPago" class="form-label">Medio Pago:</label>
                <select name="idMedioPago" style="width: 100%;font-size: 0.8em; display:inline;" id="cboFPago" wire:model.lazy.defer="idMedioPago">
                    <option>==Seleccione una opción==</option>
                    @foreach ($medioPagos as $medioPago)
                        <option value={{$medioPago->id}}>{{$medioPago->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="txtReferencia" class="">Nro.Tarj/Deposito:</label>
                <input type="text" class="uTextBox" id="txtReferencia" wire:model.lazy="referencia" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="cboTarjeta" class="form-label">Tarjeta:</label>
                <select name="idTarjetaCredito" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTarjeta" wire:model.defer="idTarjetaCredito">
                    <option>Seleccione una Opción</option>
                    @foreach ($tarjetaCreditos as $tarjetaCredito)
                        <option value="{{$tarjetaCredito->id}}">{{$tarjetaCredito->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="cboBanco" class="form-label">Banco:</label>
                <select name="idBanco" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboBanco" wire:model.defer="idBanco">
                    <option>Seleccione una Opción</option>
                    @foreach ($bancos as $banco)
                        <option value="{{$banco->id}}">{{$banco->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="cboMoneda" class="form-label">Moneda:</label>
                <select name="moneda" style="width: 100%;font-size: 0.8em; display:block;" id="cboMoneda" wire:model.lazy.defer="moneda">
                    <option>==Seleccione una opción==</option>
                    @foreach ($monedas as $moneda)
                        <option value={{$moneda->id}}>{{$moneda->codigo}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="txtTipoCambio" class="form-label">Tipo Cambio:</label>
                <input type="number" disabled class="uTextBox" id="txtTipoCambio" wire:model.lazy.defer="tipoCambio">
            </div>
            <div class="col-md-8">
                <label for="txtObservaciones" class="form-label">Concepto:</label>
                <input type="text" class="uTextBox" id="txtObservaciones" wire:model.lazy.defer="observaciones" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
        </div>

        <hr>
        <div class="contenedorTabla">
            <table class="tabla-listado">
                <thead class="thead-listado">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Serie</th>
                        <th scope="col">Numero</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Moneda</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">TC</th>
                        <th scope="col">Saldo</th>
                        <th scope="col">Abono</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cargos as $cargo)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-1">{{$cargo->id}}</td>
                            <td class="py-1">{{$cargo->tipoDocumento}}</td>
                            <td class="py-1">{{$cargo->serieDocumento}}</td>
                            <td class="py-1">{{$cargo->numeroDocumento}}</td>
                            <td class="py-1">{{$cargo->fechaEmision}}</td>
                            <td class="py-1">{{$cargo->moneda}}</td>
                            <td class="py-1">{{$cargo->montoCargo}}</td>
                            <td class="py-1">{{$cargo->tipoCambio}}</td>
                            <td class="py-1">{{$cargo->saldo}}</td>
                            <td class="py-1"><input type="number" wire:model="pagos.{{ $cargo->id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> 
        <hr>
        <button type="button" class="btn btn-primary" wire:click="abonar">
            Abonar
        </button>
    </div>
</div>
