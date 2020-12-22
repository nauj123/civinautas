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

  /*  public function getListadoActividadesGrupo($id_grupo) {
        $sql = "SELECT 
        AC.Pk_Id_Atencion AS 'IDATENCION',
        CONCAT(PD.descripcion,' (',AC.DT_Fecha_Atencion,')') AS ACTIVIDAD
        FROM tb_atenciones AS AC 
        JOIN parametro_detalle AS PD ON AC.IN_Modalidad = PD.id_parametro_detalle AND PD.fk_parametro = 8
        WHERE FK_Id_Grupo = $id_grupo"; 
       $informacion = DB::select($sql);
       return $informacion;
      } */

    public function getListadoActividadesGrupo($id_grupo){
    	$informacion = Atencion::select(Atencion::raw("CONCAT(GROUP_CONCAT('<option value=\"', Pk_Id_Atencion, '\">', DT_Fecha_Atencion , '</option>' SEPARATOR '')) AS 'option'"))
    	->where([
    		['FK_Id_Grupo', $id_grupo]
    	])
    	->get();
    	return $informacion;
    }

    public function getEncabezadoAtencion($id_atencion) {
        $sql = "SELECT 
        AC.Pk_Id_Atencion AS 'IDATENCION',
        GR.VC_Nombre_Grupo AS 'GRUPO',
        CONCAT(US.primer_nombre,' ',US.segundo_nombre,' ',US.primer_apellido) AS 'MEDIADOR',
        AC.DT_Fecha_Atencion AS 'FECHA',
        CONCAT(AC.TM_Hora_Inicio,' A ',AC.TM_Hora_Fin) AS 'HORARIO',
        PDM.descripcion AS 'MODALIDAD',
        TA.VC_Nombre_Actividad AS 'ACTIVIDAD',
        PDR.descripcion AS 'RECURSOS',
        AC.VC_Tematica AS 'TEMATICA'
        FROM tb_atenciones AS AC 
        JOIN tb_grupos AS GR ON AC.Fk_Id_Grupo = GR.Pk_Id_Grupo
        JOIN users AS US ON AC.Fk_Id_Mediador = US.id
        JOIN parametro_detalle AS PDM ON AC.IN_Modalidad = PDM.id_parametro_detalle 
        JOIN parametro_detalle AS PDR ON AC.IN_Recursos_Materiales = PDR.id_parametro_detalle
        JOIN tb_tipo_actividad AS TA ON AC.IN_Tipo_Actividad = TA.Pk_Id_Actividad
        WHERE AC.Pk_Id_Atencion = $id_atencion"; 
       $informacion = DB::select($sql);
       return $informacion;
      } 
}