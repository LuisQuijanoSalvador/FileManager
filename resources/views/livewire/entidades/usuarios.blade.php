<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="div-filtro">
        <input type="text" class="txtFiltro" wire:model="search" placeholder="Filtrar por Nombre">
        <button type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal">Crear Usuario</button>
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
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('name')">
                    Nombre 
                    @if ($sort == 'name')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('email')">
                    Email 
                    @if ($sort == 'email')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('estado')">
                    Estado 
                    @if ($sort == 'estado')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 cursor-pointer" wire:click="order('rol')">
                    Rol 
                    @if ($sort == 'rol')
                        <i class="fas fa-sort float-right py-1 px-1"></i>
                    @endif
                </th>
                <th scope="col" class="py-1 thAccion">
                    Acción
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="py-1">{{$usuario->id}}</td>
                <td class="py-1">{{$usuario->name}}</td>
                <td class="py-1">{{$usuario->email}}</td>
                <td class="py-1">{{$usuario->estado}}</td>
                <td class="py-1">{{$usuario->rol}}</td>
                <td class="py-1">
                    <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                        <button type="button" class="btn btn-success mr-2 rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click='editar("{{$usuario->id}}")'>Editar</button>
                        <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal" data-bs-target="#ModalEliminacion" wire:click='encontrar("{{$usuario->id}}")'>Eliminar</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$usuarios->links()}}
    {{-- Modal para Insertar y Actualizar --}}
    @include('components.modalheader')
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-3">
            <label for="txtNombres" class="form-label">Nombres:</label>
            <input type="text" class="form-control" id="txtNombres" wire:model="name" placeholder="Nombres y Apellidos...">
            @error('name')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtEmail" class="form-label">Email:</label>
            <input type="email" class="form-control" id="txtEmail" wire:model.lazy="email" placeholder="nombre@ejemplo.com">
            @error('email')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtPassword" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="txtPassword" wire:model.lazy="password" placeholder="">
            @error('password')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtEstado" class="form-label">Estado:</label>
            <input type="text" class="form-control" id="txtEstado" wire:model.lazy="estado" placeholder="">
        </div>
        <div class="mb-3">
            <label for="txtRol" class="form-label">Rol:</label>
            <input type="text" class="form-control" id="txtRol" wire:model.lazy="rol" placeholder="">
        </div>
    @include('components.modalfooter')
    
    {{-- Modal para Eliminar --}}
    @include('components.modaldelete')

</div>



