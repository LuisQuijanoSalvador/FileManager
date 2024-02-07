<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    {{request()->route('id')}}

    <div class="row">
        <div class="col-md-4">
            <label for="txtNuneroBoleto" class="form-label">Numero Boleto:</label>
            <input type="text" class="form-control" id="txtNumeroBoleto" wire:model.lazy.defer="numeroBoleto" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-primary" wire:click="buscar" >buscar</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <label for="cboCliente" class="form-label">Cliente:</label>
            <select name="selectedCliente" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboCliente" wire:model="selectedCliente">
                <option value="">-- Seleccione una opción --</option>
                @foreach ($clientes as $cliente)
                    <option value="{{$cliente->id}}">{{$cliente->razonSocial}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="cboSolicitante" class="form-label">Solicitante:</label>
            <select name="selectedSolicitante" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboSolicitante" wire:model="selectedSolicitante">
                <option value="0">--</option>
                @foreach ($solicitantes as $solicitante)
                    <option value={{$solicitante->id}}>{{$solicitante->nombres}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="cboCounter" class="form-label">Counter:</label>
            <select name="idCounter" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboCounter" wire:model="idCounter">
                @foreach ($counters as $counter)
                    <option value={{$counter->id}}>{{$counter->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="cboVendedor" class="form-label">Vendedor:</label>
            <select name="idVendedor" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboVendedor" wire:model="idVendedor">
                @foreach ($vendedors as $vendedor)
                    <option value={{$vendedor->id}}>{{$vendedor->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="cboArea" class="form-label">Área:</label>
            <select name="idArea" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboArea" wire:model="idArea">
                @foreach ($areas as $area)
                    <option value={{$area->id}}>{{$area->descripcion}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="cboTipoTicket" class="form-label">Tipo:</label>
            <select name="idTipoTicket" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoTicket" wire:model="idTipoTicket">
                @foreach ($tipoTickets as $tipoTicket)
                    <option value={{$tipoTicket->id}}>{{$tipoTicket->descripcion}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="cboAerolinea" class="form-label">Aerolinea:</label>
            <select name="idAerolinea" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboAerolinea" wire:model="idAerolinea">
                @foreach ($aerolineas as $aerolinea)
                    <option value={{$aerolinea->id}}>{{$aerolinea->razonSocial}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="txtPasajero" class="form-label">Pasajero:</label>
            <input type="text" class="uTextBox" style="text-transform:uppercase;" id="txtPasajero" wire:model="pasajero" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label for="txtCentroCosto" class="form-label">Centro Costo:</label>
            <input type="text" class="uTextBox" id="txtCentroCosto" wire:model.lazy="centroCosto" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-2">
            <label for="txtCod1" class="form-label">COD 1:</label>
            <input type="text" class="uTextBox" id="txtCod1" wire:model.lazy="cod1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-2">
            <label for="txtCod2" class="form-label">COD 2:</label>
            <input type="text" class="uTextBox" id="txtCod2" wire:model.lazy="cod2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-2">
            <label for="txtCod3" class="form-label">COD 3:</label>
            <input type="text" class="uTextBox" id="txtCod3" wire:model.lazy="cod3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
        <div class="col-md-2">
            <label for="txtCod4" class="form-label">COD 4:</label>
            <input type="text" class="uTextBox" id="txtCod4" wire:model.lazy="cod4" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="txtTarifaNeta" class="">Tarifa Neta:</label>
            <input type="number" class="uTextBoxInLine" id="txtTarifaNeta" wire:model="tarifaNeta">
        </div>
        <div class="col-md-3">
            <label for="txtTotalOrigen" class="">Monto Total:</label>
            <input type="number" class="uTextBoxInLine2" id="txtTotalOrigen" wire:model.lazy.defer="totalOrigen">
            
        </div>
        <div class="col-md-3">
            <label for="txtTotal" class="">Monto Cobrar:</label>
            <input type="number" class="uTextBoxInLine" id="txtTotal" wire:model.lazy.defer="total">
        </div>
        <div class="col-md-3">
            <label for="txtXm" class="">XM:</label>
            <input type="number" class="uTextBoxInLine2" id="txtXm" wire:model="xm">
        </div>
    </div>
</div>
