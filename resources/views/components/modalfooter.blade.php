</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='limpiarControles'>Cancelar</button>
  <button type="button" class="btn btn-primary"  @if($idRegistro==0) wire:click='grabar' @else wire:click='actualizar("{{$idRegistro}}")' @endif>Guardar</button>
</div>
</div>
</div>
</div>