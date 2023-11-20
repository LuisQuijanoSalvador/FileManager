<div>
    {{-- Do your work, then step back. --}}
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

    {{-- Modal para Insertar y Actualizar --}}
    @include('components.modalheader')
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-3">
            <label for="txtRazonSocial" class="form-label">Razon Social:</label>
            <input type="text" class="form-control" id="txtRazonSocial" wire:model.lazy="razonSocial" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('razonSocial')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtNombreComercial" class="form-label">Nombre Comercial:</label>
            <input type="text" class="form-control" id="txtNombreComercial" wire:model.lazy="nombreComercial" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('nombreComercial')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtSiglaIata" class="form-label">Sigla Iata:</label>
            <input type="text" class="form-control" id="txtSiglaIata" wire:model.lazy="siglaIata" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('siglaIata')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtCodigoIata" class="form-label">Código Iata:</label>
            <input type="text" class="form-control" id="txtCodigoIata" wire:model.lazy="codigoIata" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('codigoIata')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="txtRuc" class="form-label">RUC:</label>
            <input type="text" class="form-control" id="txtRuc" wire:model.lazy="ruc" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('ruc')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Logo:</label>
            <br>
            @if ($idRegistro==0)
                <input type="file" wire:model="logo" accept="image/*">
                <br><br>
                <div wire:loading wire:target="logo" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Subiendo Imagen...</span>
                </div>
                @if ($logo)
                    <img class="logoAerolinea" src="{{$logo->temporaryUrl()}}" alt="">
                @endif
                @error('logo')
                    <span class="error">{{$message}}</span>
                @enderror
            @else
                <img src="{{ asset($logo) }}" alt="logo">
            @endif
            
        </div>
        
        <div class="mb-3">
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
