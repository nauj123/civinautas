<?php

namespace App\Http\Controllers\Gestion_Colegios; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gestion_Colegios\Colegios;
use App\Models\Gestion_Colegios\Sedes_Colegio;
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
		$idInstitucion = $instituciones->id;  
		$sede = $request->sedes;

		foreach ($sede as $infosede) {
			$sedeinstitucion = new Sedes_Colegio;
			$sedeinstitucion->Fk_Id_Institucion = $idInstitucion;
			$sedeinstitucion->Fk_Id_Localidad = $infosede[0];
			$sedeinstitucion->Fk_Id_Upz = $infosede[1];
			$sedeinstitucion->VC_Nombre_Sede = $infosede[2];
			$sedeinstitucion->VC_Dane12 = $infosede[3];
			$sedeinstitucion->FK_Usuario_Registro = $user_id;
			$sedeinstitucion->DT_Created_at = date("Y-m-d H:i:s");
			$sedeinstitucion->IN_Estado = '1';
			$sedeinstitucion->save();
		}
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
	public function getInicialesIdLocalidad(Request $request){
		$iniciales = new Colegios;
		$resultado = $iniciales->getInicialesIdLocalidad($request->id_atencion);
		return response()->json($resultado, 200);
	}
	public function getInformacionInstitucion(Request $request){
		$colegio = new Colegios;
		$id_institucion =  $request->id_institucion;
		$resultado = $colegio->getInformacionInstitucion($id_institucion);
		return response()->json($resultado[0], 200);
	}

	public function actualizarInformacionInstitucion(Request $request){
		$colegio = new Colegios;
		$institucion_id =  $request->id_institucion_m;
		$array_update = [];
		$array_update["Fk_Tipo_Institucion"] = $request->tipo_institucion_m;
		$array_update["Fk_Id_Localidad"] = $request->localidad_m;
		$array_update["Fk_Id_Upz"] = $request->upz_m;
		$array_update["VC_Nombre_Institucion"] = $request->nombre_colegio_m;
		$array_update["VC_Codigo_Dane"] = $request->codigo_dane_m;
		$array_update["VC_Iniciales"] = $request->iniciales_institucion_m;
		$array_update["IN_Sedes"] = $request->sede_m;
		$colegio->where('Pk_Id_Institucion', $institucion_id)
		->update($array_update);
		if($colegio){
			return 200;
		}

		$sede = $request->sedes_m;
		foreach ($sede as $infosede) {
			$sedeinstitucion = new Sedes_Colegio;
			$sedeinstitucion->Fk_Id_Institucion = $institucion_id ;
			$sedeinstitucion->Fk_Id_Localidad = $infosede[0];
			$sedeinstitucion->Fk_Id_Upz = $infosede[1];
			$sedeinstitucion->VC_Nombre_Sede = $infosede[2];
			$sedeinstitucion->VC_Dane12 = $infosede[3];
			$user_id = auth()->user()->id;
			$sedeinstitucion->FK_Usuario_Registro = $user_id;
			$sedeinstitucion->DT_Created_at = date("Y-m-d H:i:s");
			$sedeinstitucion->IN_Estado = '1';
			$sedeinstitucion->save();
		}
		return 200;
	}



}
