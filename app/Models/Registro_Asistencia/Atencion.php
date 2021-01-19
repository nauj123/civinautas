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

    public function grupo(){
        return $this->belongsTo("App\Models\Gestion_Grupos\Grupos", "Fk_Id_Grupo", "Pk_Id_Grupo");
    }
    public function asistencias(){
        return $this->hasMany("App\Models\Registro_Asistencia\Asistencia", "Fk_Id_Atencion", "Pk_Id_Atencion");
    }

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
        (SELECT GROUP_CONCAT(CONCAT(' ',PDR.descripcion,' ') SEPARATOR ','  )
        FROM parametro_detalle PDR
        WHERE FIND_IN_SET(PDR.id_parametro_detalle, AC.IN_Recursos_Materiales) > 0)  AS 'RECURSOS',
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

    public function getEncabezadoConsultaMensual($id_grupo,$id_mes) {
        $informacion = Atencion::select(Atencion::raw("Pk_Id_Atencion, DATE_FORMAT(DT_Fecha_Atencion, '%d/%m/%Y') AS 'DT_Fecha_Atencion', IN_Tipo_Actividad, COALESCE(VC_Tematica, '') AS 'VC_Tematica'"))
        //->join("tb_tipo_actividad", "Fk_Id_Parametro", "=", "IN_Modalidad")
        ->where([
          ['Fk_Id_Grupo', $id_grupo],
          ['DT_Fecha_Atencion','like','%'.$id_mes.'%']
        ])
        ->orderBy("DT_Fecha_Atencion", "asc")
        ->get();
        return $informacion;
    } 



    
}