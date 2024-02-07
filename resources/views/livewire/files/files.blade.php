<div>
    {{-- Do your work, then step back. --}}
    <div class="row">
        <div class="col-md-3">
            <input type="text" class="txtFiltro" style="width: 100%;" wire:model="search" placeholder="Filtrar por File o Pasajero">
        </div>
        <div class="col-md-3">
            <select name="filtroCliente" class="form-select" style="height: 32px;" id="cboFiltroClientes" wire:model="filtroCliente">
                <option>==Seleccione un Cliente==</option>
                @foreach ($clientes as $cliente)
                    <option value={{$cliente->id}}>{{$cliente->razonSocial}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <span>F. Inicio:</span>
            <input type="date" wire:model.lazy.defer="startDate" id="startDate">
            <span>F. Fin:</span>
            <input type="date" wire:model.lazy.defer="endDate" id="endDate">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-primary" wire:click="filtrar" >Filtrar</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-2">
            <button type="button" class="btn btn-primary" wire:click="nuevo" >Nuevo</button>
        </div>
    </div>
    <hr>
    @if($this->mostrarPanel)
        <div class="row">
            <div class="col-md-2">
                <label for="txtNuneroFile" class="form-label">Numero File:</label>
                <input type="text" class="form-control" id="txtNumeroFile" wire:model.lazy.defer="numeroFile" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
            <div class="col-md-3">
                <label for="txtDescripcion" class="form-label">Descripccion:</label>
                <input type="text" class="form-control" id="txtDescripcion" wire:model.lazy.defer="descripcion" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            </div>
            <div class="col-md-3">
                <label for="cboClientes" class="form-label">Cliente:</label>
                <select name="cliente" class="form-select" style="height: 32px;" id="cboClientes" wire:model.lazy.defer="idCliente">
                    <option>==Seleccione un Cliente==</option>
                    @foreach ($clientes as $cliente)
                        <option value={{$cliente->id}}>{{$cliente->razonSocial}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="cboAreas" class="form-label">Area:</label>
                <select name="area" class="form-select" style="height: 32px;" id="cboAreas" wire:model.lazy.defer="idArea">
                    <option>==Seleccione Area==</option>
                    @foreach ($areas as $area)
                        <option value={{$area->id}}>{{$area->descripcion}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <br>
                <button type="button" class="btn btn-primary" wire:click="grabar" >Grabar</button>
            </div>
        </div>
    @endif
    
    <hr>

    <div class="contenedorTabla">
        <table class="tabla-listado">
            <thead class="thead-listadoCC">
                <th scope="col" class="py-1 p-2">
                    Accion 
                </th>
                <th scope="col" class="py-1 p-2">
                    ID 
                </th>
                <th scope="col" class="py-1 p-2">
                    File 
                </th>
                <th scope="col" class="py-1 p-2">
                    Descripcion 
                </th>
                <th scope="col" class="py-1 p-2">
                    Cliente 
                </th>
                <th scope="col" class="py-1 p-2">
                    Area 
                </th>
                <th scope="col" class="py-1 p-2">
                    TotalPago 
                </th>
                <th scope="col" class="py-1 p-2">
                    TotalCobro 
                </th>
                <th scope="col" class="py-1 p-2">
                    Estado 
                </th>
            </thead>
            <tbody>
                @if($files)
                    @foreach ($files as $file)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-1 p-2">
                            <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                                <button type="button" class="btn btn-outline-primary mr-2 rounded" wire:click='editar("{{$file->id}}")'>Editar</button>
                                <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal" data-bs-target="#ModalEliminacion" wire:click='encontrar("{{$file->id}}")'>Eliminar</button>
                            </div>
                        </td>
                        <td class="py-1 p-2">{{$file->id}}</td>
                        <td class="py-1 p-2">{{$file->numeroFile}}</td>
                        <td class="py-1 p-2">{{$file->descripcion}}</td>
                        <td class="py-1 p-2">{{$file->tCliente->razonSocial}}</td>
                        <td class="py-1 p-2">{{$file->tArea->descripcion}}</td>
                        <td class="py-1 p-2">{{$file->totalPago}}</td>
                        <td class="py-1 p-2">{{$file->totalCobro}}</td>
                        <td class="py-1 p-2">{{$file->tEstado->descripcion}}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{-- Modal para Eliminar --}}
    @include('components.modaldelete')
</div>
