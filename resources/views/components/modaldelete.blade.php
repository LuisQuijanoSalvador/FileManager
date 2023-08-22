<div class="modal fade" id="ModalEliminacion" wire:ignore.self tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación de Eliminacion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="divConfirmacion">
                    <div class="divDeleteText">
                        <p class="textoConfirmacion">
                            Se va eliminar el registro con ID: {{$idRegistro}}
                        </p>
                        <p class="textoConfirmacion">
                            No podrá recuperar el registro eliminado
                        </p>
                    </div>
                    <div class="divIconWarning">
                        <img src="{{asset('img/warning.png')}}" alt="">
                    </div>
                    
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='limpiarControles'>Cancelar</button>
                {{-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @if($idUsuario==0) wire:click='grabar' @else wire:click='actualizar("{{$idUsuario}}")' @endif>Aceptar</button> --}}
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"  wire:click='eliminar("{{$idRegistro}}")'>Aceptar</button>
            </div>
        </div>
    </div>
</div>