<?php 

namespace App\Http\Controllers\Diplomados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diplomados\Diplomados;
use App\Models\Diplomados\ParticipantesDiplomado;
//use App\Models\Gestion_Grupos\EstudianteGrupo;
use Illuminate\Support\Facades\Auth;

class DiplomadosController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct(){
		$this->middleware('auth');
	}
	public function index(){
		return view('Diplomados/diplomados');
	}

	public function guardarNuevoDiplomado(Request $request){
		$diplomado = new Diplomados;
		$diplomado->VC_Nombre_Diplomado = $request->nombre_diplomado;
		$diplomado->DT_Fecha_Inicio = $request->fecha_inicio;
		$diplomado->DT_Fecha_fin = $request->fecha_fin;
		$diplomado->VC_Tematica = $request->tematica;
		$user_id = auth()->user()->id;
		$diplomado->Fk_Mediador = $user_id;
		$diplomado->DT_Created_at = date("Y-m-d H:i:s");
		$diplomado->IN_Estado = '1';
		if($diplomado->save())
			return 200;
	}
	public function getDiplomadosMediador(Request $request){
		$diplomado = new Diplomados;
		$id_mediador = auth()->user()->id;
		$resultado = $diplomado->getDiplomadosMediador($id_mediador);
		return response()->json($resultado, 200);
	}
	public function getOptionsDiplomadosMediador(Request $request){
		$diplomado = new Diplomados;
		$id_mediador = auth()->user()->id;
		$resultado = $diplomado->getOptionsDiplomadosMediador($id_mediador);
		return response()->json($resultado[0]);
	}


	


	public function guardarParticipantesDiplomado(Request $request){
		$diplomado = new ParticipantesDiplomado;
		$diplomado->VC_Nombre_Diplomado = $request->nombre_diplomado;
		$diplomado->DT_Fecha_Inicio = $request->fecha_inicio;
		$diplomado->DT_Fecha_fin = $request->fecha_fin;
		$diplomado->VC_Tematica = $request->tematica;
		$user_id = auth()->user()->id;
		$diplomado->Fk_Mediador = $user_id;
		$diplomado->DT_Created_at = date("Y-m-d H:i:s");
		$diplomado->IN_Estado = '1';
		if($diplomado->save())
			return 200;
	}


}
