
@extends('adminlte::page')

@section('title', 'Reporte - Boletos')

@section('content_header')
    <h3>Reporte - Boletos</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('reportes.reporte-alltech')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop