<?php 

namespace App\Models\Diplomados; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Diplomados extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_diplomados';
    public $timestamps = false;

    public function getDiplomadosMediador($id_mediador){
        $informacion = Diplomados::select("Pk_Id_Diplomado AS IDDIPLOMADO",
           "VC_Nombre_Diplomado AS NOMBRE", 
           "VC_Tematica AS TEMATICA",
           Diplomados::raw("CONCAT(DT_Fecha_Inicio,' hasta ',DT_Fecha_fin) AS 'DURACION'"),
           Diplomados::raw("(SELECT COUNT(Pk_Id_Participante) FROM tb_participantes_diplomado WHERE Fk_Id_Diplomado=Pk_Id_Diplomado) AS PARTICIPANTES"))
        ->where("Fk_Mediador", $id_mediador)
        ->get();
        return $informacion;
    }
    public function getOptionsDiplomadosMediador($id_mediador){
    	$diplomados = Diplomados::select(Diplomados::raw("CONCAT(GROUP_CONCAT('<option value=\"', Pk_Id_Diplomado, '\">', VC_Nombre_Diplomado , '</option>' SEPARATOR '')) AS 'option'"))
    	->where([
    		['Fk_Mediador', $id_mediador]
    	])
    	->get();
    	return $diplomados;
    }
}
