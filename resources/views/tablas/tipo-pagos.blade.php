
@extends('adminlte::page')

@section('title', 'Tipo Pago')

@section('content_header')
    <h3>Tipo Pago</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('tablas.tipo-pagos')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop