<div class="modal fade" id="FormularioModal" wire:ignore.self tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" id="modalxl1">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">@if($idRegistro==0) Nuevo Registro @else Actualizar Registro @endif</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click='limpiarControles' aria-label="Close"></button>
        </div>
        <div class="modal-body">