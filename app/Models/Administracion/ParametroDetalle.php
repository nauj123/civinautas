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
	
	public function getTiposDocumento(){
    	$deportes = ParametroDetalle::select(ParametroDetalle::raw("CONCAT(GROUP_CONCAT('<option value=\"', id_parametro_detalle, '\">', descripcion , '</option>' SEPARATOR '')) AS 'option'"))
    	->where([
    		['fk_parametro', 1],
    		['estado', 1]
    	])
    	->get();
    	return $deportes;
    }
    public function getroles(){
    	$deportes = ParametroDetalle::select(ParametroDetalle::raw("CONCAT(GROUP_CONCAT('<option value=\"', id_parametro_detalle, '\">', descripcion , '</option>' SEPARATOR '')) AS 'option'"))
    	->where([
    		['fk_parametro', 5],
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
  /*  public function getetnias(){
    	$deportes = ParametroDetalle::select(ParametroDetalle::raw("CONCAT(GROUP_CONCAT('<option value=\"', id_parametro_detalle, '\">', descripcion , '</option>' SEPARATOR '')) AS 'option'"))
    	->where([
    		['fk_parametro', 16],
    		['estado', 1]
    	])
    	->get();
    	return $deportes;
    } */
}
