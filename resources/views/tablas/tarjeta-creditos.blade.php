
@extends('adminlte::page')

@section('title', 'Tarjetas de Credito')

@section('content_header')
    <h3>Tarjetas de Credito</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('tablas.tarjeta-creditos')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop