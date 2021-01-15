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

    public function atencion(){
        return $this->belongsTo("App\Models\Registro_Asistencia\Atencion", "Fk_Id_Atencion", "Pk_Id_Atencion");
    }

    public function getAsistenciaAtencion($id_atencion) {
        $sql = "SELECT 
        ES.Pk_Id_Beneficiario AS 'IDESTUDAINTE',
        ES.IN_Identificacion AS 'IDENTIFICACION',
        CONCAT_WS(' ', ES.VC_Primer_Apellido,ES.VC_Segundo_Apellido,ES.VC_Primer_Nombre,ES.VC_Segundo_Nombre) AS 'ESTUDIANTE',
        (CASE WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 0 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 6 THEN 'Primera Infancia'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 7 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 13 THEN 'Infancia'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 14 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 17 THEN 'Adolescencia'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 18 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 26 THEN 'Juventud'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 27 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 59 THEN 'Adultez'
        WHEN TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) >= 60 AND TIMESTAMPDIFF(YEAR,ES.DD_F_Nacimiento,CURDATE()) <= 100 THEN 'Adulto Mayor' END) AS 'FECHA',
        (CASE WHEN ES.IN_Genero = '1' THEN 'MASCULINO' WHEN ES.IN_Genero = '2' THEN 'FEMENINO' END) AS 'GENERO',
        (CASE WHEN NA.IN_Asistencia = '1' THEN 'ASISTIO' WHEN NA.IN_Asistencia = '0' THEN 'NO ASISTIO' END) AS 'ASISTENCIA'
        FROM tb_asistencia AS NA
        JOIN tb_estudiantes AS ES ON NA.Fk_Id_Estudiante = ES.Pk_Id_Beneficiario
        WHERE Fk_Id_Atencion = $id_atencion";
        $informacion = DB::select($sql);
        return $informacion;
    }

    public function consultarAsistenciaEstudianteAtencion($id_estudiante,$id_sesion_clase) {
        $estado_asistencia = Asistencia::select(Asistencia::raw("IN_Asistencia"))
        ->where([
          ['Fk_Id_Estudiante', $id_estudiante],
          ['Fk_Id_Atencion', $id_sesion_clase]
        ])
        ->get();
        return $estado_asistencia;
    } 


}