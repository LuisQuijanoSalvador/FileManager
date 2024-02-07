@extends('adminlte::page')

@section('title', 'Files')

@section('content_header')
    <h3>Files</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('files.files')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop