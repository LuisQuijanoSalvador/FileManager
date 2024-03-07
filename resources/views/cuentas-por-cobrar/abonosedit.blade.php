
@extends('adminlte::page')

@section('title', 'Abonos')

@section('content_header')
    <h3>Abonos</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('cuentas-por-cobrar.abonos')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop