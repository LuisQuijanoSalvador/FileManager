
@extends('adminlte::page')

@section('title', 'Tipo Pasajero')

@section('content_header')
    <h3>Tipo Pasajero</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('tablas.tipo-pasajeros')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop