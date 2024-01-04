<div>
    {{-- Do your work, then step back. --}}
    <div class="div-filtro">
        <input type="text" class="txtFiltro" id="txtFiltro" wire:model="search" placeholder="Filtrar por documento">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div>
            <button type="button" class="btn btn-success" wire:click='exportar'>Exportar</button>
            {{-- <button type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal">Nuevo</button> --}}
        </div>
        
    </div>
    <table class="tabla-listado">
        <thead class="thead-listado">
            <tr>
                <th scope="col" class="py-1 ">
                    Acción
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('id')">
                    ID 
                    @if ($sort == 'id')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('numero')">
                    Documento 
                    @if ($sort == 'numero')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('idTipoDocumento')">
                    Tipo 
                    @if ($sort == 'idTipoDocumento')
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
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('total')">
                    Total 
                    @if ($sort == 'total')
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
            @foreach ($documentos as $documento)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">
                    <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                        <button type="button" class="btn btn-outline-primary mr-2 rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click='ver("{{$documento->id}}")'>Ver</button>
                    </div>
                </td>
                <td class="py-1">{{$documento->id}}</td>
                <td class="py-1">{{$documento->numero}}</td>
                <td class="py-1">{{$documento->tTipoDocumento->descripcion}}</td>
                <td class="py-1">{{$documento->tcliente->razonSocial}}</td>
                <td class="py-1">{{$documento->fechaEmision}}</td>
                <td class="py-1">{{$documento->total}}</td>
                <td class="py-1">{{$documento->tEstado->descripcion}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$documentos->links()}}

    <div class="modal fade" id="FormularioModal" wire:ignore.self tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" id="modalxl1">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Documento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click='limpiarControles' aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-2">
                            <label for="cboTipoDocumento" class="form-label">Tipo Documento:</label>
                            <select disabled name="idTipoDocumento" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboTipoDocumento" wire:model="idTipoDocumento">
                                @foreach ($tipoDocumentos as $tipoDocumento)
                                    <option value={{$tipoDocumento->id}}>{{$tipoDocumento->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="txtSerie" class="">Serie: </label>
                            <input disabled type="text" class="uTextBox" id="txtSerie" wire:model.lazy.defer="serie">
                        </div>
                        <div class="col-md-2">
                            <label for="txtNumero" class="">Número: </label>
                            <input disabled type="text" class="uTextBox" id="txtNumero" wire:model.lazy.defer="numero">
                        </div>
                        <div class="col-md-2">
                            <label for="txtFechaEmision" class="form-label">F. Emisión:</label>
                            <input disabled type="date" class="" style="width: 100%; display:block;font-size: 0.8em;font-size: 0.8em;" id="txtFechaEmision" wire:model="fechaEmision">
                        </div>
                        <div class="col-md-2">
                            <label for="txtFechaVencimiento" class="form-label">F. Vencimiento:</label>
                            <input disabled type="date" class="" style="width: 100%; display:block;font-size: 0.8em;font-size: 0.8em;" id="txtFechaVencimiento" wire:model="fechaVencimiento">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="txtDocRef" class="">Doc. Rereferncia: </label>
                            <input disabled type="text" class="uTextBox" id="txtDocRef" wire:model.lazy.defer="documentoReferencia">
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
                            <label for="cboEstado" class="form-label">Estado:</label>
                            <select disabled name="estado" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboEstado" wire:model="idEstado">
                                @foreach ($estados as $estado)
                                    <option value={{$estado->id}}>{{$estado->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="cboCliente" class="form-label">Cliente:</label>
                            <select disabled name="selectedCliente" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboCliente" wire:model="idCliente">
                                @foreach ($clientes as $cliente)
                                    <option value="{{$cliente->id}}">{{$cliente->razonSocial}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='limpiarControles'>Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
