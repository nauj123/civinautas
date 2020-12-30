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
 
    public function getDiplomadosMediador($id_Mediador){
    	$sql = "SELECT 
        DI.Pk_Id_Diplomado AS 'IDDIPLOMADO',
        DI.VC_Nombre_Diplomado AS 'NOMBRE',
        CONCAT(DI.DT_Fecha_Inicio,' hasta ',DI.DT_Fecha_fin) AS 'DURACION',
        DI.VC_Tematica AS 'TEMATICA',
        (CASE WHEN DI.IN_Estado = '1' THEN 'ACTIVO' WHEN DI.IN_Estado = '0' THEN 'CERRADO' END) AS 'ESTADO'
        FROM tb_diplomados AS DI 
        WHERE Fk_Mediador = $id_Mediador";
        $informacion = DB::select($sql);
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
