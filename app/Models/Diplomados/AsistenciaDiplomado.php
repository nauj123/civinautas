<?php 

namespace App\Models\Diplomados;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AsistenciaDiplomado extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_asistencia_diplomado';
    public $timestamps = false;


    public function consultarAsistenciaDiplomado($id_estudiante,$id_sesion_clase) {
        $estado_asistencia = AsistenciaDiplomado::select(AsistenciaDiplomado::raw("IN_Asistencia"))
        ->where([
          ['Fk_Id_Participante', $id_estudiante],
          ['Fk_Id_Sesion_Diplomado', $id_sesion_clase]
        ])
        ->get();
        return $estado_asistencia;
    } 

}