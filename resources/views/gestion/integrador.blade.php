@extends('adminlte::page')

@section('title', 'Integrador')

@section('content_header')
    <h3>Integrador</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('gestion.integrador')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    
@stop