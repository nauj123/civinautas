<?php 

namespace App\Models\Reportes; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reportes extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    //protected $table = 'tb_grupos';
    //public $timestamps = false;

    public function getConsultaCompleta(){
    	$sql = "SELECT 
        TA.Fk_Id_Estudiante AS 'IDESTUDIANTE',
        LO.VC_Nom_Localidad AS 'LOCALIDAD',
        PDI.descripcion AS 'TIPO_INSTITUCION',
        IE.VC_Nombre_Institucion AS 'INSTITUCION',
        IE.VC_Codigo_Dane AS 'DANE',
        GR.VC_Nombre_Grupo AS 'NOMBRE_GRUPO',
        CONCAT_WS(' ',US.primer_nombre,US.segundo_nombre,US.primer_apellido) AS 'MEDIADOR',
        ATE.DT_Fecha_Atencion AS 'FECHA_ATENCION',
        CONCAT_WS(' hasta ', ATE.TM_Hora_Inicio,ATE.TM_Hora_Fin) AS 'HORARIO',
        PDM.descripcion AS 'MODALIDAD',
        TAC.VC_Nombre_Actividad AS 'TIPO_ACTIVIDAD',
        (SELECT GROUP_CONCAT(CONCAT(' ',PDR.descripcion,' ') SEPARATOR ','  )
        FROM parametro_detalle PDR
        WHERE FIND_IN_SET(PDR.id_parametro_detalle, ATE.IN_Recursos_Materiales) > 0)  AS 'RECURSOS',
        ES.IN_Identificacion AS 'IDENTIFICACION',
        CONCAT_WS(' ', ES.VC_Primer_Nombre,ES.VC_Segundo_Nombre) AS 'NOMBRES',
        CONCAT_WS(' ', ES.VC_Primer_Apellido,ES.VC_Segundo_Apellido) AS 'APELLIDOS',
        ES.VC_Direccion AS 'DIRECCION',
        ES.VC_Correo AS 'CORREO',
        ES.VC_Celular AS 'CELULAR',
        PDE.descripcion AS 'ENFOQUE',
        ES.IN_Estrato AS 'ESTRATO',
        ES.DD_F_Nacimiento AS 'FECHANACIMIENTO',
        (CASE WHEN ES.IN_Genero = '1' THEN 'MASCULINO' WHEN ES.IN_Genero = '2' THEN 'FEMENINO' END) AS 'GENERO',
        (CASE WHEN TA.IN_Asistencia = '0' THEN 'NO ASISTIO' WHEN TA.IN_Asistencia = '1' THEN 'ASISTIO' END) AS 'ASISTENCIA'
        FROM 	tb_asistencia AS TA
        JOIN tb_estudiantes AS ES ON TA.Fk_Id_Estudiante = ES.Pk_Id_Beneficiario
        LEFT JOIN parametro_detalle  AS PDE ON ES.IN_Enfoque = PDE.id_parametro_detalle
        JOIN tb_atenciones AS ATE ON TA.Fk_Id_Atencion =  ATE.Pk_Id_Atencion 
        JOIN tb_grupos AS GR ON ATE.Fk_Id_Grupo = GR.Pk_Id_Grupo
        JOIN users AS US ON ATE.Fk_Id_Mediador = US.id
        JOIN parametro_detalle AS PDM ON ATE.IN_Modalidad = PDM.id_parametro_detalle
        JOIN tb_tipo_actividad AS TAC ON ATE.IN_Tipo_Actividad = TAC.Pk_Id_Actividad
        JOIN tb_instituciones_educativas AS IE ON GR.Fk_Id_Institucion = IE.Pk_Id_Institucion
        JOIN tb_localidades AS LO ON IE.Fk_Id_Localidad = LO.Pk_Id_Localidad
        JOIN parametro_detalle AS PDI ON IE.Fk_Tipo_Institucion = PDI.id_parametro_detalle";
        $informacion = DB::select($sql);
        return $informacion;
    }



}
