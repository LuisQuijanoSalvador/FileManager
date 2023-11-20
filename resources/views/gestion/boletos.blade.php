
@extends('adminlte::page')

@section('title', 'Boletos')

@section('content_header')
    <h3>Boletos</h3>
@stop

{{-- Inicio del contenido de la Página --}}
@section('content')
    @livewire('gestion.boletos')
@stop

{{-- Fin del contenido de la Página --}}

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script> 
    console.log('Hi!'); 
    function valideKey(evt){
    
        // code is the decimal ASCII representation of the pressed key.
        var code = (evt.which) ? evt.which : evt.keyCode;
        
        if(code==8) { // backspace.
        return true;
        } else if(code>=48 && code<=57) { // is a number.
        return true;
        } else if(code==47){
            return true;
        }else{ // other keys.
        return false;
        }
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.js-example-basic-single').select2({
            placeholder: 'Select an option',
            // dropdownParent:'#FormularioModal'
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script>
        $('#cboCliente').select2({
            dropdownParent: $('#modalxl1')
        });
    </script> --}}
    <script>
        document.getElementById('txtNumeroTarjeta').addEventListener('input', function (event) {
            // Obtener el valor actual del campo
            let inputValue = event.target.value;
        
            // Eliminar todos los caracteres no numéricos del valor
            let numericValue = inputValue.replace(/\D/g, '');
        
            // Aplicar el formato de número de tarjeta (agregar espacios cada 4 dígitos)
            let formattedValue = numericValue.replace(/(\d{4})/g, '$1 ').trim();
        
            // Actualizar el valor del campo con el formato aplicado
            event.target.value = formattedValue;
        });
    </script>
    <script>
        document.getElementById('txtFechaVencimiento').addEventListener('input', function (event) {
            // Obtener el valor actual del campo
            let inputValue = event.target.value;
        
            // Eliminar todos los caracteres no numéricos del valor
            let numericValue = inputValue.replace(/\D/g, '');
        
            // Aplicar el formato de fecha de vencimiento (MM/YY)
            let formattedValue = numericValue.replace(/(\d{2})(\d{0,2})/, function(match, p1, p2) {
                return p2 ? p1 + '/' + p2 : p1;
            }).trim();
        
            // Actualizar el valor del campo con el formato aplicado
            event.target.value = formattedValue;
        });
    </script>
@stop