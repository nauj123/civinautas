<?php

namespace App\Http\Controllers\Caracterizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios\Users;
use App\Models\Usuarios\UsuarioRol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CaracterizacionController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct(){
		$this->middleware('auth');
	}
	public function index(){
		return view('Caracterizacion/caracterizacion');
	}


}
