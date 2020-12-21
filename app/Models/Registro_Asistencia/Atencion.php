<?php 

namespace App\Models\Registro_Asistencia; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Atencion extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_atenciones';
    public $timestamps = false;

    public function getListadoActividadesGrupo($id_grupo) {
        $sql = "SELECT 
        AC.Pk_Id_Atencion AS 'IDATENCION',
        CONCAT(PD.descripcion,' (',AC.DT_Fecha_Atencion,')') AS ACTIVIDAD
        FROM tb_atenciones AS AC 
        JOIN parametro_detalle AS PD ON AC.IN_Modalidad = PD.id_parametro_detalle AND PD.fk_parametro = 8
        WHERE FK_Id_Grupo = $id_grupo"; 
       $informacion = DB::select($sql);
       return $informacion;
      }
}
