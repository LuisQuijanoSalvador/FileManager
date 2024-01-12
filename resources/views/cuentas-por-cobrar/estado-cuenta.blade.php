
@extends('adminlte::page')

@section('title', 'Estado de Cuenta')

@section('content_header')
    <h3>Estado de Cuenta</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('cuentas-por-cobrar.estado-cuenta')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop