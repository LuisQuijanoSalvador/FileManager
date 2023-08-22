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
Route::get('listaUsuarios', function(){ return view('entidades.usuarios');})->name('listaUsuarios');