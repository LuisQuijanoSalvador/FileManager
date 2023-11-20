
@extends('adminlte::page')

@section('title', 'Solicitantes')

@section('content_header')
    <h3>Solicitantes</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('entidades.solicitantes')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop