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

    public function tipoDocumento(){
        return $this->belongsTo("App\Models\Administracion\ParametroDetalle", "FK_Id_Tipo_Identificacion", "id_parametro_detalle");
    }
    public function enfoque(){
        return $this->belongsTo("App\Models\Administracion\ParametroDetalle", "IN_Enfoque", "id_parametro_detalle");
    }

    public function asistencias(){
        return $this->hasMany("App\Models\Registro_Asistencia\Asistencia", "Fk_Id_Atencion", "Pk_Id_Atencion");
    }
}
