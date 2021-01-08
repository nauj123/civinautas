<?php

namespace App\Http\Controllers\Caracterizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios\Users;
use App\Models\Usuarios\UsuarioRol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CaracterizacionRepository;
use App\Models\Reportes\Reportes;

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

	public function getInfoColegiosEstudiantes(Request $request){
		$reporte = new Reportes;
		$resultado = $reporte->getInfoColegiosEstudiantes($request->id_localidad);
		return response()->json($resultado, 200);
	}
	public function getInfoGruposEstudiantes(Request $request){
		$reporte = new Reportes;
		$resultado = $reporte->getInfoGruposEstudiantes($request->id_colegio);
		return response()->json($resultado, 200);
	}
	public function getInfoEstudiantes(Request $request){
		$reporte = new Reportes;
		$resultado = $reporte->getInfoEstudiantes($request->id_grupo);
		return response()->json($resultado, 200);
	}
	public function getInfoEstudiante(Request $request){
		$reporte = new Reportes;
		$resultado = $reporte->getInfoEstudiante($request->id_estudiante);
		return response()->json($resultado, 200);
	}
}
