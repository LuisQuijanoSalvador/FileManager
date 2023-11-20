<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\admin\IndexController;
use App\Http\Controllers\entidades\UsuarioController;
use App\Http\Livewire\Entidades\Usuarios;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::group(['prefix'=>'admin'],function(){
    Route::get('Inicio',[IndexController::class, 'index'])->name('inicio');
});
// Route::group(['prefix'=>'entidades'],function(){
    
// });

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix'=>'gestion'],function(){
        Route::get('boletos', function(){ return view('gestion.boletos');})->name('listaBoletos');
        Route::get('servicios', function(){ return view('gestion.servicios');})->name('listaServicios');
        Route::get('integrador', function(){ return view('gestion.integrador');})->name('integradorBoletos');
    });

    Route::group(['prefix'=>'entidades'],function(){
        Route::get('usuarios', function(){ return view('entidades.usuarios');})->name('listaUsuarios');
        Route::get('counters', function(){ return view('entidades.counters');})->name('listaCounters');
        Route::get('cobradores', function(){ return view('entidades.cobradors');})->name('listaCobradores');
        Route::get('vendedores', function(){ return view('entidades.vendedors');})->name('listaVendedores');
        Route::get('clientes', function(){ return view('entidades.clientes');})->name('listaClientes');
        Route::get('proveedores', function(){ return view('entidades.proveedors');})->name('listaProveedores');
        Route::get('solicitantes', function(){ return view('entidades.solicitantes');})->name('listaSolicitantes');
        Route::get('aerolineas', function(){ return view('entidades.aerolineas');})->name('listaAerolineas');
    });

    Route::group(['prefix'=>'tablas'],function(){
        Route::get('estados', function(){ return view('tablas.estados');})->name('listaEstados');
        Route::get('roles', function(){ return view('tablas.roles');})->name('listaRoles');
        Route::get('tipodocumentoidentidad', function(){ return view('tablas.tipo-documento-identidad');})->name('listaTipoDocIdentidad');
        Route::get('tipocliente', function(){ return view('tablas.tipo-clientes');})->name('listaTipoCLiente');
        Route::get('tipocambio', function(){ return view('tablas.tipo-cambios');})->name('listaTipoCambio');
        Route::get('tipodocumento', function(){ return view('tablas.tipo-documentos');})->name('listaTipoDocumento');
        Route::get('mediopago', function(){ return view('tablas.medio-pagos');})->name('listaMedioPago');
        Route::get('tipofacturacion', function(){ return view('tablas.tipo-facturacions');})->name('listaTipoFacturacion');
        Route::get('tipopasajero', function(){ return view('tablas.tipo-pasajeros');})->name('listaTipoPasajeros');
        Route::get('tiposervicio', function(){ return view('tablas.tipo-servicios');})->name('listaTipoServicios');
        Route::get('tarjetacredito', function(){ return view('tablas.tarjeta-creditos');})->name('listaTarjetaCreditos');
        Route::get('monedas', function(){ return view('tablas.monedas');})->name('listaMonedas');
        Route::get('areas', function(){ return view('tablas.areas');})->name('listaAreas');
        Route::get('correlativos', function(){ return view('tablas.correlativos');})->name('listaCorrelativos');
        Route::get('gds', function(){ return view('tablas.gdss');})->name('listaGds');
        Route::get('tipoTickets', function(){ return view('tablas.tipo-tickets');})->name('listaTipoTickets');
        Route::get('tipoPagos', function(){ return view('tablas.tipo-pagos');})->name('listaTipoPagos');
    });
});

