<?php

namespace App\Http\Controllers\Gestion_Grupos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gestion_Grupos\Grupos;
use App\Models\Gestion_Grupos\EstudianteGrupo;
use Illuminate\Support\Facades\Auth;

class GruposController extends Controller
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
		return view('Gestion_Grupos/grupos');
	}

	public function getGruposMediador(Request $request){
		$grupos = new Grupos;
		$id_mediador = auth()->user()->id;
		$resultado = $grupos->getGruposMediador($id_mediador);
		return response()->json($resultado, 200);
	}

	public function guardarNuevoGrupo(Request $request){
		$grupos = new Grupos;
		$grupos->Fk_Id_Institucion = $request->institucion;
		$grupos->VC_Nombre_Grupo = $request->nombre_grupo;
		$user_id = auth()->user()->id;
		$grupos->Fk_Id_Medidador = $user_id;
		$grupos->VC_Docente = $request->docente;
		$grupos->Fk_Id_Tipo_Atencion = $request->tipo_atencion;
		$grupos->Fk_Id_Jornada = $request->jornada;
		$grupos->FK_Usuario_Registro = $user_id;
		$grupos->DT_Created_at = date("Y-m-d H:i:s");
		$grupos->IN_Estado = '1';
		if($grupos->save())
			return 200;
	}
	public function getOptionsGruposMediador(Request $request){
		$grupos = new Grupos;
		$id_mediador = auth()->user()->id;
		$resultado = $grupos->getOptionsGruposMediador($id_mediador);
		return response()->json($resultado[0]);
	}

	public function getBuscarEstudianteSimat(Request $request){
		$estudiante = new Grupos;
		$resultado = $estudiante->getBuscarEstudianteSimat($request->buscar);
		return response()->json($resultado, 200);
	}

	public function getEstudiantesGrupo(Request $request){
		$estudiantegrupo = new EstudianteGrupo;
		$resultado = $estudiantegrupo->getEstudiantesGrupo($request->id_Grupo);
		return response()->json($resultado, 200);
	}
	
	public function agregarEstudianteGrupo(Request $request){
		$estudiantegrupo = new EstudianteGrupo;
		$estudiantegrupo->Fk_Id_Grupo = $request->grupo_mediador;
		$estudiantegrupo->Fk_Id_Estudiante = $request->id_estudiante;
		$estudiantegrupo->DT_Fecha_Ingreso = date("Y-m-d H:i:s");
		$user_id = auth()->user()->id;
		$estudiantegrupo->Fk_Usuario_Ingreso = $user_id;
		$estudiantegrupo->IN_Estado = '1';
		if($estudiantegrupo->save())
			return 200;
	}

	


}
