<?php 

namespace App\Models\Registro_Asistencia; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Atencion extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_grupos';
    public $timestamps = false;

    public function getOptionsGruposMediador($id_mediador){
    	$deportes = Grupos::select(Grupos::raw("CONCAT(GROUP_CONCAT('<option value=\"', Pk_Id_Grupo, '\">', VC_Nombre_Grupo , '</option>' SEPARATOR '')) AS 'option'"))
    	->where([
    		['Fk_Id_Medidador', $id_mediador]
    	])
    	->get();
    	return $deportes;
    }

    public function getBuscarEstudianteSimat($buscar){
    	$sql = "SELECT 
        ES.Pk_Id_Estudiante_Simat AS 'IDSIMAT',
        ES.NRO_DOCUMENTO AS 'IDENTIFICACION',
        CONCAT(ES.NOMBRE1,' ',ES.NOMBRE2,' ',ES.APELLIDO1,' ',ES.APELLIDO2) AS 'ESTUDIANTE',
        ES.FECHA_NACIMIENTO AS 'FECHA',
        ES.GENERO AS 'GENERO'
        FROM tb_estudiante_simat AS ES
        WHERE (CONCAT(ES.NOMBRE1,' ',ES.NOMBRE2,' ',ES.APELLIDO1,' ',ES.APELLIDO2) LIKE '%".$buscar."%' OR ES.NRO_DOCUMENTO LIKE '%".$buscar."%')";
        $informacion = DB::select($sql);
        return $informacion;
    }

    public function getGruposMediador($id_Mediador){
    	$sql = "SELECT 
        GR.Pk_Id_Grupo AS 'IDGRUPO',
        IE.VC_Nombre_Institucion AS 'INSTITUCION',
        GR.VC_Nombre_Grupo AS 'NOMBREGRUPO',
        CONCAT(US.primer_nombre,' ',US.segundo_nombre,' ',US.primer_apellido) AS 'MEDIADOR',
        GR.VC_Docente AS 'DOCENTE',
        PDA.descripcion AS 'TIPOATENCION',
        PDJ.descripcion AS 'JORNADA',
        (SELECT COUNT(EG.Fk_Id_Estudiante) FROM tb_estudiante_grupo AS EG
        WHERE EG.Fk_Id_Grupo = GR.Pk_Id_Grupo) AS 'ESTUDIANTES'
        FROM tb_grupos AS GR
        JOIN tb_instituciones_educativas AS IE ON GR.Fk_Id_Institucion = IE.Pk_Id_Institucion
        JOIN users AS US ON GR.Fk_Id_Medidador = US.id
        LEFT JOIN parametro_detalle AS PDA ON GR.Fk_Id_Tipo_Atencion = PDA.id_parametro_detalle AND PDA.fk_parametro = 8
        LEFT JOIN parametro_detalle AS PDJ ON GR.Fk_Id_Jornada = PDJ.id_parametro_detalle AND PDJ.fk_parametro = 9
        WHERE GR.Fk_Id_Medidador = $id_Mediador";
        $informacion = DB::select($sql);
        return $informacion;
    }

}
