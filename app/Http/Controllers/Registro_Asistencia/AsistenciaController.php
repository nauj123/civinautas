<?php

namespace App\Http\Controllers\Registro_Asistencia;

use App\Http\Controllers\Controller;
use App\Models\Registro_Asistencia\Atencion;
use App\Models\Registro_Asistencia\Asistencia;
use Illuminate\Http\Request;
use App\Models\Usuarios\Users;
use App\Models\Usuarios\UsuarioRol;


class AsistenciaController extends Controller
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
		return view('Registro_Asistencia/asistencia');
	}

	public function guardarActividadAsistencia(Request $request){
		$atencion = new Atencion;
		$atencion->Fk_Id_Grupo = $request->grupo;
		$user_id = auth()->user()->id;
		$atencion->Fk_Id_Mediador = $user_id;
		$atencion->DT_Fecha_Atencion = $request->fecha;
		$atencion->TM_Hora_Inicio = $request->inicio;
		$atencion->TM_Hora_Fin = $request->fin;
		$atencion->IN_Modalidad = $request->modalidad_actividad;
		$atencion->IN_Tipo_Actividad = $request->tipo_actividad;
		$atencion->IN_Recursos_Materiales = $request->recursos_materiales;
		$atencion->VC_Tematica = $request->tema;
		$atencion->DT_Fecha_Registro = date("Y-m-d H:i:s");
		$atencion->IN_Estado = '1';

		if($atencion->save())
		$idActividadGuardada = $atencion->id;  
		$estudiante = $request->estudiantes;

	  foreach ($estudiante as $asistencia) {
		  $estudiantegrupo = new Asistencia;
		  $estudiantegrupo->Fk_Id_Atencion = $idActividadGuardada;
		  $estudiantegrupo->Fk_Id_Estudiante = $asistencia[0];
		  $estudiantegrupo->IN_Asistencia = $asistencia[1];
		  $estudiantegrupo->save();
		   }
	  return 200; 
   } 
	
   public function getListadoActividadesGrupo(Request $request){
	$atencion = new Atencion;
	$resultado = $atencion->getListadoActividadesGrupo($request->id_grupo);
	return response()->json($resultado[0]);
	}

	public function getEncabezadoAtencion(Request $request){
		$encabezadoatencion = new Atencion;
		$resultado = $encabezadoatencion->getEncabezadoAtencion($request->id_atencion);
		return response()->json($resultado, 200);
	}

	public function getAsistenciaAtencion(Request $request){
		$estudiantegrupo = new Asistencia;
		$resultado = $estudiantegrupo->getAsistenciaAtencion($request->id_atencion);
		return response()->json($resultado, 200);
	}

}
