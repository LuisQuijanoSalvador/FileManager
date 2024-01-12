<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="contenedorFiltro">
        <div class="row">
            <div class="col-md-4">
                <label for="selectedCliente">Seleccione Cliente:</label>
                <select name="selectedCliente" style="width: 100%; display:block;font-size: 0.9em; height:31px;" class="rounded" id="cboCliente" wire:model="idCliente">
                    <option value="">-- Buscar Cliente --</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{$cliente->id}}">{{$cliente->razonSocial}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="txtFechaInicio">Fecha Inicial:</label>
                <input type="date" class="rounded" style="width: 100%; display:block;font-size: 0.8em;font-size: 0.8em; height:31px;" id="txtFechaInicio" wire:model="fechaInicio">
            </div>
            <div class="col-md-3">
                <label for="txtFechaFinal">Fecha Final:</label>
                <input type="date" class="rounded" style="width: 100%; display:block;font-size: 0.8em;font-size: 0.8em; height:31px;" id="txtFechaFinal" wire:model="fechaFinal">
            </div>
            <div class="col-md-2">
                <br>
                <button type="button" class="btn btn-primary rounded" wire:click='buscar'>Buscar</button>
            </div>
        </div>
    </div>
</div>
