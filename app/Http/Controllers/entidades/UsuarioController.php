<?php

namespace App\Http\Controllers\entidades;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(){
        return view('entidades.usuario.index');
    }
}
