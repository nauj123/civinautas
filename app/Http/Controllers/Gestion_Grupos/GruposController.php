<?php  

namespace App\Http\Controllers\Gestion_Grupos; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gestion_Grupos\Grupos;
use App\Models\Gestion_Grupos\Estudiantes;
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
		$grupos->Fk_Id_Sede = $request->sede;
		$grupos->VC_Nombre_Grupo = $request->nombre_grupo;
		$user_id = auth()->user()->id;
		$grupos->Fk_Id_Medidador = $user_id;
		$grupos->VC_Docente = $request->docente;
		$grupos->Fk_Id_Jornada = $request->jornada;
		$grupos->VC_Nivel_Escolaridad = $request->grado;
		$grupos->FK_Usuario_Registro = $user_id;
		$grupos->DT_Created_at = date("Y-m-d H:i:s");
		$grupos->IN_Estado = '1';
		if($grupos->save())

		$idgrupo = $grupos->id;
		$gruposnom = new Grupos;
		$array_update = [];
		$array_update["VC_Nombre_Grupo"] = $request->nombre_grupo.'-'.$idgrupo;
		$gruposnom->where('Pk_Id_Grupo', $idgrupo)
		->update($array_update);
		if($gruposnom){
			return 200;
		}
	}

	public function getOptionsGruposMediador(Request $request){
		$grupos = new Grupos;
		$id_mediador = auth()->user()->id;
		$resultado = $grupos->getOptionsGruposMediador($id_mediador);
		return response()->json($resultado[0]);
	}

	public function getBuscarEstudianteSimat(Request $request){
		$estudiante = new Grupos;
		$resultado = $estudiante->getBuscarEstudianteSimat($request->buscar, $request->id_Grupo);
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

	public function guardarNuevoEstudiante(Request $request){
		$estudiante = new Estudiantes;
		$estudiante->FK_Id_Tipo_Identificacion = $request->tipo_identificacion;
		$estudiante->IN_Identificacion = $request->identificacion;
		$estudiante->VC_Primer_Nombre = $request->primer_nombre;
		$estudiante->VC_Segundo_Nombre = $request->segundo_nombre;
		$estudiante->VC_Primer_Apellido = $request->primer_apellido;
		$estudiante->VC_Segundo_Apellido = $request->segundo_apellido;
		$estudiante->DD_F_Nacimiento = $request->f_nacimiento;
		$estudiante->IN_Genero = $request->genero;
		$estudiante->Fk_Id_Localidad = $request->localidad;
		$estudiante->VC_Direccion = $request->direccion;
		$estudiante->VC_Correo = $request->correo;
		$estudiante->VC_Celular = $request->celular;
		$estudiante->IN_Enfoque = $request->enfoque;
		$estudiante->IN_Estrato = $request->estrato;
		$user_id = auth()->user()->id;
		$estudiante->FK_Usuario_Registro = $user_id;
		$estudiante->DT_Created_at = date("Y-m-d H:i:s");
		if($estudiante->save())

		$idEstudianteGuardado = $estudiante->id;			
		$estudiantegrupo = new EstudianteGrupo;
		$estudiantegrupo->Fk_Id_Grupo = $request->id_grupo_agregar;
		$estudiantegrupo->Fk_Id_Estudiante = $idEstudianteGuardado;
		$estudiantegrupo->DT_Fecha_Ingreso = date("Y-m-d H:i:s");
		$user_id = auth()->user()->id;
		$estudiantegrupo->Fk_Usuario_Ingreso = $user_id;
		$estudiantegrupo->IN_Estado = '1';
		if($estudiantegrupo->save())		
		return 200;
	}

	public function getEstadoEstudiante(Request $request){
		$estudiante = new EstudianteGrupo;
		$resultado = $estudiante->getEstadoEstudiante($request->id_estudiante);
		return response()->json($resultado, 200);
	}

	public function InactivarEstudiante(Request $request){
		$estudiantegrupo = new EstudianteGrupo;
		$estudiante_id =  $request->id_estudiante;
		$array_update = [];
		$array_update["DT_Fecha_Retiro"] = date("Y-m-d H:i:s");
		$user_id = auth()->user()->id;
		$array_update["Fk_Usuario_Retiro"] = $user_id;
		$array_update["IN_Estado"] = 0;
		$array_update["VC_Observaciones"] = $request->observacion;
		$estudiantegrupo->where('Pk_Id_Estudiante_Grupo', $estudiante_id)
		->update($array_update);
		if($estudiantegrupo){
			return 200;
		}
	}

	public function ActivarEstudiante(Request $request){
		$estudiantegrupo = new EstudianteGrupo;
		$estudiante_id =  $request->id_estudiante;
		$array_update = [];
		$array_update["IN_Estado"] = 1;
		$estudiantegrupo->where('Pk_Id_Estudiante_Grupo', $estudiante_id)
		->update($array_update);
		if($estudiantegrupo){
			return 200;
		}
	}

	public function InactivarGrupo(Request $request){
		$grupo = new Grupos;
		$grupo_id =  $request->id_grupo;
		$array_update = [];
		$array_update["IN_Estado"] = 0;
		$user_id = auth()->user()->id;
		$Observaciones = 'Usuario: '.$user_id.'; Motivo Inactivación: '.$request->observacion.'; Fecha Inactivación: '.date("Y-m-d H:i:s");
		$array_update["VC_Observaciones"] = $Observaciones;
		$grupo->where('Pk_Id_Grupo', $grupo_id)
		->update($array_update);
		if($grupo){
			return 200;
		}
	}	

	public function getEstudiantesGrupoAsistencia(Request $request){
		$estudiante = new EstudianteGrupo;
		$resultado = $estudiante->getEstudiantesGrupoAsistencia($request->id_Grupo);
		return response()->json($resultado, 200);
	}

	public function getTotalGrupos(Request $request){
		$grupos = new Grupos;
		$id_mediador = auth()->user()->id;
		$resultado = $grupos->getTotalGrupos($id_mediador);
		return response()->json($resultado, 200);
	}
}
