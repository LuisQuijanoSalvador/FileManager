<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <hr>
    <div class="row align-items-center">
        <div class="col-md-2 mt-2">
            <label for="cboMoneda">Moneda:</label>
            <select name="moneda" style="width: 50%;font-size: 0.8em; display:inline;" id="cboMoneda" wire:model.lazy.defer="idMoneda">
                @foreach ($monedas as $moneda)
                    <option value={{$moneda->id}}>{{$moneda->codigo}}</option>
                @endforeach
            </select>
            @error('idMoneda')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-3 mt-2">
            <label for="txtTipoCambio" class="">Tipo Cambio:</label>
            <input type="number" class="uTextBoxInLine" id="txtTipoCambio" wire:model="tipoCambio" disabled>
            @error('tipoCambio')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-3 mt-2">
            <div class="row">
                <div class="col-md-5 ">
                    <label for="txtFechaEmision" class="">F. Emisión:</label>
                </div>
                <div class="col-md-7">
                    <input type="date" class="" style="width: 100%; display:flex;font-size: 0.8em;font-size: 0.8em;" id="txtFechaEmision" wire:model.lazy="fechaEmision">
                    @error('fechaEmision')
                        <span class="error">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-2">
            <input type="checkbox" id="detraccion" name="detraccion"  wire:model="detraccion">
            <label for="detraccion">Detracción</label>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalGlosa">Emitir CPE</button>
        </div>
        
    </div>

    <div class="modal" id="modalGlosa" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Glosa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea id="w3review" name="w3review" rows="4" cols="50" wire:model.lazy.defer="glosa" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    
                </textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" wire:click="emitirComprobante" data-bs-dismiss="modal">Emitir</button>
            </div>
          </div>
        </div>
    </div>
    <hr>

    <div class="row">
        {{-- <livewire:facturacion-table/> --}}
        <div class="div-filtro row">
            <div class="row">
                <div class="col-md-3">
                    <select name="selectedCliente" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboCliente" wire:model.lazy.defer="idCliente">
                        <option value="">-- Seleccione un cliente --</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{$cliente->id}}">{{$cliente->razonSocial}}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" class="txtFiltro" id="txtFiltro" wire:model="search" placeholder="Filtrar por boleto"> --}}
                    
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="text-align:right">F. inicio:</p>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" wire:model.lazy.defer="startDate" id="startDate">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="text-align:right">F. Final:</p>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" wire:model.lazy.defer="endDate" id="endDate">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" wire:click="filtrar" >Filtrar</button>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
        </div>
        <table class="tabla-listado">
            <thead class="thead-listado">
                <tr>
                    <th scope="col" class="py-1 cursor-pointer">
                        
                    </th>
                    <th scope="col" class="py-1 cursor-pointer" wire:click="order('id')">
                        ID 
                        @if ($sort == 'id')
                            <i class="fas fa-sort float-right py-1 px-1"></i>
                        @endif
                    </th>
                    <th scope="col" class="py-1 cursor-pointer" wire:click="order('numeroBoleto')">
                        Boleto 
                        @if ($sort == 'numeroBoleto')
                            <i class="fas fa-sort float-right py-1 px-1"></i>
                        @endif
                    </th>
                    <th scope="col" class="py-1 cursor-pointer" wire:click="order('numeroFile')">
                        File 
                        @if ($sort == 'numeroFile')
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
                </tr>
            </thead>
            <tbody>
                @if($this->boletos)
                @foreach ($this->boletos as $boleto)
    
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-1"><input type="checkbox" name="chkSelect" id="" wire:model.lazy.defer="selectedRows" value="{{ $boleto->id }}"></td>
                    <td class="py-1">{{$boleto->id}}</td>
                    <td class="py-1">{{$boleto->numeroBoleto}}</td>
                    <td class="py-1">{{$boleto->numeroFile}}</td>
                    <td class="py-1">{{$boleto->tcliente->razonSocial}}</td>
                    <td class="py-1">{{$boleto->fechaEmision}}</td>
                    <td class="py-1">{{$boleto->pasajero}}</td>
                    <td class="py-1">{{$boleto->tEstado->descripcion}}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        @if($this->boletos)
        {{$this->boletos->links()}}
        @endif
    </div>
</div>
