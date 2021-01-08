<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reportes\Reportes;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
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
		return view('Reportes/reportes');
	}
	public function getReporteConsolidado(Request $request){
		$reporte = new Reportes;
		$resultado = $reporte->getReporteConsolidado($request->mes);
		return response()->json($resultado, 200);
	}
	public function getConsolidadoCicloVital(Request $request){
		$reporte = new Reportes;
		$resultado = $reporte->getConsolidadoCicloVital($request->mes);
		return response()->json($resultado, 200);
	}

	public function getConsultaCompleta(Request $request){
		$grupos = new Reportes;
		$resultado = $grupos->getConsultaCompleta($request->anio);
		return response()->json($resultado, 200);
	}
}
