<?php 

namespace App\Http\Controllers\Diplomados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diplomados\Diplomados;
//use App\Models\Gestion_Grupos\Estudiantes;
//use App\Models\Gestion_Grupos\EstudianteGrupo;
use Illuminate\Support\Facades\Auth;

class DiplomadosController extends Controller
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
		return view('Diplomados/diplomados');
	}

	public function guardarNuevoDiplomado(Request $request){
		$diplomado = new Diplomados;
		$diplomado->VC_Nombre_Diplomado = $request->nombre_diplomado;
		$diplomado->DT_Fecha_Inicio = $request->fecha_inicio;
		$diplomado->DT_Fecha_fin = $request->fecha_fin;
		$diplomado->VC_Tematica = $request->tematica;
		$user_id = auth()->user()->id;
		$diplomado->Fk_Mediador = $user_id;
		$diplomado->DT_Created_at = date("Y-m-d H:i:s");
		$diplomado->IN_Estado = '1';
		if($diplomado->save())
			return 200;
	}
	public function getDiplomadosMediador(Request $request){
		$diplomado = new Diplomados;
		$id_mediador = auth()->user()->id;
		$resultado = $diplomado->getDiplomadosMediador($id_mediador);
		return response()->json($resultado, 200);
	}
	public function getOptionsDiplomadosMediador(Request $request){
		$diplomado = new Diplomados;
		$id_mediador = auth()->user()->id;
		$resultado = $diplomado->getOptionsDiplomadosMediador($id_mediador);
		return response()->json($resultado[0]);
	}


/*	



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
	}  */


}
