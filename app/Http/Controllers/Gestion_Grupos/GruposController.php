<?php

namespace App\Http\Controllers\Gestion_Grupos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gestion_Grupos\Grupos;
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
}
