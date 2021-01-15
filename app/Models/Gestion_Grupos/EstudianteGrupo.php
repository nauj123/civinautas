<?php 

namespace App\Models\Gestion_Grupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EstudianteGrupo extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_estudiante_grupo';
    public $timestamps = false;

    public function getEstudiantesGrupo($id_Grupo){
    	$sql = "SELECT
        EG.Pk_Id_Estudiante_Grupo AS 'IDESTUDIANTE',
        ES.IN_Identificacion AS 'IDENTIFICACION',
        CONCAT_WS(' ', ES.VC_Primer_Apellido,ES.VC_Segundo_Apellido,ES.VC_Primer_Nombre,ES.VC_Segundo_Nombre) AS 'ESTUDIANTE',
        ES.DD_F_Nacimiento AS 'FECHA',
        (CASE WHEN ES.IN_Genero = '1' THEN 'MASCULINO' WHEN ES.IN_Genero = '2' THEN 'FEMENINO' END) AS 'GENERO',
        EG.DT_Fecha_Ingreso AS 'FECHAINGRESO',
        EG.IN_Estado AS 'IDESTADO',
        (CASE WHEN EG.IN_Estado = '0' THEN 'INACTIVO' WHEN EG.IN_Estado = '1' THEN 'ACTIVO' END) AS 'ESTADO'
        FROM tb_estudiante_grupo AS EG
        JOIN tb_estudiantes AS ES ON EG.Fk_Id_Estudiante = ES.Pk_Id_Beneficiario
        WHERE EG.Fk_Id_Grupo = $id_Grupo ORDER BY ESTADO, ESTUDIANTE";
        $informacion = DB::select($sql);
        return $informacion;
    } 

    public function getEstadoEstudiante($id_estudiante) {
        $sql = "SELECT 
        EG.Pk_Id_Estudiante_Grupo AS 'IDESTUDIANTE',
        GR.VC_Nombre_Grupo AS 'GRUPO',
        CONCAT_WS(' ', ES.VC_Primer_Apellido,ES.VC_Segundo_Apellido,ES.VC_Primer_Nombre,ES.VC_Segundo_Nombre) AS 'ESTUDIANTE',
        FROM tb_estudiante_grupo AS EG
        JOIN tb_grupos AS GR ON EG.Fk_Id_Grupo = GR.Pk_Id_Grupo
        JOIN tb_estudiantes AS ES ON EG.Fk_Id_Estudiante = ES.Pk_Id_Beneficiario
        WHERE EG.Pk_Id_Estudiante_Grupo = $id_estudiante"; 
       $informacion = DB::select($sql);
       return $informacion;
      } 

      public function getEstudiantesGrupoAsistencia($id_Grupo){
    	$sql = "SELECT
        EG.Fk_Id_Estudiante AS 'IDESTUDIANTE',
        ES.IN_Identificacion AS 'IDENTIFICACION',
        CONCAT_WS(' ', ES.VC_Primer_Apellido,ES.VC_Segundo_Apellido,ES.VC_Primer_Nombre,ES.VC_Segundo_Nombre) AS 'ESTUDIANTE',
        (CASE WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 0 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 6 THEN 'Primera Infancia'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 7 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 13 THEN 'Infancia'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 14 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 17 THEN 'Adolescencia'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 18 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 26 THEN 'Juventud'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 27 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 59 THEN 'Adultez'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 60 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 100 THEN 'Adulto Mayor' END) AS 'FECHA',
        (CASE WHEN ES.IN_Genero = '1' THEN 'MASCULINO' WHEN ES.IN_Genero = '2' THEN 'FEMENINO' END) AS 'GENERO',
        EG.DT_Fecha_Ingreso AS 'FECHAINGRESO'
        FROM tb_estudiante_grupo AS EG
        JOIN tb_estudiantes AS ES ON EG.Fk_Id_Estudiante = ES.Pk_Id_Beneficiario
        WHERE EG.IN_Estado = '1' AND EG.Fk_Id_Grupo = $id_Grupo ORDER BY ESTUDIANTE";
        $informacion = DB::select($sql);
        return $informacion;
    } 

    public function getEncabezadoConsultaMensual() {
        $informacion = EstudianteGrupo::select(EstudianteGrupo::raw("Pk_Id_Atencion, DT_Fecha_Atencion"))
        ->where([
          ['Fk_Id_Grupo', 7]
        ])
        ->get();
        return $informacion;
    } 

    public function getEstudaintesGrupoConsulta($id_grupo){
		$informacion = EstudianteGrupo::select("Pk_Id_Beneficiario", "IN_Identificacion", "VC_Primer_Nombre", "VC_Segundo_Nombre", "VC_Primer_Apellido", "VC_Segundo_Apellido", "IN_Estado")
		->join("tb_estudiantes as es", "es.Pk_Id_Beneficiario", "=", "Fk_Id_Estudiante")
		->where([
			["Fk_Id_Grupo", $id_grupo]
    ])
    ->orderBy('VC_Primer_Apellido','desc')
		->get();
		return $informacion;
	}

}
