@extends('adminlte::page')

@section('title', 'Facturación Acumulada')

@section('content_header')
    <h3>Facturación Acumulada - Servicios</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('gestion.facturacionservac')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('checkboxChanged', (rowId, isChecked) => {
                console.log('Checkbox changed:', rowId, isChecked);
                if (isChecked) {
                    Livewire.emit('filaSeleccionada', rowId);
                } else {
                    Livewire.emit('filaDeseleccionada', rowId);
                }
            });
        });
    </script>
@stop