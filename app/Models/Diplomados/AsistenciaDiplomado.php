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
        EG.Fk_Id_Estudiante AS 'IDESTUDIANTE',
        ES.IN_Identificacion AS 'IDENTIFICACION',
        CONCAT(ES.VC_Primer_Nombre,' ',ES.VC_Segundo_Nombre,' ',ES.VC_Primer_Apellido,' ',ES.VC_Segundo_Apellido) AS 'ESTUDIANTE',
        ES.DD_F_Nacimiento AS 'FECHA',
        (CASE WHEN ES.IN_Genero = '1' THEN 'MASCULINO' WHEN ES.IN_Genero = '2' THEN 'FEMENINO' END) AS 'GENERO',
        EG.DT_Fecha_Ingreso AS 'FECHAINGRESO',
        (CASE WHEN EG.IN_Estado = '0' THEN 'INACTIVO' WHEN EG.IN_Estado = '1' THEN 'ACTIVO' END) AS 'ESTADO'
        FROM tb_estudiante_grupo AS EG
        JOIN tb_estudiantes AS ES ON EG.Fk_Id_Estudiante = ES.Pk_Id_Beneficiario
        WHERE EG.Fk_Id_Grupo = $id_Grupo";
        $informacion = DB::select($sql);
        return $informacion;
    } 





}
