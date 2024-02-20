<div>
    {{-- Stop trying to control. --}}
    <div class="row">
        <div class="col-md-3">
            <select name="selectedCliente" style="width: 100%; display:block;font-size: 0.9em; height:31px;" class="rounded" id="cboCliente" wire:model.lazy="idCliente">
                <option value="">-- Seleccionar Cliente --</option>
                @foreach ($clientes as $cliente)
                    <option value="{{$cliente->id}}">{{$cliente->razonSocial}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <p style="text-align:right">F. inicio:</p>
        </div>
        <div class="col-md-2">
            <input type="date" wire:model.lazy.defer="fechaInicio" id="fechaInicio">
        </div>
        <div class="col-md-1">
            <p style="text-align:right">F. Final:</p>
        </div>
        <div class="col-md-2">
            <input type="date" wire:model.lazy.defer="fechaFin" id="fechaFin">
        </div>
        <div class="col-md-2">
            <button @if(!$this->idCliente) disabled @endif type="button" class="btn btn-primary" wire:click="filtrar" >Filtrar</button>
        </div>
    </div>
    <hr>
    <div class="contenedorTablaCC">
        <table class="tabla-listado">
            <thead class="thead-listadoCC">
                <tr>
                    <th></th>
                    <th scope="col" class="py-1 p-2">
                        ID 
                    </th>
                    <th scope="col" class="py-1 p-2">
                        CLIENTE 
                    </th>
                    <th scope="col" class="py-1 p-2">
                        F. EMISION
                    </th>
                    <th scope="col" class="py-1 p-2">
                        CARGO
                    </th>
                    <th scope="col" class="py-1 p-2">
                        MONEDA
                    </th>
                    <th scope="col" class="py-1 p-2">
                        SALDO
                    </th>
                    <th scope="col" class="py-1 p-2">
                        T. CAMBIO
                    </th>
                    <th scope="col" class="py-1 p-2">
                        F. VENCIMIENTO
                    </th>
                    <th scope="col" class="py-1 p-2">
                        TIPO
                    </th>
                    <th scope="col" class="py-1 p-2">
                        SERIE
                    </th>
                    <th scope="col" class="py-1 p-2">
                        NUMERO
                    </th>
                    <th scope="col" class="py-1 p-2">
                        TIPO DOC.
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($this->cargos)
                    @foreach ($this->cargos as $cargo)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td><input type="checkbox" name="chkSelect" id="" wire:model.lazy.defer="selectedRows" value="{{ $cargo->id }}"></td>
                            <td class="py-1">{{$cargo->id}}</td>
                            <td class="py-1">{{$cargo->Cliente}}</td>
                            <td class="py-1">{{$cargo->FechaEmision}}</td>
                            <td class="py-1 cargo">{{$cargo->Cargo}}</td>
                            <td class="py-1">{{$cargo->Moneda}}</td>
                            <td class="py-1 saldo">{{$cargo->Saldo}}</td>
                            <td class="py-1">{{$cargo->TipoCambio}}</td>
                            <td class="py-1">{{$cargo->FechaVencimiento}}</td>
                            <td class="py-1">{{$cargo->TipoDocumento}}</td>
                            <td class="py-1">{{$cargo->SerieDocumento}}</td>
                            <td class="py-1">{{$cargo->NumeroDocumento}}</td>
                            <td class="py-1">{{$cargo->TipoDoc}}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    {{-- Modal --}}

    <!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click="abrirModal">
        Abonar
    </button> --}}
    <button type="button" class="btn btn-primary" wire:click="abrirPago">
        Abonar
    </button>
  
    <!-- Modal -->
    <div class="modal fade" id="FormularioModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Abono</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                         
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Abonar</button>
            </div>
        </div>
        </div>
    </div>
    <script>
        Livewire.on('tipoCambioUpdated', () => {
            // No hagas nada o realiza acciones necesarias para mantener el modal abierto
        });
    </script>
</div>
