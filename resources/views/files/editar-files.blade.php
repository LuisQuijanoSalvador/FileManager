@extends('adminlte::page')

@section('title', 'Editar File')

@section('content_header')
    <h3>Editar File</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('files.editar-files')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop