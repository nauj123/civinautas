<?php 

namespace App\Models\Registro_Asistencia; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asistencia extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_asistencia';
    public $timestamps = false;

    public function getAsistenciaAtencion($id_atencion) {
        $sql = "SELECT 
        ES.Pk_Id_Estudiante_Simat AS 'IDESTUDAINTE',
        ES.NRO_DOCUMENTO AS 'IDENTIFICACION',
        CONCAT(ES.NOMBRE1,' ',ES.NOMBRE2,' ',ES.APELLIDO1,' ',ES.APELLIDO2) AS 'ESTUDIANTE',
        ES.FECHA_NACIMIENTO AS 'FECHA',
        (CASE WHEN ES.GENERO = 'M' THEN 'MASCULINO' WHEN ES.GENERO = '0' THEN 'FEMENINO' END) AS 'GENERO',
        (CASE WHEN NA.IN_Asistencia = '1' THEN 'ASISTIO' WHEN NA.IN_Asistencia = '0' THEN 'NO ASISTIO' END) AS 'ASISTENCIA'
        FROM tb_asistencia AS NA
        JOIN tb_estudiante_simat AS ES ON NA.Fk_Id_Estudiante = ES.Pk_Id_Estudiante_Simat
        WHERE Fk_Id_Atencion = $id_atencion"; 
       $informacion = DB::select($sql);
       return $informacion;
      } 




}
