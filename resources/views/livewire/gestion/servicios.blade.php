@php
    use Carbon\Carbon;
@endphp
<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="div-filtro">
        <input type="text" class="txtFiltro" id="txtFiltro" wire:model="search" placeholder="Filtrar por File">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div>
            <button type="button" class="btn btn-success" wire:click='exportar'>Exportar</button>
            <button type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal">Nuevo</button>
        </div>
    </div>

    <table class="tabla-listado">
        <thead class="thead-listado">
            <tr>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('id')">
                    ID 
                    @if ($sort == 'id')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('numeroFile')">
                    File 
                    @if ($sort == 'numeroBoleto')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('idCliente')">
                    Cliente
                    @if ($sort == 'idCliente')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('fechaEmision')">
                    F. Emisión 
                    @if ($sort == 'fechaEmision')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('pasajero')">
                    Pasajero 
                    @if ($sort == 'pasajero')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('estado')">
                    Estado 
                    @if ($sort == 'estado')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 thAccion">
                    Acción
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicios as $servicio)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">{{$servicio->id}}</td>
                <td class="py-1">{{$servicio->numeroFile}}</td>
                <td class="py-1">{{$servicio->tcliente->razonSocial}}</td>
                <td class="py-1">{{Carbon::parse($servicio->fechaEmision)->format("d-m-Y")}}</td>
                <td class="py-1">{{$servicio->pasajero}}</td>
                <td class="py-1">{{$servicio->tEstado->descripcion}}</td>
                <td class="py-1">
                    <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                        <button type="button" class="btn btn-outline-primary mr-2 rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click='editar("{{$servicio->id}}")'>Editar</button>
                        <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal" data-bs-target="#ModalEliminacion" wire:click='encontrar("{{$servicio->id}}")'>Eliminar</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$servicios->links()}}

    @include('components.modalheaderxl')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('ErrorPagos'))
        <div class="alert alert-danger">
            {{ session('ErrorPagos') }}
        </div>
    @endif
    
    @if ($idRegistro!=0)
        <div class="row">
            <div class="col-md-1">
                <br>
                <button type="button" class="btn btn-success" wire:click='clonarServicio'>Clonar</button>
            </div>
        </div>
    @endif
    <hr width="100%">
    <form>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed text-bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                      Datos del Servicio
                    </button>
                  </h2>
                  <div id="flush-collapseOne" class="accordion-collapse">
                    <div class="seccion1">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="txtServicio" class="">Número Servicio:</label>
                                <input type="text" class="uTextBox" id="txtServicio" wire:model.lazy="numeroServicio" onkeypress="return valideKey(event);" disabled>
                                @error('numeroServicio')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="txtFile" class="form-label">File:</label>
                                <input type="text" class="uTextBox" maxlength="10" id="txtFile" wire:model.lazy="numeroFile" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                
                            </div>
                            <div class="col-md-4">
                                <label for="cboCliente" class="form-label">Cliente:</label>
                                <select name="selectedCliente" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboCliente" wire:model="selectedCliente">
                                    <option value="">-- Seleccione una opción --</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{$cliente->id}}">{{$cliente->razonSocial}}</option>
                                    @endforeach
                                </select>
                                @error('selectedCliente')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="cboSolicitante" class="form-label">Solicitante:</label>
                                <select name="selectedSolicitante" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboSolicitante" wire:model="selectedSolicitante">
                                    <option value="0">--</option>
                                    @foreach ($solicitantes as $solicitante)
                                        <option value={{$solicitante->id}}>{{$solicitante->nombres}}</option>
                                    @endforeach
                                </select>
                                @error('selectedSolicitante')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="cboCounter" class="form-label">Counter:</label>
                                <select name="idCounter" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboCounter" wire:model="idCounter">
                                    @foreach ($counters as $counter)
                                        <option value={{$counter->id}}>{{$counter->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('idCounter')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="cboVendedor" class="form-label">Vendedor:</label>
                                <select name="idVendedor" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboVendedor" wire:model="idVendedor">
                                    @foreach ($vendedors as $vendedor)
                                        <option value={{$vendedor->id}}>{{$vendedor->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('idVendedor')
                                    <span class="error">{{$message}}</span>
                                @enderror
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
                                @error('idArea')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="cboTipoFacturacion" class="form-label">Tipo Fact:</label>
                                <select name="idTipoFacturacion" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoFacturacion" wire:model="idTipoFacturacion">
                                    @foreach ($tipoFacturacions as $tipoFacturacion)
                                        <option value={{$tipoFacturacion->id}}>{{$tipoFacturacion->descripcion}}</option>
                                    @endforeach
                                </select>
                                @error('idTipoFacturacion')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="txtFechaEmision" class="form-label">F. Emisión:</label>
                                <input type="date" class="" style="width: 100%; display:block;font-size: 0.8em;font-size: 0.8em;" id="txtFechaEmision" wire:model="fechaEmision">
                                @error('fechaEmision')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="cboProveedor" class="form-label">Proveedor:</label>
                                <select name="idProveedor" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboProveedor" wire:model="idProveedor">
                                    @foreach ($proveedors as $proveedor)
                                        <option value={{$proveedor->id}}>{{$proveedor->razonSocial}}</option>
                                    @endforeach
                                </select>
                                @error('idProveedor')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="txtCentroCosto" class="form-label">Centro Costo:</label>
                                <input type="text" class="uTextBox" id="txtCentroCosto" wire:model.lazy="centroCosto" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                @error('centroCosto')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtCod1" class="form-label">COD 1:</label>
                                <input type="text" class="uTextBox" id="txtCod1" wire:model.lazy="cod1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                @error('cod1')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtCod2" class="form-label">COD 2:</label>
                                <input type="text" class="uTextBox" id="txtCod2" wire:model.lazy="cod2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                @error('cod2')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtCod3" class="form-label">COD 3:</label>
                                <input type="text" class="uTextBox" id="txtCod3" wire:model.lazy="cod3" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                @error('cod3')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtCod4" class="form-label">COD 4:</label>
                                <input type="text" class="uTextBox" id="txtCod4" wire:model.lazy="cod4" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                @error('cod4')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                        
                    <hr class="">
                    <div class="seccion2">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="txtFechaReserva" class="form-label">F. Reserva:</label>
                                <input type="date" class="" style="width: 100%; display:block;font-size: 0.8em;" id="txtFechaReserva" wire:model="fechaReserva">
                                @error('fechaReserva')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtFechaIn" class="form-label">Fecha In:</label>
                                <input type="date" class="" style="width: 100%; display:block;font-size: 0.8em;" id="txtFechaIn" wire:model="fechaIn">
                                @error('fechaIn')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtFechaOut" class="form-label">Fecha Out:</label>
                                <input type="date" class="" style="width: 100%; display:block;font-size: 0.8em;" id="txtFechaOut" wire:model="fechaOut">
                                @error('fechaReserva')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="cboTipoServicio" class="form-label">Tipo:</label>
                                <select name="idTipoServicio" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoServicio" wire:model="idTipoServicio">
                                    @foreach ($tipoServicios as $tipoServicio)
                                        <option value={{$tipoServicio->id}}>{{$tipoServicio->descripcion}}</option>
                                    @endforeach
                                </select>
                                @error('idTipoServicio')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="cboTipoRuta" class="form-label">Nac./Int.:</label>
                                <select name="tipoRuta" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoRuta" wire:model="tipoRuta">
                                    <option value="INTERNACIONAL">INTERNACIONAL</option>
                                    <option value="NACIONAL">NACIONAL</option>
                                </select>
                                @error('tipoRuta')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="cboTipoTarifa" class="form-label">Tipo Tarifa:</label>
                                <select name="tipoTarifa" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoTarifa" wire:model="tipoTarifa">
                                    <option value="BULK">BULK</option>
                                    <option value="NORMAL">NORMAL</option>
                                </select>
                                @error('tipoTarifa')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="cboOrigen" class="form-label">Origen:</label>
                                <select name="origen" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboOrigen" wire:model="origen">
                                    <option value="BSP">BSP</option>
                                    <option value="LA">LA</option>
                                </select>
                                @error('origen')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtPasajero" class="form-label">Pasajero:</label>
                                <input type="text" class="uTextBox" style="text-transform:uppercase;" id="txtPasajero" wire:model="pasajero" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                @error('pasajero')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="cboTipoPasajero" class="form-label">Tipo Pax:</label>
                                <select name="idTipoPasajero" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoPasajero" wire:model="idTipoPasajero">
                                    @foreach ($tipoPasajeros as $tipoPasajero)
                                        <option value={{$tipoPasajero->id}}>{{$tipoPasajero->descripcion}}</option>
                                    @endforeach
                                </select>
                                @error('idTipoPasajero')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtDestino" class="form-label">Destino:</label>
                                <input type="text" class="uTextBox" style="text-transform:uppercase;" id="txtDestino" wire:model="destino" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                @error('destino')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                        
                    <hr class="">
                    <div class="seccion1">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="txtDocumento" class="form-label">Documento:</label>
                                <input type="text" class="uTextBox" id="txtDocumento" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="cboTipoDocumento" class="form-label">Tipo Documento:</label>
                                <select name="idTipoDocumento" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoDocumento" wire:model="idTipoDocumento">
                                    @foreach ($tipoDocumentos as $tipoDocumento)
                                        <option value={{$tipoDocumento->id}}>{{$tipoDocumento->descripcion}}</option>
                                    @endforeach
                                </select>
                                @error('idTipoDocumento')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="cboEstado" class="form-label">Estado:</label>
                                <select name="estado" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboEstado" wire:model="estado">
                                    @foreach ($estados as $estado)
                                        <option value={{$estado->id}}>{{$estado->descripcion}}</option>
                                    @endforeach
                                </select>
                                @error('estado')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="txtObservaciones" class="form-label">Observaciones:</label>
                                <input type="text" class="uTextBox" style="text-transform:uppercase;" id="txtObservaciones" wire:model="observaciones" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                @error('observaciones')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="cboUsuarioCreacion" class="form-label">Creado Por:</label>
                                <select name="usuarioCreacion" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboUsuarioCreacion" wire:model="usuarioCreacion" disabled>
                                    <option value="">--  --</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value={{$usuario->id}}>{{$usuario->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="txtFechaCreacion" class="form-label">Fecha:</label>
                                <input type="date" class="" style="width: 100%; display:block;font-size: 0.8em;" id="txtFechaCreacion" wire:model="fechaCreacion" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="cboUsuarioModificacion" class="form-label">Modificado Por:</label>
                                <select name="usuarioModificacion" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboUsuarioModificacion" wire:model="usuarioModificacion" disabled>
                                    <option value="">--  --</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value={{$usuario->id}}>{{$usuario->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="txtFechaModificacion" class="form-label">Fecha:</label>
                                <input type="date" class="" style="width: 100%; display:block;font-size: 0.8em;" id="txtFechaModificacion" wire:model="fechaModificacion" disabled>
                            </div>
                        </div>
                    </div>
                  </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed text-bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseOne">
                        Tarifas
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse">
                    <div class="seccion1">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="cboMoneda">Moneda:</label>
                                <select name="moneda" style="width: 50%;font-size: 0.8em; display:inline;" id="cboMoneda" wire:model.lazy.defer="idMoneda">
                                    <option>==Seleccione una opción==</option>
                                    @foreach ($monedas as $moneda)
                                        <option value={{$moneda->id}}>{{$moneda->codigo}}</option>
                                    @endforeach
                                </select>
                                @error('idMoneda')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="txtTipoCambio" class="">Tipo Cambio:</label>
                                <input type="number" class="uTextBoxInLine" id="txtTipoCambio" wire:model.lazy.defer="tipoCambio" disabled>
                                @error('tipoCambio')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <table>
                                    <tr>
                                        <td>
                                            <label for="txtTarifaNeta" class="">Afecto:</label>
                                        </td>
                                        <td>
                                            <input type="number" class="uTextBoxInLine" id="txtTarifaNeta" wire:model="tarifaNeta">
                                            @error('tarifaNeta')
                                                <span class="error">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="txtInafecto" class="">Inafecto:</label>
                                        </td>
                                        <td>
                                            <input type="number" class="uTextBoxInLine" id="txtInafecto" wire:model="inafecto">
                                            @error('inafecto')
                                                <span class="error">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="txtIgv" class="">IGV:</label>
                                        </td>
                                        <td>
                                            <input type="number" class="uTextBoxInLine" id="txtIgv" wire:model.lazy.defer="igv" disabled>
                                            @error('igv')
                                                <span class="error">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="txtOtrosImpuestos" class="">Otros Imp.:</label>
                                        </td>
                                        <td>
                                            <input type="number" class="uTextBoxInLine" id="txtOtrosImpuestos" wire:model="otrosImpuestos">
                                            @error('otrosImpuestos')
                                                <span class="error">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <label for="txtTotal" class="">Total venta:</label>
                                        </td>
                                        <td>
                                            <input type="number" class="uTextBoxInLine" id="txtTotal" wire:model.lazy.defer="total">
                                            @error('total')
                                                <span class="error">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    
                                </table> 
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td>
                                            <label for="txtXm" class="">XM:</label>
                                        </td>
                                        <td>
                                            <input type="number" class="uTextBoxInLine2" id="txtXm" wire:model="xm">
                                            @error('xm')
                                                <span class="error">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="txtTotalOrigen" class="">Total Pagado:</label>
                                        </td>
                                        <td>
                                            <input type="number" class="uTextBoxInLine2" id="txtTotalOrigen" wire:model.lazy.defer="totalOrigen">
                                            @error('totalOrigen')
                                                <span class="error">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="txtFormaPago" class="">Forma Pago:</label>
                                        </td>
                                        <td>
                                            <select name="idTipoPagoConsolidador" style="width: 60%;font-size: 0.8em; display:inline;" id="cboFPago" wire:model.lazy.defer="idTipoPagoConsolidador">
                                                <option>==Seleccione una opción==</option>
                                                @foreach ($medioPagos as $medioPago)
                                                    <option value={{$medioPago->id}}>{{$medioPago->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="txtComision" class="">Comisión:</label>
                                        </td>
                                        <td>
                                            <input type="number" class="uTextBoxInLine2" id="txtComision" wire:model.lazy.defer="montoComision">
                                            @error('montoComision')
                                                <span class="error">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed text-bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseOne">
                        Pagos
                    </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse">
                    <div class="seccion1">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="cboTipoPago" class="form-label">Medio de Pago:</label>
                                <select required name="idMedioPago" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoPago" wire:model.defer="idMedioPago">
                                    <option value=''>--</option>
                                    @foreach ($medioPagos as $medioPago)
                                        <option value="{{$medioPago->id}}">{{$medioPago->descripcion}}</option>
                                    @endforeach
                                </select>
                                @error('idMedioPago')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="cboTarjeta" class="form-label">Tarjeta:</label>
                                <select required name="idTarjetaCredito" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTarjeta" wire:model.defer="idTarjetaCredito">
                                    <option value=''>--</option>
                                    @foreach ($tarjetaCreditos as $tarjetaCredito)
                                        <option value="{{$tarjetaCredito->id}}">{{$tarjetaCredito->descripcion}}</option>
                                    @endforeach
                                </select>
                                @error('idTarjetaCredito')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtNumeroTarjeta" class="">Número Tarjeta:</label>
                                <input type="text" class="uTextBox" maxlength="19"  id="txtNumeroTarjeta" wire:model.lazy.defer="numeroTarjeta" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                @error('numeroTarjeta')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtMonto" class="">Monto:</label>
                                <input required type="number" step="0.01" class="uTextBox"  id="txtMonto" wire:model.lazy.defer="monto">
                                @error('monto')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="txtFechaVencimiento" class="">F. Vencimiento:</label>
                                <input type="text" class="uTextBox" maxlength="5"  id="txtFechaVencimiento" wire:model.lazy.defer="fechaVencimientoTC" pattern="^(0[1-9]|1[0-2])\/\d{2}$" placeholder="MM/AA" onkeypress="return valideKey(event);">
                                @error('fechaVencimientoTC')
                                    <span class="error">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <button type="button" style="margin-top: 20px" wire:click="addPago()">
                                    <img src="{{ asset('img/add.png')}}" width="30px" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="seccion2">
                        @if(session('ErrorPagos'))
                            <div class="alert alert-danger">
                                {{ session('ErrorPagos') }}
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-12">
                                <table class="tabla-listado">
                                    <thead class="thead-listado">
                                        <tr>
                                            <th scope="col" class="py-1 cursor-pointer">
                                                Medio Pago 
                                            </th>
                                            <th scope="col" class="py-1 cursor-pointer">
                                                Tipo Tarjeta
                                            </th>
                                            <th scope="col" class="py-1 cursor-pointer">
                                                Numero Tarjeta
                                            </th>
                                            <th scope="col" class="py-1 cursor-pointer" >
                                                Monto
                                            </th>
                                            <th scope="col" class="py-1 cursor-pointer">
                                                F. Vencimiento
                                            </th>
                                            <th scope="col" class="py-1 thAccion">
                                                Acción
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($servicioPagos)
                                            @foreach ($servicioPagos as $servicioPago)
                                
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td class="py-1">{{$servicioPago['medioPago']}}</td>
                                                    <td class="py-1">{{$servicioPago['tarjetaCredito']}}</td>
                                                    <td class="py-1">{{$servicioPago['numeroTarjeta']}}</td>
                                                    <td class="py-1">{{$servicioPago['monto']}}</td>
                                                    <td class="py-1">{{$servicioPago['fechaVencimientoTC']}}</td>

                                                    <td class="py-1">
                                                        <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                                                            <button type="button" style="margin-top: 0px" wire:click="quitarPago({{$loop->index}})">
                                                                <img src="{{ asset('img/delete.png')}}" width="20px" style="margin-bottom: 3px">
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        {{-- @else
                                            @foreach ($this->servPag as $servicioP)
                                    
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td class="py-1">{{$servicioP->tMedioPago->descripcion}}</td>
                                                    <td class="py-1">{{$servicioP->tTarjetaCredito->descripcion}}</td>
                                                    <td class="py-1">{{$servicioP->numeroTarjeta}}</td>
                                                    <td class="py-1">{{$servicioP->monto}}</td>
                                                    <td class="py-1">{{$servicioP->fechaVencimientoTC}}</td>

                                                    <td class="py-1">
                                                        <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                                                            <button type="button" style="margin-top: 0px" wire:click="quitarPago({{$loop->index}})">
                                                                <img src="{{ asset('img/delete.png')}}" width="20px" style="margin-bottom: 3px">
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach --}}
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </form>

    @include('components.modalfooter')
    
    {{-- Modal para Eliminar --}}
    @include('components.modaldelete')
</div>
