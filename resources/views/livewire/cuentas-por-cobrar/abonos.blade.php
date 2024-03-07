<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <hr>
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
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('siglaIata')">
                Siglas
                    @if ($sort == 'siglaIata')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('codigoIata')">
                    Código 
                    @if ($sort == 'codigoIata')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('ruc')">
                    Ruc 
                    @if ($sort == 'ruc')
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
            @foreach ($aerolineas as $aerolinea)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">{{$aerolinea->id}}</td>
                <td class="py-1">{{$aerolinea->razonSocial}}</td>
                <td class="py-1">{{$aerolinea->siglaIata}}</td>
                <td class="py-1">{{$aerolinea->codigoIata}}</td>
                <td class="py-1">{{$aerolinea->ruc}}</td>
                <td class="py-1">{{$aerolinea->tEstado->descripcion}}</td>
                <td class="py-1">
                    <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                        <button type="button" class="btn btn-outline-primary mr-2 rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click='editar("{{$aerolinea->id}}")'>Editar</button>
                        <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal" data-bs-target="#ModalEliminacion" wire:click='encontrar("{{$aerolinea->id}}")'>Eliminar</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$aerolineas->links()}}
</div>
