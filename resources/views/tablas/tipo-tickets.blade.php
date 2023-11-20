
@extends('adminlte::page')

@section('title', 'Tipo Ticket')

@section('content_header')
    <h3>Tipo Ticket</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('tablas.tipo-tickets')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop