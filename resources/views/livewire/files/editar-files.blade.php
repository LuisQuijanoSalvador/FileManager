<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    {{request()->route('id')}}
    <div class="row">
        <div class="col-md-3">
            <label for="txtNumeroFile" class="form-label">File:</label>
            <input disabled type="text" class="uTextBox" style="text-transform:uppercase;" id="txtNumeroFile" wire:model="numeroFile">
        </div>
        <div class="col-md-3">
            <label for="txtDescripcion" class="form-label">Descripcion:</label>
            <input disabled type="text" class="uTextBox" style="text-transform:uppercase;" id="txtDescripcion" wire:model="descripcion">
        </div>
        <div class="col-md-3">
            <label for="txtCliente" class="form-label">Cliente:</label>
            <input disabled type="text" class="uTextBox" style="text-transform:uppercase;" id="txtCliente" wire:model="cliente">
        </div>
        <div class="col-md-3">
            <label for="txtArea" class="form-label">Area:</label>
            <input disabled type="text" class="uTextBox" style="text-transform:uppercase;" id="txtArea" wire:model="area">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#FormularioModalBoleto">Agregar Boleto</button>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-success" >Agregar Servicio</button>
        </div>
    </div>
    <hr>

    
    {{-- Modal para Insertar y Actualizar --}}
    <div class="modal fade" id="FormularioModalBoleto" wire:ignore.self tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" id="modalxl1">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Boleto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-auto">
                                    <span for="txtNuneroBoleto" class="">Boleto:</span>
                                </div>
                                <div class="col-md-auto">
                                    <input type="text" class="form-control" id="txtNumeroBoleto" wire:model.lazy.defer="numeroBoleto" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-primary" wire:click="buscar" >Buscar</button>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="cboAerolinea" class="form-label">Aerolinea:</label>
                                    <select name="idAerolinea" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboAerolinea" wire:model="idAerolinea">
                                        @foreach ($aerolineas as $aerolinea)
                                            <option value={{$aerolinea->id}}>{{$aerolinea->razonSocial}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="cboCliente" class="form-label">Cliente:</label>
                                    <select name="selectedCliente" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboCliente" wire:model="selectedCliente">
                                        <option value="">-- Seleccione una opción --</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{$cliente->id}}">{{$cliente->razonSocial}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="cboCounter" class="form-label">Counter:</label>
                                    <select name="idCounter" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboCounter" wire:model="idCounter">
                                        @foreach ($counters as $counter)
                                            <option value={{$counter->id}}>{{$counter->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="cboArea" class="form-label">Área:</label>
                                    <select name="idArea" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboArea" wire:model="idArea">
                                        @foreach ($areas as $area)
                                            <option value={{$area->id}}>{{$area->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="cboVendedor" class="form-label">Vendedor:</label>
                                    <select name="idVendedor" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboVendedor" wire:model="idVendedor">
                                        @foreach ($vendedors as $vendedor)
                                            <option value={{$vendedor->id}}>{{$vendedor->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="cboTipoTicket" class="form-label">Tipo:</label>
                                    <select name="idTipoTicket" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoTicket" wire:model="idTipoTicket">
                                        @foreach ($tipoTickets as $tipoTicket)
                                            <option value={{$tipoTicket->id}}>{{$tipoTicket->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="txtPasajero" class="form-label">Pasajero:</label>
                                    <input type="text" class="uTextBox" style="text-transform:uppercase;" id="txtPasajero" wire:model="pasajero" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                                <div class="col-md-6">
                                    <label for="cboSolicitante" class="form-label">Solicitante:</label>
                                    <select name="selectedSolicitante" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboSolicitante" wire:model="selectedSolicitante">
                                        <option value="0">--</option>
                                        @foreach ($this->solicitantes as $solicitante)
                                            <option value={{$solicitante->id}}>{{$solicitante->nombres}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="cboMoneda">Moneda:</label>
                                    <select name="moneda" style="width: 50%;font-size: 0.8em; display:block;" id="cboMoneda" wire:model.lazy.defer="idMoneda">
                                        <option>==Seleccione una opción==</option>
                                        @foreach ($monedas as $moneda)
                                            <option value={{$moneda->id}}>{{$moneda->codigo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="txtTarifaNeta" class="">Tarifa Neta:</label>
                                    <input type="number" class="uTextBox" id="txtTarifaNeta" wire:model="tarifaNeta">
                                </div>
                                <div class="col-md-4">
                                    <label for="txtTotalOrigen" class="">Total Pagado:</label>
                                    <input type="number" class="uTextBox" id="txtTotalOrigen" wire:model.lazy.defer="totalOrigen">
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="txtXm" class="">XM:</label>
                                    <input type="number" class="uTextBox" id="txtXm" wire:model="xm">
                                 </div>
                                <div class="col-md-4">
                                    <label for="txtTotal" class="">Total venta:</label>
                                    <input type="number" class="uTextBox" id="txtTotal" wire:model.lazy.defer="total">
                                </div>
                                <div class="col-md-4">
                                    <label for="txtComision" class="">Comisión:</label>
                                    <input type="number" class="uTextBox" id="txtComision" wire:model.lazy.defer="montoComision">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="txtCod1" class="form-label">COD1:</label>
                                    <input type="text" class="uTextBox" style="text-transform:uppercase;" id="txtCod1" wire:model="cod1" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                                <div class="col-md-4">
                                    <label for="txtCod2" class="form-label">COD2:</label>
                                    <input type="text" class="uTextBox" style="text-transform:uppercase;" id="txtCod2" wire:model="cod2" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                                <div class="col-md-4">
                                    <label for="txtCod3" class="form-label">COD3:</label>
                                    <input type="text" class="uTextBox" style="text-transform:uppercase;" id="txtCod3" wire:model="cod3" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="txtCentroCosto" class="form-label">Centro Costo:</label>
                                    <input type="text" class="uTextBox" style="text-transform:uppercase;" id="txtCentroCosto" wire:model="centroCosto" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='limpiarControles'>Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click='grabar'>Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <hr>

    
    {{-- <div class="row">
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
    </div> --}}
    {{-- <div class="row">
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
    </div> --}}
    {{-- <div class="row">
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
    </div> --}}
    {{-- <div class="row">
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
    </div> --}}
</div>
