<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="div-filtro">
        <input type="text" class="txtFiltro" wire:model="search" placeholder="Filtrar por descripcion...">
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
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('descripcion')">
                    Descripcion 
                    @if ($sort == 'descripcion')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('codigo')">
                    Codigo 
                    @if ($sort == 'codigo')
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
            @foreach ($areas as $area)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">{{$area->id}}</td>
                <td class="py-1">{{$area->descripcion}}</td>
                <td class="py-1">{{$area->codigo}}</td>
                <td class="py-1">{{$area->tEstado->descripcion}}</td>
                <td class="py-1">
                    <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                        <button type="button" class="btn btn-outline-primary mr-2 rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click='editar("{{$area->id}}")'>Editar</button>
                        <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal" data-bs-target="#ModalEliminacion" wire:click='encontrar("{{$area->id}}")'>Eliminar</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$areas->links()}}

    {{-- Modal para Insertar y Actualizar --}}
    @include('components.modalheader')
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-3">
            <label for="txtDescripcion" class="form-label">Descripcion:</label>
            <input type="text" class="form-control" id="txtDescripcion" wire:model.lazy="descripcion" placeholder="Descripcion...">
            @error('descripcion')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtCodigo" class="form-label">Codigo</label>
            <input type="text" class="form-control" id="txtCodigo" wire:model.lazy="codigo">
            @error('codigo')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="cboEstados" class="form-label">Estado:</label>
            <select name="cboEstados" class="form-select" id="cboEstados" wire:model="estado">
                <option>==Seleccione una opción==</option>
                @foreach ($estados as $estado)
                    <option value={{$estado->id}}>{{$estado->descripcion}}</option>
                @endforeach
            </select>
        </div>
    @include('components.modalfooter')
    
    {{-- Modal para Eliminar --}}
    @include('components.modaldelete')
</div>
