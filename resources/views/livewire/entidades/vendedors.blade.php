<div>
    {{-- Stop trying to control. --}}
    <div class="div-filtro">
        <input type="text" class="txtFiltro" wire:model="search" placeholder="Filtrar por Nombre">
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
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('nombre')">
                    Nombre 
                    @if ($sort == 'nombre')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('codigo')">
                    Codigo 
                    @if ($sort == 'codigo')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('comision')">
                    Comision 
                    @if ($sort == 'comision')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('comisionOver')">
                    Comision Over 
                    @if ($sort == 'comisionOver')
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
            @foreach ($vendedors as $vendedor)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">{{$vendedor->id}}</td>
                <td class="py-1">{{$vendedor->nombre}}</td>
                <td class="py-1">{{$vendedor->codigo}}</td>
                <td class="py-1">{{$vendedor->comision}}</td>
                <td class="py-1">{{$vendedor->comisionOver}}</td>
                <td class="py-1">{{$vendedor->tEstado->descripcion}}</td>
                <td class="py-1">
                    <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                        <button type="button" class="btn btn-outline-primary mr-2 rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click='editar("{{$vendedor->id}}")'>Editar</button>
                        <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal" data-bs-target="#ModalEliminacion" wire:click='encontrar("{{$vendedor->id}}")'>Eliminar</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$vendedors->links()}}

    {{-- Modal para Insertar y Actualizar --}}
    @include('components.modalheader')
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-3">
            <label for="txtNombres" class="form-label">Nombres:</label>
            <input type="text" class="form-control" id="txtNombres" wire:model.lazy="nombre" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('nombre')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtCodigo" class="form-label">Codigo:</label>
            <input type="text" class="form-control" id="txtCodigo" wire:model.lazy="codigo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="3">
            @error('codigo')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtComision" class="form-label">Comision:</label>
            <input type="number" class="form-control" id="txtComision" wire:model.lazy="comision" placeholder="">
            @error('comision')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtComisionOver" class="form-label">Comision Over:</label>
            <input type="number" class="form-control" id="txtComisionOver" wire:model.lazy="comisionOver" placeholder="">
            @error('comisionOver')
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
