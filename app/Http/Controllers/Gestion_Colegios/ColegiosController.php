<?php

namespace App\Http\Controllers\Gestion_Colegios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gestion_Colegios\Colegios;
use Illuminate\Support\Facades\Auth;

class ColegiosController extends Controller
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
		return view('Gestion_Colegios/colegios');
	}

	public function guardarNuevaInstitucion(Request $request){
		$instituciones = new Colegios;
		$instituciones->Fk_Tipo_Institucion = $request->tipo_institucion;
		$instituciones->Fk_Id_Localidad = $request->localidad;
		$instituciones->Fk_Id_Upz = $request->upz;
		$instituciones->VC_Nombre_Institucion = $request->nombre_colegio;
		$instituciones->VC_Codigo_Dane = $request->codigo_dane;
		$instituciones->VC_Iniciales = $request->iniciales_institucion;
		$instituciones->IN_Sedes = $request->sede;
		$user_id = auth()->user()->id;
		$instituciones->FK_Usuario_Registro = $user_id;
		$instituciones->DT_Created_at = date("Y-m-d H:i:s");
		$instituciones->IN_Estado = '1';
		if($instituciones->save())
			return 200;
	}
	public function getInstitucionesEducativas(Request $request){
		$usuario = new Colegios;
		$resultado = $usuario->getInstitucionesEducativas();
		return response()->json($resultado, 200);
	}
	public function getOptionsInstituciones(Request $request){
		$parametro = new Colegios;
		$resultado = $parametro->getOptionsInstituciones();
		return response()->json($resultado[0]);
	}


}
