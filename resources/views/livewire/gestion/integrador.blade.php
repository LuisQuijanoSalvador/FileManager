<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    <div class="row">
        <div class="col-md-3">
            <label for="cboCounter" class="form-label">Counter:</label>
            <select name="idCounter" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboCounter" wire:model="idCounter">
                @foreach ($counters as $counter)
                    <option value={{$counter->id}}>{{$counter->nombre}}</option>
                @endforeach
            </select>
            @error('idCounter')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="">GDS:</label>
            <div class="row">
                <div class="col-md-3">
                    <input type="radio" id="radSabre" name="radGds" value="sabre" wire:model="selectedGds">
                    <label for="radSabre">Sabre</label><br>
                </div>
                <div class="col-md-3">
                    <input type="radio" id="radKiu" name="radGds" value="kiu" wire:model="selectedGds">
                    <label for="radKiu">Kiu</label><br>
                </div>
                <div class="col-md-3">
                    <input type="radio" id="radNdc" name="radGds" value="ndc" wire:model="selectedGds">
                    <label for="radNdc">NDC</label>
                </div>
            </div>    
        </div>
        <div class="col-md-2">
            <label for="cboCounter" class="form-label">Area:</label>
            <select name="idArea" style="width: 100%; display:block;font-size: 0.8em;" class="" id="cboArea" wire:model="idArea">
                @foreach ($areas as $area)
                    <option value={{$area->id}}>{{$area->descripcion}}</option>
                @endforeach
            </select>
            @error('idArea')
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <br>
            <button id="btnIntegrar" type="button" class="btn btn-primary rounded" wire:click='obtenerBoleto'>Integrar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <textarea class="txtIntegradorBoleto" name="txtBoleto" id="txtBoleto" wire:model.lazy="boleto">

            </textarea>
        </div>
    </div>
</div>
