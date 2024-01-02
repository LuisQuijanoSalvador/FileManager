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
                <th scope="col" class="py-1 ">
                    Acción
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentos as $documento)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">{{$documento->id}}</td>
                <td class="py-1">{{$documento->numero}}</td>
                <td class="py-1">{{$documento->tcliente->razonSocial}}</td>
                <td class="py-1">{{$documento->fechaEmision}}</td>
                <td class="py-1">{{$documento->total}}</td>
                <td class="py-1">{{$documento->tEstado->descripcion}}</td>
                <td class="py-1">
                    <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                        <button type="button" class="btn btn-outline-primary mr-2 rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click='editar("{{$documento->id}}")'>Ver</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$documentos->links()}}
</div>
