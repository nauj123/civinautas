<?php

namespace App\Http\Controllers\Registro_Asistencia;

use App\Http\Controllers\Controller;
use App\Models\Registro_Asistencia\Atencion;
use App\Models\Registro_Asistencia\Asistencia;
use App\Models\Gestion_Grupos\EstudianteGrupo;
use App\Models\Gestion_Grupos\Grupos;
use Illuminate\Http\Request;
use stdClass;

class AsistenciaController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function index()
	{
		return view('Registro_Asistencia/asistencia');
	}

	public function guardarActividadAsistencia(Request $request)
	{
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

		if ($atencion->save())
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

	public function getListadoActividadesGrupo(Request $request)
	{
		$atencion = new Atencion;
		$resultado = $atencion->getListadoActividadesGrupo($request->id_grupo);
		return response()->json($resultado[0]);
	}

	public function getEncabezadoAtencion(Request $request)
	{
		$encabezadoatencion = new Atencion;
		$resultado = $encabezadoatencion->getEncabezadoAtencion($request->id_atencion);
		return response()->json($resultado, 200);
	}

	public function getAsistenciaAtencion(Request $request)
	{
		$estudiantegrupo = new Asistencia;
		$resultado = $estudiantegrupo->getAsistenciaAtencion($request->id_atencion);
		return response()->json($resultado, 200);
	}

	function consultarAsistenciasMensual(Request $request)
	{
		$id_grupo = intval($request->id_grupo);
		$id_mes = $request->id_mes;
		$mostrar = "";
		$grupo = new Grupos;
		$info_grupo = $grupo->getInfoGrupo($id_grupo);


		$atencion = new Atencion;
		$sesion_clase = $atencion->getEncabezadoConsultaMensual($id_grupo,$id_mes);

		$estudiantegrupo = new EstudianteGrupo;
		$estudiante = $estudiantegrupo->getEstudaintesGrupoConsulta($id_grupo);

		if($request->tipo_consulta == "pdf"){
			$info = array();
			$info["encabezado"] = $sesion_clase;
			$info["grupo"] = $info_grupo;
			$info["datos_asistencia"] = array();
			foreach ($estudiante as $clave => $e) {
				$info["datos_asistencia"][$clave] = array();
				$obj_estudiante = new stdClass;
				$obj_estudiante->identificacion = $e["IN_Identificacion"];
				$obj_estudiante->nombre = $e["VC_Primer_Apellido"]." ".$e["VC_Segundo_Apellido"]." ".$e["VC_Primer_Nombre"]." ".$e["VC_Segundo_Nombre"];
				$genero = $e["IN_Genero"] == 1 ? "MASCULINO" : "FEMENINO";
				$obj_estudiante->genero = $genero;
				array_push($info["datos_asistencia"][$clave], $obj_estudiante);
				foreach ($sesion_clase as $sc) {
					$info["datos_asistencia"][$clave][$sc["Pk_Id_Atencion"]] = array();
					$asistencia = new Asistencia;
					$estado_asistencia = $asistencia->consultarAsistenciaEstudianteAtencion($e['Pk_Id_Beneficiario'], $sc['Pk_Id_Atencion']);
					$obj_asistencia = new stdClass;
					$obj_asistencia->DT_Fecha_Atencion = $sc["DT_Fecha_Atencion"];
					$obj_asistencia->IN_Asistencia = empty($estado_asistencia) ? "SIN REGISTRO" : $estado_asistencia[0]->IN_Asistencia;
					$estado_asistencia = array();
					array_push($estado_asistencia, $obj_asistencia);
					array_push($info["datos_asistencia"][$clave][$sc["Pk_Id_Atencion"]], $estado_asistencia);
				}
			}
			return $info;
		}else{

			$mostrar = "<table class='display table table-striped table-bordered' id='table_asistencia' style='width: 100%;'>";
			$mostrar .= "<thead>";
			$mostrar .= "<th style='text-align: center;'> Identificación</th>";
			$mostrar .= "<th style='text-align: center;'> Nombre del Estudiante</th>";
			foreach ($sesion_clase as $sc) {
				$mostrar .= "<th style='text-align: center;'>" . $sc['DT_Fecha_Atencion'] . "</th>";
			}
			$mostrar .= "</thead>";
			$mostrar .= "<colgroup><col style='width: 10%; border:1px solid black;'>";
			$mostrar .= "<col style='width: 30%; border:1px solid black;'>";
			$ancho_columna_asistencia = 60 / sizeof($sesion_clase);
			foreach ($sesion_clase as $sc) {
				$mostrar .= "<col style='width: " . $ancho_columna_asistencia . "%; border:1px solid black;'>";
			}
			$mostrar .= "</colgroup>";
			$mostrar .= " <tbody>";

			foreach ($estudiante as $e) {
				$mostrar .= "<tr>";
				$mostrar .= "<td>" . $e['IN_Identificacion'] . "</td>";
				$mostrar .= "<td>" . $e['VC_Primer_Nombre'] . " " . $e['VC_Segundo_Nombre'] . " " . $e['VC_Primer_Apellido'] . " " . $e['VC_Segundo_Apellido'] . "</td>";
				foreach ($sesion_clase as $sc) {
					$asistencia = new Asistencia;
					$estado_asistencia = $asistencia->consultarAsistenciaEstudianteAtencion($e['Pk_Id_Beneficiario'], $sc['Pk_Id_Atencion']);
					if (empty($estado_asistencia)) {
						$mostrar .= "<td class='text-center'>";
						$mostrar .= '<strong><span>SIN REGISTRO</span></strong>';
						"</td>";
					} else {
						$estado_asistencia = $estado_asistencia[0];
						if ($estado_asistencia->IN_Asistencia == 1) {
							$mostrar .= "<td class='text-center' style='background-color: #A9DFBF'>";
							$mostrar .= '<strong><span>Asistió</span></strong>';
							"</td>";
						} else if ($estado_asistencia->IN_Asistencia == 0) {
							$mostrar .= "<td class='text-center' style='background-color: #F5B7B1'>";
							$mostrar .= '<strong><span>No Asistió</span></strong>';
							"</td>";
						}
					}
				}
				$mostrar .= "</tr>";
			}
			$mostrar .= "</tbody></table>";
			return $mostrar;
		}
	}
}
