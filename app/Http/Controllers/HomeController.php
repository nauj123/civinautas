<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestion_Colegios\Colegios;
use App\Models\Gestion_Grupos\Grupos;
use App\Models\Gestion_Simat\EstudianteSimat;
use App\Models\Registro_Asistencia\Asistencia;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function getTotalColegios(Request $request){
        $informacion = Colegios::select("*")->get()->count();
        return $informacion;
    }
    public function getTotalGrupos(Request $request){
        $informacion = Grupos::select("*")->get()->count();
        return $informacion;
    }
    public function getTotalBeneficiarios(Request $request){
        $informacion = Asistencia::select("IN_Asistencia")->where("IN_Asistencia", 1)->get()->count();
        return $informacion;
    }
    public function getTotalBeneficiariosPorGenero(Request $request){
        $sql = "SELECT
        CONCAT('{ 
        \"tooltip\": {
        \"trigger\": \"item\",
        \"formatter\": \"{a} <br/>{b} : {c} ({d}%)\"
        },
        \"visualMap\": {
        \"show\": false,
        \"min\": 80,
        \"max\": 600,
        \"inRange\": {
        }
        },
        \"series\": [
        {
        \"name\": \"Beneficiarios\",
        \"type\": \"pie\",
        \"radius\": \"55%\",
        \"center\": [\"50%\", \"50%\"],
        \"data\": [',
        GROUP_CONCAT(SUBQUERY.JSON), '],
        \"roseType\": \"radius\",
        \"label\": {
        \"color\": \"rgba(117, 105, 179)\"
        },
        \"labelLine\": {
        \"lineStyle\": {
        \"color\": \"rgba(117, 105, 179)\"
        },
        \"smooth\": 0.2,
        \"length\": 10,
        \"length2\": 20
        },
        \"itemStyle\": {
        \"color\": \"#7569b3\",
        \"shadowBlur\": 200,
        \"shadowColor\": \"rgba(0, 0, 0, 0.5)\"
        },
        \"animationType\": \"scale\",
        \"animationEasing\": \"elasticOut\"
        }
        ]
        }') as 'json'
        FROM (
        SELECT
        CONCAT('{\"value\":', COUNT(es.GENERO),', \"name\":\"', (CASE WHEN es.GENERO=\"M\" THEN \"Hombres\" ELSE \"Mujeres\" END) ,'\"}') AS JSON
        FROM tb_estudiante_simat es
        GROUP BY es.GENERO) AS SUBQUERY";
        $informacion = DB::select($sql);
        return response()->json($informacion[0]);
    }
    public function getTotalAtenciones(REQUEST $request){
        $sql="SELECT
        CONCAT('{
        \"legend\": {},
        \"tooltip\": {},
        \"dataset\": {
        \"source\": [
        [\"Atenciones\", \"Mensual\", \"Acumulada\"],',
        GROUP_CONCAT('[\"',PRIMERA.MES_NOMBRE,'\",', PRIMERA.ATENDIDOS_MES,',',PRIMERA.ACUMULADO,']'),
        ']
        },
        \"xAxis\": {\"type\": \"category\"},
        \"color\": [\"#bcbbdd\", \"#7569b3\"],
        \"yAxis\": {},
        \"series\": [
        {\"type\": \"bar\"},
        {\"type\": \"bar\"}
        ]
        }'
        ) as 'json'
        FROM(
        SELECT
        MONTH(ate.DT_Fecha_Atencion) AS MES_ID,
        SUM(a.IN_Asistencia) AS ATENDIDOS_MES,
        (
        SELECT
        SUM(a.IN_Asistencia)
        FROM tb_asistencia a
        JOIN tb_atenciones ate ON ate.Pk_Id_Atencion=a.Fk_Id_Atencion
        WHERE MONTH(ate.DT_Fecha_Atencion)<=MES_ID
        ) AS ACUMULADO,
        CASE
        WHEN MONTH(ate.DT_Fecha_Atencion)=1 THEN 'Enero'
        WHEN MONTH(ate.DT_Fecha_Atencion)=2 THEN 'Febrero'
        WHEN MONTH(ate.DT_Fecha_Atencion)=3 THEN 'Marzo'
        WHEN MONTH(ate.DT_Fecha_Atencion)=4 THEN 'Abril'
        WHEN MONTH(ate.DT_Fecha_Atencion)=5 THEN 'Mayo'
        WHEN MONTH(ate.DT_Fecha_Atencion)=6 THEN 'Junio'
        WHEN MONTH(ate.DT_Fecha_Atencion)=7 THEN 'Julio'
        WHEN MONTH(ate.DT_Fecha_Atencion)=8 THEN 'Agosto'
        WHEN MONTH(ate.DT_Fecha_Atencion)=9 THEN 'Septiembre'
        WHEN MONTH(ate.DT_Fecha_Atencion)=10 THEN 'Octubre'
        WHEN MONTH(ate.DT_Fecha_Atencion)=11 THEN 'Noviembre'
        WHEN MONTH(ate.DT_Fecha_Atencion)=12 THEN 'Diciembre'
        END AS MES_NOMBRE
        FROM tb_asistencia a
        JOIN tb_atenciones ate ON ate.Pk_Id_Atencion=a.Fk_Id_Atencion
        WHERE a.IN_Asistencia=1
        GROUP BY MONTH(ate.DT_Fecha_Atencion)) AS PRIMERA";

        $informacion = DB::select($sql);
        return response()->json($informacion[0]);
    }
}
