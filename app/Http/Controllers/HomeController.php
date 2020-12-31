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
        $informacion = Colegios::select("*")
        ->where("IN_Estado", 1)
        ->whereYear("DT_Created_at", $request->anio)
        ->get()->count();
        return $informacion;
    }
    public function getTotalGrupos(Request $request){
        $informacion = Grupos::select("*")
        ->where("IN_Estado", 1)
        ->whereYear("DT_Created_at", $request->anio)
        ->get()->count();
        return $informacion;
    }
    public function getTotalBeneficiarios(Request $request){
        $informacion = Asistencia::select("IN_Asistencia")->where("IN_Asistencia", 1)
        ->join("tb_atenciones", "Pk_Id_Atencion", "=", "Fk_Id_Atencion")
        ->where("IN_Asistencia", 1)
        ->whereYear("DT_Fecha_Atencion", $request->anio)
        ->get()->count();
        return $informacion;
    }
    public function getTotalBeneficiariosPorGenero(Request $request){
        $anio = $request->anio;
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
        WHERE es.ANO_INF = $anio
        GROUP BY es.GENERO) AS SUBQUERY";
        $informacion = DB::select($sql);
        return response()->json($informacion[0]);
    }
    public function getTotalBeneficiariosAtendidosPorGenero(Request $request){
        $anio = $request->anio;
        $sql="SELECT
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
        CONCAT('{\"value\":', COUNT(es.IN_Genero),', \"name\":\"', (CASE WHEN es.IN_Genero=1 THEN 'Hombres' ELSE 'Mujeres' END) ,'\"}') AS JSON
        FROM tb_asistencia a
        JOIN tb_atenciones ate ON ate.Pk_Id_Atencion=a.Fk_Id_Atencion
        JOIN tb_estudiantes es ON es.Pk_Id_Beneficiario=a.Fk_Id_Estudiante
        WHERE YEAR(ate.DT_Fecha_Atencion) = $anio
        GROUP BY es.IN_Genero) AS SUBQUERY";
        $informacion = DB::select($sql);
        return response()->json($informacion[0]);
    }
    public function getTotalAtenciones(Request $request){
        $anio = $request->anio;
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
        WHERE MONTH(ate.DT_Fecha_Atencion)<=MES_ID AND YEAR(ate.DT_Fecha_Atencion)=$anio
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
        WHERE a.IN_Asistencia=1 AND YEAR(ate.DT_Fecha_Atencion)=$anio
        GROUP BY MONTH(ate.DT_Fecha_Atencion)) AS PRIMERA";

        $informacion = DB::select($sql);
        return response()->json($informacion[0]);
    }
    public function getTotalCiclosVitales(Request $request){
        $anio = $request->anio;
        $sql="SELECT
        CONCAT('{
        \"tooltip\": {
        \"trigger\": \"axis\",
        \"axisPointer\": {
        \"type\": \"shadow\"
        }
        },
        \"grid\": {
        \"containLabel\": \"true\"
        },
        \"xAxis\": {
        \"type\": \"value\",
        \"boundaryGap\": [0, 0.01]
        },
        \"yAxis\": {
        \"type\": \"category\",
        \"data\": [\"Primera Infancia (0 - 6 años)\", \"Infancia (7 a 13 años)\", \"Adolescencia (14 -17 años)\", \"Juventud (18 -26 años)\", \"Adultez (27 - 59 años)\", \"Adulto Mayor (Más de 60 años)\"]
        },
        \"itemStyle\": {
        \"color\": \"#7569b3\"
        },
        \"series\": [
        {
        \"name\": \"Total\",
        \"type\": \"bar\",
        \"data\": [',
        COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 0 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 6 THEN 1 END),',',
        COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 7 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 13 THEN 1 END),',',
        COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 14 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 17 THEN 1 END),',',
        COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 18 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 26 THEN 1 END),',',
        COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 27 AND TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) <= 59 THEN 1 END),',',
        COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,e.DD_F_Nacimiento,ate.DT_Fecha_Atencion) >= 60 THEN 1 END),']}]}') AS 'json'
        FROM tb_asistencia a
        JOIN tb_estudiantes e ON e.Pk_Id_Beneficiario=a.Fk_Id_Estudiante
        JOIN tb_atenciones ate ON ate.Pk_Id_Atencion=a.Fk_Id_Atencion
        WHERE YEAR(ate.DT_Fecha_Atencion)=$anio";
        $informacion = DB::select($sql);
        return response()->json($informacion[0]);
    }
}
