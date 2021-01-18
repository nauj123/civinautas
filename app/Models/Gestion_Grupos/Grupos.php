<?php 

namespace App\Models\Gestion_Grupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grupos extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_grupos';
    public $timestamps = false;

    public function institucionEducativa(){
        return $this->belongsTo("App\Models\Gestion_Colegios\Colegios", "Fk_Id_Institucion", "Pk_Id_Institucion");
    }

    public function getOptionsGruposMediador($id_mediador){
        $deportes = Grupos::select(Grupos::raw("CONCAT(GROUP_CONCAT('<option value=\"', Pk_Id_Grupo, '\">', VC_Nombre_Grupo , '</option>' SEPARATOR '')) AS 'option'"))
        ->where([
            ['Fk_Id_Medidador', $id_mediador],
            ['IN_Estado', 1]
        ])
        ->get();
        return $deportes;
    }

    public function getBuscarEstudianteSimat($buscar, $grupo){
     $sql = "SELECT 
     ES.Pk_Id_Estudiante_Simat AS 'IDSIMAT',
     ES.TIPO_DOCUMENTO AS 'TIPODOCUMENTO',
     ES.NRO_DOCUMENTO AS 'IDENTIFICACION',
     CONCAT(ES.NOMBRE1,' ',ES.NOMBRE2,' ',ES.APELLIDO1,' ',ES.APELLIDO2) AS 'ESTUDIANTE',
     ES.NOMBRE1 AS 'PNOMBRE',
     ES.NOMBRE2 AS 'SNOMBRE',
     ES.APELLIDO1 AS 'PAPELLIDO',
     ES.APELLIDO2 AS 'SAPELLIDO',
     ES.FECHA_NACIMIENTO AS 'FECHA',
     ES.GENERO AS 'GENERO',
     (CASE WHEN ES.GENERO = 'M' THEN '1' WHEN ES.GENERO = 'F' THEN '2' END) AS 'IDGENERO',
     ES.DIRECCION_RESIDENCIA AS 'DIRECCION',
     ES.TEL AS 'CELULAR',
     ES.ESTRATO AS 'ESTRATO',
     ES.GRADO AS 'GRADO'
     FROM tb_estudiante_simat AS ES
     LEFT JOIN tb_grupos AS GR ON ES.CODIGO_ESTABLECIMIENTO_EDUCATIVO = GR.Fk_Id_Institucion
     WHERE (CONCAT(ES.NOMBRE1,' ',ES.NOMBRE2,' ',ES.APELLIDO1,' ',ES.APELLIDO2) LIKE '%".$buscar."%' OR ES.NRO_DOCUMENTO LIKE '%".$buscar."%')
     AND GR.Pk_Id_Grupo = $grupo";
     $informacion = DB::select($sql);
     return $informacion;
 }

 public function getGruposMediador($id_Mediador){
     $sql = "SELECT 
     GR.Pk_Id_Grupo AS 'IDGRUPO',
     IE.VC_Nombre_Institucion AS 'INSTITUCION',
     SE.VC_Nombre_Sede AS 'SEDE',
     GR.VC_Nombre_Grupo AS 'NOMBREGRUPO',
     CONCAT(US.primer_nombre,' ',US.segundo_nombre,' ',US.primer_apellido) AS 'MEDIADOR',
     GR.VC_Docente AS 'DOCENTE',
     PDJ.descripcion AS 'JORNADA',
     GR.VC_Nivel_Escolaridad AS 'GRADO',
     GR.IN_Estado AS 'ESTADO',
     (SELECT COUNT(EG.Fk_Id_Estudiante) FROM tb_estudiante_grupo AS EG
     WHERE EG.Fk_Id_Grupo = GR.Pk_Id_Grupo) AS 'ESTUDIANTES',
     GR.VC_Observaciones AS 'OBSERVACION'
     FROM tb_grupos AS GR
     JOIN tb_instituciones_educativas AS IE ON GR.Fk_Id_Institucion = IE.Pk_Id_Institucion
     LEFT JOIN tb_sedes_instituciones AS SE ON GR.Fk_Id_Sede = SE.Pk_Id_Sede
     JOIN users AS US ON GR.Fk_Id_Medidador = US.id
     LEFT JOIN parametro_detalle AS PDJ ON GR.Fk_Id_Jornada = PDJ.id_parametro_detalle
     WHERE GR.Fk_Id_Medidador = $id_Mediador ORDER BY ESTADO DESC, INSTITUCION, NOMBREGRUPO";
     $informacion = DB::select($sql);
     return $informacion;
 }

 public function getTotalGrupos(){
     $sql = "SELECT 
     GR.Pk_Id_Grupo AS 'IDGRUPO',
     LO.VC_Nom_Localidad AS 'LOCALIDAD',
     PD.descripcion AS 'TIPOINSTITUCION',
     IE.VC_Nombre_Institucion AS 'INSTITUCION',
     GR.VC_Nombre_Grupo AS 'NOMGRUPO',
     (SELECT COUNT(EG.Fk_Id_Estudiante) 
     FROM tb_estudiante_grupo AS EG
     WHERE EG.IN_Estado = 1 AND EG.Fk_Id_Grupo = GR.Pk_Id_Grupo) AS 'ESTUDIANTES',
     CONCAT_WS(' ', US.primer_nombre,US.segundo_nombre,US.primer_apellido) AS 'MEDIADOR',
     GR.VC_Docente AS 'DOCENTE',
     PDJ.descripcion AS 'JORNADA',
     GR.DT_Created_at AS 'FCREACION',
     (CASE WHEN GR.IN_Estado = '0' THEN 'INACTIVO' WHEN GR.IN_Estado = '1' THEN 'ACTIVO' END) AS 'ESTADO',
     GR.VC_Observaciones AS 'OBSERVACIONES'
     FROM tb_grupos AS GR
     JOIN tb_instituciones_educativas AS IE ON GR.Fk_Id_Institucion = IE.Pk_Id_Institucion
     JOIN tb_localidades AS LO ON IE.Fk_Id_Localidad  = LO.Pk_Id_Localidad
     JOIN parametro_detalle AS PD ON IE.Fk_Tipo_Institucion = PD.id_parametro_detalle
     JOIN users AS US ON GR.Fk_Id_Medidador = US.id
     JOIN parametro_detalle AS PDJ ON GR.Fk_Id_Jornada = PDJ.id_parametro_detalle";
     $informacion = DB::select($sql);
     return $informacion;
 }



}
