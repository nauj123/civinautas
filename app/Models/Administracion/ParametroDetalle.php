<?php 

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ParametroDetalle extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'parametro_detalle';
    public $timestamps = false;
    
    public function getOptionsParametro($id_parametro){
    	$deportes = ParametroDetalle::select(ParametroDetalle::raw("CONCAT(GROUP_CONCAT('<option value=\"', id_parametro_detalle, '\">', descripcion , '</option>' SEPARATOR '')) AS 'option'"))
    	->where([
    		['fk_parametro', $id_parametro],
    		['estado', 1]
    	])
    	->get();
    	return $deportes;
    }
    public function getParametros(){
        $parametros = DB::table('parametro')
        ->select(DB::raw("CONCAT(GROUP_CONCAT('<option value=\"', id_parametro, '\">', nombre, '</option>' SEPARATOR '')) AS 'option'"))
        ->get();
        return $parametros;
    }
    public function getParametroAsociados($id_parametro){
        $categorias = ParametroDetalle::select("id_parametro_detalle", "descripcion", "estado")
        ->where('fk_parametro', $id_parametro)
        ->get();
        return $categorias;
    }
    public function getLocalidades(){
    	$localidades = DB::table('tb_localidades')
    	->select(DB::raw("CONCAT(GROUP_CONCAT('<option value=\"', Pk_Id_Localidad, '\">', VC_Nom_Localidad , '</option>' SEPARATOR '')) AS 'option'"))
    	->get();
    	return $localidades;
    }
    public function getUpz($id_localidad){
    	$municipios = DB::table('tb_upz')
    	->select(DB::raw("CONCAT(GROUP_CONCAT('<option value=\"', Pk_Id_Upz, '\">', VC_Nombre_Upz , '</option>' SEPARATOR '')) AS 'option'"))
    	->where('FK_Id_Localidad', $id_localidad)
    	->get();
    	return $municipios;
    }
    public function getMeses(){
        $sql = "SELECT
        '<option value=\"01\">Enero</option>
        <option value=\"02\">Febrero </option>
        <option value=\"03\">Marzo</option>
        <option value=\"04\">Abril</option>
        <option value=\"05\">Mayo</option>
        <option value=\"06\">Junio</option>
        <option value=\"07\">Julio</option>
        <option value=\"08\">Agosto</option>
        <option value=\"09\">Septiembre</option>
        <option value=\"10\">Octubre</option>
        <option value=\"11\">Noviembre</option>
        <option value=\"12\">Diciembre</option>' AS 'option'";
        $informacion = DB::select($sql);
        return $informacion;
    }

}
