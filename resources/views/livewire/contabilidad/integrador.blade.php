<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
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
    <hr>
    <label for="">Seleccione tipo de Documento:</label>
    <div class="row">
        <div class="col-md-2">
            <input type="radio" id="radFactura" name="radtipoDoc" value="01" wire:model="tipoDocumento">
            <label for="radFactura">Factura</label><br>
        </div>
        <div class="col-md-2">
            <input type="radio" id="radBoleta" name="radtipoDoc" value="03" wire:model="tipoDocumento">
            <label for="radBoleta">Boleta</label><br>
        </div>
        <div class="col-md-2">
            <input type="radio" id="radNc" name="radtipoDoc" value="07" wire:model="tipoDocumento">
            <label for="radNc">Nota de Credito</label>
        </div>
        <div class="col-md-2">
            <input type="radio" id="radNd" name="radtipoDoc" value="08" wire:model="tipoDocumento">
            <label for="radNd">Nota Debito</label><br>
        </div>
        <div class="col-md-2">
            <input type="radio" id="radDocCobranza" name="radtipoDoc" value="36" wire:model="tipoDocumento">
            <label for="radDocCobranza">Doc. Cobranza</label>
        </div>
        <div class="col-md-2">
            <input type="radio" id="radAbono" name="radtipoDoc" value="21" wire:model="tipoDocumento">
            <label for="radAbono">Abono</label>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-2">
            <label for="txtNombreComercial" class="form-label">Correlativo:</label>
            <input type="number" class="form-control" id="txtCorrelativo" wire:model.lazy="correlativo">
        </div>
        <div class="col-md-3">
            <label for="fechaIni" class="form-label">Fecha Inicial:</label>
            <input type="date" class="form-control" wire:model.lazy.defer="fechaIni" id="fechaIni">
        </div>
        <div class="col-md-3">
            <label for="fechaFin" class="form-label">Fecha Final:</label>
            <input type="date" class="form-control" wire:model.lazy.defer="fechaFin" id="fechaFin">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-2"></div>
        <div class="col-md-2"></div>
        <div class="col-md-2"></div>
        <div class="col-md-2"></div>
        <div class="col-md-2">
            <button type="button" class="btn btn-primary" wire:click="generarArchivo" >Generar Archivo</button>
        </div>
    </div>
</div>
