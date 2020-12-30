<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios\Users;
use App\Models\Usuarios\UsuarioRol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
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
		return view('Reportes/reportes');
	}
	public function getReporteConsolidado(Request $request){
		$mes = $request->mes;
		$sql="SELECT
		ie.VC_Codigo_Dane AS 'CODIGO_DANE',
		ie.Fk_Id_Localidad AS 'NUMERO LOCALIDAD',
		l.VC_Nom_Localidad AS 'NOMBRE LOCALIDAD',
		ie.VC_Nombre_Institucion AS 'INSTITUCION EDUCATIVA',
		'SEDE' AS 'SEDE',
		pd.descripcion AS 'JORNADA',
		es.GRADO AS 'GRADO',
		es.APELLIDO1 AS 'PRIMER_APELLIDO',
		es.APELLIDO2 AS 'SEGUNDO_APELLIDO',
		es.NOMBRE1 AS 'PRIMER_NOMBRE',
		es.NOMBRE2 AS 'SEGUNDO_NOMBRE',
		es.TIPO_DOCUMENTO AS 'TIPO_IDENTIFICACION',
		es.NRO_DOCUMENTO AS 'NUM_DOC',
		'SIMAT' AS 'SIMAT',
		CASE
		WHEN es.GENERO='M' THEN 'MASCULINO'
		ELSE 'FEMENINO'
		END AS 'GENERO',
		DATE_FORMAT(es.FECHA_NACIMIENTO, '%d/%m/%Y') AS 'FECHA NACIMIENTO',
		es.ETNIA AS 'ETNIA',
		es.POB_VICT_CONF AS 'POBLACION_VICTIMA',
		es.TIPO_DISCAPACIDAD AS 'CONDICION_DISCAPACIDAD',
		ate.DT_Fecha_Atencion AS 'FECHA_IMPACTO',
		ate.TM_Hora_Inicio AS 'HORA_INICIAL',
		ate.TM_Hora_Fin AS 'HORA_FINAL',
		CASE
		WHEN asi.IN_Asistencia=1 THEN 'SI'
		ELSE 'NO'
		END AS 'ASISTENCIA_(SI/NO)',
		'CIUDADANÍA_Y_CONVIVENCIA' AS 'LINEA_PEDAGÓGICA',
		'CIUDADANÍA' AS 'CENTRO_INTERÉS',
		'CIVINAUTAS' AS 'ACTIVIDAD',
		'VIRTUAL' AS 'ESCENARIO',
		'' AS 'DETALLE ESCENARIO',
		'IDPC' AS 'ENTIDAD_ARCHIVO',
		'' AS 'CONVENIO',
		pdm.descripcion AS 'TIPO_DOCUMENTO_FORMADOR',
		u.identificacion AS 'NO_ DOCUMENTO_FORMADOR',
		g.VC_Nombre_Grupo AS 'GRUPO',
		'' AS 'NOVEDAD DE REPORTE'
		FROM tb_asistencia asi
		JOIN tb_estudiante_simat es ON es.Pk_Id_Estudiante_Simat=asi.Fk_Id_Estudiante
		JOIN tb_atenciones ate ON ate.Pk_Id_Atencion=asi.Fk_Id_Atencion
		JOIN tb_grupos g ON g.Pk_Id_Grupo=ate.Fk_Id_Grupo
		JOIN tb_instituciones_educativas ie ON	ie.Pk_Id_Institucion=g.Fk_Id_Institucion
		JOIN tb_localidades l ON l.Pk_Id_Localidad=ie.Fk_Id_Localidad
		JOIN parametro_detalle pd ON pd.id_parametro_detalle=g.Fk_Id_Jornada AND pd.fk_parametro=9
		JOIN users u ON u.id=g.Fk_Id_Medidador
		JOIN parametro_detalle pdm ON pdm.id_parametro_detalle=u.fk_tipo_documento AND pdm.fk_parametro=1
		WHERE ate.DT_Fecha_Atencion BETWEEN '2020-$mes-01' AND '2020-$mes-31'";
		$informacion = DB::select($sql);
		return $informacion;
	}
	function getConsolidadoCicloVital(Request $request){
		$mes = $request->mes;
		$sql="SELECT
		NOMBRE_INSTITUCION,
		LOCALIDAD,
		COALESCE(HOMBRES_0_6, 0) AS HOMBRES_0_6, 
		COALESCE(MUJERES_0_6, 0) AS MUJERES_0_6, 
		COALESCE(HOMBRES_7_13, 0) AS HOMBRES_7_13, 
		COALESCE(MUJERES_7_13, 0) AS MUJERES_7_13, 
		COALESCE(HOMBRES_14_17, 0) AS HOMBRES_14_17, 
		COALESCE(MUJERES_14_17, 0) AS MUJERES_14_17, 
		COALESCE(HOMBRES_18_26, 0) AS HOMBRES_18_26, 
		COALESCE(MUJERES_18_26, 0) AS MUJERES_18_26, 
		COALESCE(HOMBRES_27_59, 0) AS HOMBRES_27_59, 
		COALESCE(MUJERES_27_59, 0) AS MUJERES_27_59, 
		COALESCE(HOMBRES_60, 0) AS HOMBRES_60, 
		COALESCE(MUJERES_60, 0) AS MUJERES_60, 
		COALESCE(SUBTOTAL_HOMBRES, 0) AS SUBTOTAL_HOMBRES, 
		COALESCE(SUBTOTAL_MUJERES, 0) AS SUBTOTAL_MUJERES, 
		COALESCE(TOTAL, 0) AS TOTAL 
		FROM
		(SELECT
		ie.Pk_Id_Institucion AS ID_INSTITUCION,
		ie.VC_Nombre_Institucion AS NOMBRE_INSTITUCION,
		l.VC_Nom_Localidad AS LOCALIDAD
		FROM tb_instituciones_educativas ie 
		JOIN tb_localidades l ON l.Pk_Id_Localidad=ie.Fk_Id_Localidad
		WHERE ie.IN_Estado=1) AS PRIMERA LEFT JOIN
		(
		SELECT
		g.Fk_Id_Institucion,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 0 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 6 AND e.IN_Genero=1 THEN 1 END) AS HOMBRES_0_6,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 0 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 6 AND e.IN_Genero=2 THEN 1 END) AS MUJERES_0_6,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 7 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 13 AND e.IN_Genero=1 THEN 1 END) AS HOMBRES_7_13,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 7 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 13 AND e.IN_Genero=2 THEN 1 END) AS MUJERES_7_13,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 14 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 17 AND e.IN_Genero=1 THEN 1 END) AS HOMBRES_14_17,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 14 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 17 AND e.IN_Genero=2 THEN 1 END) AS MUJERES_14_17,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 18 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 26 AND e.IN_Genero=1 THEN 1 END) AS HOMBRES_18_26,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 18 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 26 AND e.IN_Genero=2 THEN 1 END) AS MUJERES_18_26,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 27 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 59 AND e.IN_Genero=1 THEN 1 END) AS HOMBRES_27_59,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 27 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 59 AND e.IN_Genero=2 THEN 1 END) AS MUJERES_27_59,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 60 AND e.IN_Genero=1 THEN 1 END) AS HOMBRES_60,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 60 AND e.IN_Genero=2 THEN 1 END) AS MUJERES_60,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 0 AND e.IN_Genero=1 THEN 1 END) AS SUBTOTAL_HOMBRES,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 0 AND e.IN_Genero=2 THEN 1 END) AS SUBTOTAL_MUJERES,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 0 THEN 1 END) AS TOTAL
		FROM tb_asistencia a
		JOIN tb_estudiantes e ON e.Pk_Id_Beneficiario=a.Fk_Id_Estudiante
		JOIN tb_atenciones ate ON ate.Pk_Id_Atencion=a.Fk_Id_Atencion
		JOIN tb_grupos g ON g.Pk_Id_Grupo=ate.Fk_Id_Grupo
		WHERE a.IN_Asistencia=1";
		if(isset($_POST["mes"])){
			$sql .= " AND MONTH(ate.DT_Fecha_Atencion)=$mes";
		}
		$sql .= " GROUP BY g.Fk_Id_Institucion) AS SEGUNDA ON PRIMERA.ID_INSTITUCION=SEGUNDA.Fk_Id_Institucion";
		$informacion = DB::select($sql);
		return $informacion;
	}
}
