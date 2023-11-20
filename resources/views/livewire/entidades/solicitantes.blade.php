<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="div-filtro">
        <input type="text" class="txtFiltro" wire:model="search" placeholder="Filtrar por Nombre">
        <div>
            <button type="button" class="btn btn-success" wire:click='exportar'>Exportar</button>
            <button type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal">Nuevo</button>
        </div>
        
    </div>
    <div class="tabla">
        <table class="tabla-listado">
            <thead class="thead-listado">
                <tr>
                    <th scope="col" class="py-1 cursor-pointer" wire:click="order('id')">
                        ID 
                        @if ($sort == 'id')
                            <i class="fas fa-sort float-right py-1 px-1"></i>
                        @endif
                    </th>
                    <th scope="col" class="py-1 cursor-pointer" wire:click="order('nombres')">
                        Nombres 
                        @if ($sort == 'nombres')
                            <i class="fas fa-sort float-right py-1 px-1"></i>
                        @endif
                    </th>
                    <th scope="col" class="py-1 cursor-pointer" wire:click="order('email')">
                        Email 
                        @if ($sort == 'email')
                            <i class="fas fa-sort float-right py-1 px-1"></i>
                        @endif
                    </th>
                    <th scope="col" class="py-1 cursor-pointer" wire:click="order('cliente')">
                        Cliente 
                        @if ($sort == 'cliente')
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
                @foreach ($solicitantes as $solicitante)
    
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="py-1">{{$solicitante->id}}</td>
                    <td class="py-1">{{$solicitante->nombres}}</td>
                    <td class="py-1">{{$solicitante->email}}</td>
                    <td class="py-1">{{$solicitante->tCliente->razonSocial}}</td>
                    <td class="py-1">{{$solicitante->tEstado->descripcion}}</td>
                    <td class="py-1">
                        <div class="btn-group text-end" role="group" aria-label="Botones de accion">
                            <button type="button" class="btn btn-outline-primary mr-2 rounded" data-bs-toggle="modal" data-bs-target="#FormularioModal" wire:click='editar("{{$solicitante->id}}")'>Editar</button>
                            <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal" data-bs-target="#ModalEliminacion" wire:click='encontrar("{{$solicitante->id}}")'>Eliminar</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{$solicitantes->links()}}

    {{-- Modal para Insertar y Actualizar --}}
    @include('components.modalheader')
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-6">
            <label for="txtNombres" class="form-label">Nombres:</label>
            <input type="text" class="form-control" id="txtNombres" wire:model.lazy="nombres" placeholder="Nombres y Apellidos..." style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('nombres')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-6">
            <label for="txtEmail" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="txtEmail" wire:model.lazy="email" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('email')
                <span class="error">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="txtCargo" class="form-label">Cargo</label>
            <input type="text" class="form-control" id="txtCargo" wire:model.lazy="cargo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('cargo')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="txtTelefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="txtTelefono" wire:model.lazy="telefono">
            @error('telefono')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="txtCelular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="txtCelular" wire:model.lazy="celular">
            @error('celular')
                <span class="error">{{$message}}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="cboClientes" class="form-label">Cliente:</label>
            <select name="cliente" class="form-select" id="cboClientes" wire:model="cliente">
                <option>==Seleccione una opción==</option>
                @foreach ($clientes as $cliente)
                    <option value={{$cliente->id}}>{{$cliente->razonSocial}}</option>
                @endforeach
            </select>
            @error('cliente')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-4">
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
    @include('components.modalfooter')
    
    {{-- Modal para Eliminar --}}
    @include('components.modaldelete')
</div>
