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
    Route::get('listaUsuarios', function(){ return view('entidades.usuarios');})->name('listaUsuarios');

    Route::group(['prefix'=>'tablas'],function(){
        Route::get('estados', function(){ return view('tablas.estados');})->name('listaEstados');
        Route::get('roles', function(){ return view('tablas.roles');})->name('listaRoles');
        Route::get('tipodocumentoidentidad', function(){ return view('tablas.tipo-documento-identidad');})->name('listaTipoDocIdentidad');
        Route::get('tipocliente', function(){ return view('tablas.tipo-clientes');})->name('listaTipoCLiente');
        Route::get('tipocambio', function(){ return view('tablas.tipo-cambios');})->name('listaTipoCambio');
        Route::get('tipodocumento', function(){ return view('tablas.tipo-documentos');})->name('listaTipoDocumento');
        Route::get('mediopago', function(){ return view('tablas.medio-pagos');})->name('listaMedioPago');
        Route::get('tipofacturacion', function(){ return view('tablas.tipo-facturacions');})->name('listaTipoFacturacion');
    });
});

