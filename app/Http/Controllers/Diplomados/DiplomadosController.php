<?php 

namespace App\Http\Controllers\Diplomados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diplomados\Diplomados;
use App\Models\Diplomados\ParticipantesDiplomado;
use App\Models\Diplomados\AsistenciaDiplomado;
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
	public function guardarParticipantesDiplomado(Request $request){
		$participante = new ParticipantesDiplomado;

		$participante->Fk_Id_Diplomado = $request->id_diplomado;
		$participante->VC_Identificacion = $request->identificacion;
		$participante->VC_Nombres = $request->nombres;
		$participante->VC_Apellidos = $request->apellidos;
		$participante->VC_Correo = $request->correo;
		$participante->IN_Id_Entidad = $request->entidad;
		$participante->IN_Rol = $request->rol;
		$participante->Fk_Id_Localidad = $request->localidad;
		$participante->VC_Telefono = $request->telefono;
		$participante->FK_Id_Etnia = $request->etnia;
		$participante->Fk_Id_Social = $request->sector_social;
		$participante->DT_Created_at = date("Y-m-d H:i:s");
		$participante->FK_Usuario_Registro = auth()->user()->id;
		$participante->save();
		return $participante;
	}
	public function getInfoParticipantesDiplomado(Request $request){
		$informacion = ParticipantesDiplomado::select("Pk_Id_Participante AS IDPARTICIPANTE",
			"VC_Identificacion AS IDENTIFICACION",
			ParticipantesDiplomado::raw("CONCAT(VC_Nombres,' ',VC_Apellidos) AS NOMBRE"),
			"VC_Correo AS CORREO",
			"VC_Telefono AS TELEFONO")
		->where("Fk_Id_Diplomado", $request->id_diplomado)
		->get();
		return $informacion;
	}
	public function guardarAsistenciaDiplomado(Request $request){
		$datos = $request->array_datos_asistencia;
		foreach ($datos as $dato) {
			$asistencia = new AsistenciaDiplomado;
			$asistencia->Fk_Id_Diplomado = $dato[0];
			$asistencia->VC_Fecha_Asistencia = $dato[1];
			$asistencia->Fk_Id_Participante = $dato[2];
			$asistencia->IN_Asistencia = $dato[3];
			$asistencia->save();
		}
		return $asistencia;
	}
}
