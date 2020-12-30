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
        CONCAT_WS(' ', ES.VC_Primer_Nombre,ES.VC_Segundo_Nombre, ES.VC_Primer_Apellido,ES.VC_Segundo_Apellido) AS 'ESTUDIANTE',
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
        CONCAT_WS(' ', ES.VC_Primer_Nombre,ES.VC_Segundo_Nombre, ES.VC_Primer_Apellido,ES.VC_Segundo_Apellido) AS 'ESTUDIANTE'
        FROM tb_estudiante_grupo AS EG
        JOIN tb_grupos AS GR ON EG.Fk_Id_Grupo = GR.Pk_Id_Grupo
        JOIN tb_estudiantes AS ES ON EG.Fk_Id_Estudiante = ES.Pk_Id_Beneficiario
        WHERE EG.Pk_Id_Estudiante_Grupo = $id_estudiante"; 
       $informacion = DB::select($sql);
       return $informacion;
      } 


}
