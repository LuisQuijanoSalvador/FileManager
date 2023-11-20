<div>
    {{-- In work, do what you enjoy. --}}
    <div class="div-filtro">
        <input type="text" class="txtFiltro" wire:model="search" placeholder="Filtrar por Razon Social">
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
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('razonSocial')">
                    Razon Social 
                    @if ($sort == 'razonSocial')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('numeroDocumentoIdentidad')">
                    Num. Doc. 
                    @if ($sort == 'numeroDocumentoIdentidad')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('montoCredito')">
                    Monto Credito 
                    @if ($sort == 'montoCredito')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('diasCredito')">
                    Dias Credito 
                    @if ($sort == 'diasCredito')
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
            @foreach ($consolidadors as $consolidador)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">{{$consolidador->id}}</td>
                <td class="py-1">{{$consolidador->razonSocial}}</td>
                <td class="py-1">{{$consolidador->numeroDocumentoIdentidad}}</td>
                <td class="py-1">{{$consolidador->montoCredito}}</td>
                <td class="py-1">{{$consolidador->diasCredito}}</td>
                <td class="py-1">{{$consolidador->tEstado->descripcion}}</td>
                <td class="py-1">
                    <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                        <button type="button" class="btn btn-outline-primary mr-2 rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click='editar("{{$consolidador->id}}")'>Editar</button>
                        <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal" data-bs-target="#ModalEliminacion" wire:click='encontrar("{{$consolidador->id}}")'>Eliminar</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$consolidadors->links()}}

    {{-- Modal para Insertar y Actualizar --}}
    @include('components.modalheaderxl')
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed text-bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  Datos
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <form class="row g-3">
                        <div class="col-md-6">
                            <label for="txtRazonSocial" class="form-label">RazonSocial:</label>
                            <input type="text" class="form-control" id="txtRazonSocial" wire:model.lazy="razonSocial" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('razonSocial')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="cboTipoDoc" class="form-label">Tipo Documento:</label>
                            <select name="tipoDocumentoIdentidad" class="form-select" id="cboTipoDoc" wire:model="tipoDocumentoIdentidad">
                                <option>==Seleccione una opción==</option>
                                @foreach ($tipoDocumentoIdentidads as $tipoDocumentoIdentidad)
                                    <option value={{$tipoDocumentoIdentidad->id}}>{{$tipoDocumentoIdentidad->descripcion}}</option>
                                @endforeach
                            </select>
                            @error('tipoDocumentoIdentidad')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="txtNumDoc" class="form-label">Numero Documento:</label>
                            <input type="text" class="form-control" id="txtNumDoc" wire:model.lazy="numeroDocumentoIdentidad" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('numeroDocumentoIdentidad')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="txtNombreComercial" class="form-label">Nombre Comercial:</label>
                            <input type="text" class="form-control" id="txtNombreComercial" wire:model.lazy="nombreComercial" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('nombreComercial')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="cboTipoCliente" class="form-label">Tipo Proveedor:</label>
                            <select name="tipoProveedor" class="form-select" id="cboTipoCliente" wire:model="tipoProveedor">
                                <option>==Seleccione una opción==</option>
                                @foreach ($tipoProveedors as $tipoProveedor)
                                    <option value={{$tipoProveedor->id}}>{{$tipoProveedor->descripcion}}</option>
                                @endforeach
                            </select>
                            @error('tipoProveedor')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="txtTelefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="txtTelefono" wire:model.lazy="numeroTelefono" >
                            @error('numeroTelefono')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
            
                        <div class="col-md-6">
                            <label for="txtdireccionFiscal" class="form-label">Dirección Fiscal:</label>
                            <input type="text" class="form-control" id="txtdireccionFiscal" wire:model.lazy="direccionFiscal" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('direccionFiscal')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="txtdireccionFacturacion" class="form-label">Dirección Facturación:</label>
                            <input type="text" class="form-control" id="txtdireccionFacturacion" wire:model.lazy="direccionFacturacion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('direccionFacturacion')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                    </form>
                </div>
              </div>
            </div>
            
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed text-bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                  Cobranza
                </button>
              </h2>
              <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <form class="row g-3">
                        <div class="col-md-6">
                            <label for="txtCorreo" class="form-label">E-mail:</label>
                            <input type="email" class="form-control" id="txtCorreo" wire:model.lazy="correo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('correo')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="txtMontoCredito" class="form-label">Monto Crédito:</label>
                            <input type="number" step="any" min="0" value=0 class="form-control" id="txtMontoCredito" wire:model.lazy="montoCredito" >
                            @error('montoCredito')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="txtDiasCredito" class="form-label">Días Crédito:</label>
                            <input type="number" min="0" class="form-control" value=0 id="txtDiasCredito" wire:model.lazy="diasCredito" >
                            @error('diasCredito')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="cboMoneda" class="form-label">Moneda:</label>
                            <select name="moneda" class="form-select" id="cboMoneda" wire:model.lazy="moneda">
                                <option>==Seleccione una opción==</option>
                                @foreach ($monedas as $moneda)
                                    <option value={{$moneda->id}}>{{$moneda->moneda}}</option>
                                @endforeach
                            </select>
                            @error('moneda')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                    </form>
                </div>
              </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed text-bg-primary" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                    Gestión
                  </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <form class="row g-3">

                        <div class="col-md-3">
                            <label for="cboTipoDocF" class="form-label">Tipo Documento:</label>
                            <select name="tipoDocumento" class="form-select" id="cboTipoDocF" wire:model.lazy="tipoDocumento">
                                <option>==Seleccione una opción==</option>
                                @foreach ($tipoDocumentos as $tipoDocumento)
                                    <option value={{$tipoDocumento->id}}>{{$tipoDocumento->descripcion}}</option>
                                @endforeach
                            </select>
                            @error('tipoDocumento')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="cboEstados" class="form-label">Estado:</label>
                            <select name="estado" class="form-select" id="cboEstados" wire:model="estado">
                                <option>==Seleccione una opción==</option>
                                @foreach ($estados as $estado)
                                    <option value={{$estado->id}}>{{$estado->descripcion}}</option>
                                @endforeach
                            </select>
                            @error('estado')
                                <span class="error">{{$message}}</span>
                            @enderror
                        </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
    @include('components.modalfooter')
    
    {{-- Modal para Eliminar --}}
    @include('components.modaldelete')
</div>
