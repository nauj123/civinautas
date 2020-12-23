<?php 

namespace App\Models\Gestion_Grupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Estudiantes extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_estudiantes';
    public $timestamps = false;

  /*  public function getEstudiantesGrupo($id_Grupo){
    	$sql = "SELECT
        EG.Fk_Id_Estudiante AS 'IDESTUDIANTE',
        ES.NRO_DOCUMENTO AS 'IDENTIFICACION',
        CONCAT(ES.NOMBRE1,' ',ES.NOMBRE2,' ',ES.APELLIDO1,' ',ES.APELLIDO2) AS 'ESTUDIANTE',
        ES.FECHA_NACIMIENTO AS 'FECHA',
        (CASE WHEN ES.GENERO = 'M' THEN 'MASCULINO' WHEN ES.GENERO = 'F' THEN 'FEMENINO' END) AS 'GENERO',
        EG.DT_Fecha_Ingreso AS 'FECHAINGRESO',
        (CASE WHEN EG.IN_Estado = '0' THEN 'INACTIVO' WHEN EG.IN_Estado = '1' THEN 'ACTIVO' END) AS 'ESTADO'
        FROM tb_estudiante_grupo AS EG
        JOIN tb_estudiante_simat AS ES ON EG.Fk_Id_Estudiante = ES.Pk_Id_Estudiante_Simat
        WHERE EG.Fk_Id_Grupo = $id_Grupo";
        $informacion = DB::select($sql);
        return $informacion;
    } */





}
