<?php

namespace App\Http\Controllers\Administracion; 

use App\Http\Controllers\Controller;
use App\Models\Administracion\DisciplinaDeportiva;
use Illuminate\Http\Request;
use App\Models\Administracion\ParametroDetalle;
use Illuminate\Support\Facades\DB;

class ParametrosController extends Controller
{
	public function index(){
		return view('administracion/administracion_parametros');
	}
	public function getTiposDocumento(Request $request){
		$parametro = new ParametroDetalle;
		$resultado = $parametro->getTiposDocumento();
		return response()->json($resultado[0]);
	}
	public function getroles(Request $request){
		$parametro = new ParametroDetalle;
		$resultado = $parametro->getroles();
		return response()->json($resultado[0]);
	}
	public function getParametros(Request $request){
		$parametro = new ParametroDetalle;
		$resultado = $parametro->getParametros();
		return response()->json($resultado[0]);
	}
	public function getParametroAsociados(Request $request){
		$parametro = new ParametroDetalle;
		$resultado = $parametro->getParametroAsociados($request->id_parametro);
		return response()->json(json_decode($resultado), 200);
	}
	public function modificarParametroAsociado(Request $request){
		$parametro = new ParametroDetalle;
		$parametro->where('id_parametro_detalle', $request->id_parametro_asociado)->update(array('descripcion' => $request->descripcion_parametro_asociado, 'estado' => $request->estado_parametro_asociado));
		return $parametro;
	}
	public function guardarNuevoParametroAsociado(Request $request){
		$parametro_asociado = new ParametroDetalle;
		$parametro_asociado->fk_parametro = $request->id_parametro;
		$parametro_asociado->descripcion = $request->nuevo_parametro_asociado;
		$parametro_asociado->estado = 1;
		if($parametro_asociado->save()){
			return 200;
		}
	}
	public function getOptionsParametro(Request $request){
		$parametro = new ParametroDetalle;
		$resultado = $parametro->getOptionsParametro($request->id_parametro);
		return response()->json($resultado[0]);
	}
	/*public function getetnias(Request $request){
		$parametro = new ParametroDetalle;
		$resultado = $parametro->getetnias();
		return response()->json($resultado[0]);
	}*/	
}
