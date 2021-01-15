<?php 

namespace App\Http\Controllers\Diplomados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diplomados\Diplomados;
use App\Models\Diplomados\ParticipantesDiplomado;
use App\Models\Diplomados\SesionDiplomado;
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
		$sesion = new SesionDiplomado;
		$sesion->Fk_Id_Diplomado = $request->diplomado;
		$sesion->DT_Fecha_Sesion = $request->fecha;
		if ($sesion->save())
		$idSesionDiploma = $sesion->id;		
		$datos = $request->array_datos_asistencia;
		foreach ($datos as $dato) {
			$asistencia = new AsistenciaDiplomado;
			$asistencia->Fk_Id_Sesion_Diplomado = $idSesionDiploma;
			$asistencia->Fk_Id_Participante = $dato[0];
			$asistencia->IN_Asistencia = $dato[1];
			$asistencia->save();
		}
		return 200;
	}

	function consultarAsistenciaDiplomado(Request $request)
	{
		$id_diplomado = intval($request->id_diplomado);
		$sesion = new SesionDiplomado;
		$mostrar = "";
		$diplomado = $sesion->getEncabezadoConsultaDiplomado($id_diplomado);
		$mostrar = "<table class='display table table-striped table-bordered' id='table_asistencia' style='width: 100%;'>";
		$mostrar .= "<thead>";
		$mostrar .= "<th style='text-align: center;'> Identificación</th>";
		$mostrar .= "<th style='text-align: center;'> Nombre del Estudiante</th>";
		$mostrar .= "<th style='text-align: center;'> Correo Electrónico</th>";
		foreach ($diplomado as $sc) {
			$mostrar .= "<th style='text-align: center;'>" . explode("-", $sc['DT_Fecha_Sesion'])[2] . '/' . explode("-", $sc['DT_Fecha_Sesion'])[1] . '/' . explode("-", $sc['DT_Fecha_Sesion'])[0] . "</th>";
		}
		$mostrar .= "</thead>";
		$mostrar .= "<colgroup><col style='width: 10%; border:1px solid black;'>";
		$mostrar .= "<col style='width: 30%; border:1px solid black;'>";
		$ancho_columna_asistencia = 60 / sizeof($diplomado);
		foreach ($diplomado as $sc) {
			$mostrar .= "<col style='width: " . $ancho_columna_asistencia . "%; border:1px solid black;'>";
		}
		$mostrar .= "</colgroup>";
		$mostrar .= " <tbody>";

		$estudiantegrupo = new ParticipantesDiplomado;
		$estudiante = $estudiantegrupo->getParticipantesDiplomado($id_diplomado);

		foreach ($estudiante as $e) {
			$mostrar .= "<tr>";
			$mostrar .= "<td>" . $e['VC_Identificacion'] . "</td>";
			$mostrar .= "<td>" . $e['VC_Nombres'] . " " . $e['VC_Apellidos'] . "</td>";
			$mostrar .= "<td>" . $e['VC_Correo'] . "</td>";
			foreach ($diplomado as $sc) {
				$asistencia = new AsistenciaDiplomado;
				$estado_asistencia = $asistencia->consultarAsistenciaDiplomado($e['Pk_Id_Participante'], $sc['Pk_Id_Sesion_Diplomado']);
				if (empty($estado_asistencia["IN_Asistencia"])) {
					$estado_asistencia = $estado_asistencia[0];
					if ($estado_asistencia["IN_Asistencia"] == 1) {
						$mostrar .= "<td class='text-center' style='background-color: #A9DFBF'>";
						$mostrar .= '<strong><span>Asistió</span></strong>';
						"</td>";
					} else if ($estado_asistencia["IN_Asistencia"] == 0) {
						$mostrar .= "<td class='text-center' style='background-color: #F5B7B1'>";
						$mostrar .= '<strong><span>No Asistió</span></strong>';
						"</td>";
					}
				} else {
					$mostrar .= "<td class='text-center'><span>No registra</span></td>";
				}
			}
			$mostrar .= "</tr>";
		}
		$mostrar .= "</tbody></table>";
		return $mostrar;
	}

	public function getTotalDiplomados(){
		$diplomado = new Diplomados;
		$resultado = $diplomado->getTotalDiplomados();
		return response()->json($resultado, 200);
	}

	public function getInformacionDiplomado(Request $request){
		$diplomado = new Diplomados;
		$id_diplomado =  $request->id_diplomado;
		$resultado = $diplomado->getInformacionDiplomado($id_diplomado);
		return response()->json($resultado[0], 200);
	}

	public function actualizarInformacionDiplomado(Request $request){
		$diplomado = new Diplomados;
		$diplomado_id =  $request->id_diplomado_m;
		$array_update = [];
		$array_update["VC_Nombre_Diplomado"] = $request->nombre_m;
		$array_update["DT_Fecha_Inicio"] = $request->fecha_inicio_m;
		$array_update["DT_Fecha_fin"] = $request->fecha_fin_m;
		$array_update["VC_Tematica"] = $request->tematica_m;
		$diplomado->where('Pk_Id_Diplomado', $diplomado_id)
		->update($array_update);
		if($diplomado){
			return 200;
		}
	}

}
