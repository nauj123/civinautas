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
}
