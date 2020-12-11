<?php

namespace App\Http\Controllers\Gestion_Simat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios\Users;
use App\Models\Usuarios\UsuarioRol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Gestion_Simat\EstudianteSimat;
use DateTime;

class SimatController extends Controller
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
		return view('Gestion_Simat/simat');
	}

	public function subirArchivo(Request $request){
		$datos = json_decode($request["info"]);
		ini_set('max_execution_time', 300);
		unset($datos[0]);
		$array_respuesta = array();
		$array_respuesta["creado"] = 0;
		$array_respuesta["actualizado"] = 0;
		$creado = 0;
		$actualizado = 0;
		
		foreach ($datos as $dato) {

			$estudiante_existe = EstudianteSimat::select("Pk_Id_Estudiante_Simat")
			->where("NRO_DOCUMENTO", $dato[16])
			->get();

			$estudiante_simat = new EstudianteSimat;

			if(empty(json_decode($estudiante_existe))){

				$estudiante_simat->CODIGO_ESTABLECIMIENTO_EDUCATIVO = $request->codigo_institucion;
				$estudiante_simat->NOMBRE_ESTABLECIMIENTO_EDUCATIVO = $dato[7];
				$estudiante_simat->ANO_INF = $dato[8];
				$estudiante_simat->MES_INF = $request->mes;
				$estudiante_simat->MUN_CODIGO = $dato[9];
				$estudiante_simat->CODIGO_DANE = $dato[10];
				$estudiante_simat->DANE_ANTERIOR = $dato[11];
				$estudiante_simat->CONS_SEDE = $dato[13];
				$estudiante_simat->TIPO_DOCUMENTO = $dato[14];
				$estudiante_simat->NRO_DOCUMENTO = $dato[16];
				$estudiante_simat->EXP_DEPTO = $dato[17];
				$estudiante_simat->EXP_MUN = $dato[18];
				$estudiante_simat->APELLIDO1 = $dato[19];
				$estudiante_simat->APELLIDO2 = $dato[20];
				$estudiante_simat->NOMBRE1 = $dato[21];
				$estudiante_simat->NOMBRE2 = $dato[22];
				$estudiante_simat->DIRECCION_RESIDENCIA = $dato[23];
				$estudiante_simat->TEL = $dato[24];
				$estudiante_simat->RES_DEPTO = $dato[25];
				$estudiante_simat->RES_MUN = $dato[26];
				$estudiante_simat->ESTRATO = $dato[27];
				$estudiante_simat->SISBEN = $dato[28];
				$date = DateTime::createFromFormat('d/m/Y', $dato[29]);
				$estudiante_simat->FECHA_NACIMIENTO = $date->format('Y-m-d');
				$estudiante_simat->NAC_DEPTO = $dato[30];
				$estudiante_simat->NAC_MUN = $dato[31];
				$estudiante_simat->GENERO = $dato[32];
				$estudiante_simat->POB_VICT_CONF = $dato[33];
				$estudiante_simat->DPTO_EXP = $dato[35];
				$estudiante_simat->MUN_EXP = $dato[36];
				$estudiante_simat->PROVIENE_SECTOR_PRIV = $dato[37];
				$estudiante_simat->PROVIENE_OTR_MUN = $dato[38];
				$estudiante_simat->TIPO_DISCAPACIDAD = $dato[39];
				$estudiante_simat->CAP_EXC = $dato[41];
				$estudiante_simat->ETNIA = $dato[43];
				$estudiante_simat->RES = $dato[45];
				$estudiante_simat->INS_FAMILIAR = $dato[46];
				$estudiante_simat->TIPO_JORNADA = $dato[47];
				$estudiante_simat->CARACTER = $dato[49];
				$estudiante_simat->ESPECIALIDAD = $dato[51];
				$estudiante_simat->GRADO = $dato[53];
				$estudiante_simat->NOM_GRADO = $dato[54];
				$estudiante_simat->GRUPO = $dato[56];
				$estudiante_simat->METODOLOGIA = $dato[57];
				$estudiante_simat->MATRICULA_CONTRATADA = $dato[58];
				$estudiante_simat->REPITENTE = $dato[59];
				$estudiante_simat->NUEVO = $dato[60];
				$estudiante_simat->SIT_ACAD_ANO_ANT = $dato[61];
				$estudiante_simat->CON_ALUM_ANO_ANT = $dato[62];
				$estudiante_simat->FUE_RECU = $dato[63];
				$estudiante_simat->ZON_ALU = $dato[64];
				$estudiante_simat->CAB_FAMILIA = $dato[65];
				$estudiante_simat->BEN_MAD_FLIA = $dato[66];
				$estudiante_simat->BEN_VET_FP = $dato[67];
				$estudiante_simat->BEN_HER_NAC = $dato[68];
				$estudiante_simat->CODIGO_INTERNADO = $dato[69];
				$estudiante_simat->CODIGO_VALORACION_1 = $dato[70];
				$estudiante_simat->CODIGO_VALORACION_2 = $dato[71];
				$estudiante_simat->NUM_CONVENIO = $dato[72];
				$estudiante_simat->PER_ID = $dato[73];
				$estudiante_simat->PAIS_ORIGEN = $dato[74];
				$estudiante_simat->save();
				if($estudiante_simat){
					$creado++;
				}
				$array_respuesta["creado"] = $creado;
			}else{
				$array_update = array();
				$array_update["CODIGO_ESTABLECIMIENTO_EDUCATIVO"] = $request->codigo_institucion;
				$array_update["NOMBRE_ESTABLECIMIENTO_EDUCATIVO"] = $dato[7];
				$array_update["ANO_INF"] = $dato[8];
				$array_update["MES_INF"] = $request->mes;
				$array_update["MUN_CODIGO"] = $dato[9];
				$array_update["CODIGO_DANE"] = $dato[10];
				$array_update["DANE_ANTERIOR"] = $dato[11];
				$array_update["CONS_SEDE"] = $dato[13];
				$array_update["TIPO_DOCUMENTO"] = $dato[14];
				$array_update["NRO_DOCUMENTO"] = $dato[16];
				$array_update["EXP_DEPTO"] = $dato[17];
				$array_update["EXP_MUN"] = $dato[18];
				$array_update["APELLIDO1"] = $dato[19];
				$array_update["APELLIDO2"] = $dato[20];
				$array_update["NOMBRE1"] = $dato[21];
				$array_update["NOMBRE2"] = $dato[22];
				$array_update["DIRECCION_RESIDENCIA"] = $dato[23];
				$array_update["TEL"] = $dato[24];
				$array_update["RES_DEPTO"] = $dato[25];
				$array_update["RES_MUN"] = $dato[26];
				$array_update["ESTRATO"] = $dato[27];
				$array_update["SISBEN"] = $dato[28];
				$date = DateTime::createFromFormat('d/m/Y', $dato[29]);
				$array_update["FECHA_NACIMIENTO"] = $date->format('Y-m-d');
				$array_update["NAC_DEPTO"] = $dato[30];
				$array_update["NAC_MUN"] = $dato[31];
				$array_update["GENERO"] = $dato[32];
				$array_update["POB_VICT_CONF"] = $dato[33];
				$array_update["DPTO_EXP"] = $dato[35];
				$array_update["MUN_EXP"] = $dato[36];
				$array_update["PROVIENE_SECTOR_PRIV"] = $dato[37];
				$array_update["PROVIENE_OTR_MUN"] = $dato[38];
				$array_update["TIPO_DISCAPACIDAD"] = $dato[39];
				$array_update["CAP_EXC"] = $dato[41];
				$array_update["ETNIA"] = $dato[43];
				$array_update["RES"] = $dato[45];
				$array_update["INS_FAMILIAR"] = $dato[46];
				$array_update["TIPO_JORNADA"] = $dato[47];
				$array_update["CARACTER"] = $dato[49];
				$array_update["ESPECIALIDAD"] = $dato[51];
				$array_update["GRADO"] = $dato[53];
				$array_update["NOM_GRADO"] = $dato[54];
				$array_update["GRUPO"] = $dato[56];
				$array_update["METODOLOGIA"] = $dato[57];
				$array_update["MATRICULA_CONTRATADA"] = $dato[58];
				$array_update["REPITENTE"] = $dato[59];
				$array_update["NUEVO"] = $dato[60];
				$array_update["SIT_ACAD_ANO_ANT"] = $dato[61];
				$array_update["CON_ALUM_ANO_ANT"] = $dato[62];
				$array_update["FUE_RECU"] = $dato[63];
				$array_update["ZON_ALU"] = $dato[64];
				$array_update["CAB_FAMILIA"] = $dato[65];
				$array_update["BEN_MAD_FLIA"] = $dato[66];
				$array_update["BEN_VET_FP"] = $dato[67];
				$array_update["BEN_HER_NAC"] = $dato[68];
				$array_update["CODIGO_INTERNADO"] = $dato[69];
				$array_update["CODIGO_VALORACION_1"] = $dato[70];
				$array_update["CODIGO_VALORACION_2"] = $dato[71];
				$array_update["NUM_CONVENIO"] = $dato[72];
				$array_update["PER_ID"] = $dato[73];
				$array_update["PAIS_ORIGEN"] = $dato[74];
				$estudiante_simat->where('Pk_Id_Estudiante_Simat', json_decode($estudiante_existe[0]["Pk_Id_Estudiante_Simat"]))->update($array_update);
				if($estudiante_simat){
					$actualizado++;
				}
				$array_respuesta["actualizado"] = $actualizado;
			}
		}
		return $array_respuesta;
	}
}
