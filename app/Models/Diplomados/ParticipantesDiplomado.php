<?php 

namespace App\Models\Diplomados;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ParticipantesDiplomado extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_participantes_diplomado';
    public $timestamps = false;

  /*  public function getParticipantesDiplomado($id_diplomado){
		$informacion = ParticipantesDiplomado::select("Pk_Id_Participante", "VC_Identificacion", "VC_Nombres", "VC_Apellidos", "VC_Correo")
		->where([
			["Fk_Id_Diplomado", $id_diplomado]
    ])
    ->orderBy('VC_Nombres','desc')
		->get();
		return $informacion;
  } */
  
  public function getParticipantesDiplomado($id_diplomado){
    $sql = "SELECT 
    PD.Pk_Id_Participante AS 'IDPARTICIPANTE',
    PD.VC_Correo AS 'CORREO',
    PD.VC_Identificacion AS 'IDENTIFICACION',
    PD.VC_Nombres AS 'NOMBRES', 
    PD.VC_Apellidos AS 'APELLIDOS', 
    IE.VC_Nombre_Institucion AS 'ENTIDAD', 
    (CASE WHEN PD.IN_Rol = '1' THEN 'Contratista' WHEN PD.IN_Rol = '2' THEN 'Padre/ madre de familia - Cuidador'
        WHEN PD.IN_Rol = '3' THEN 'Docente' WHEN PD.IN_Rol = '4' THEN 'Orientador/a'
        WHEN PD.IN_Rol = '5' THEN 'Directivo/a' WHEN PD.IN_Rol = '6' THEN 'Otro'	END) AS 'ROL',
    LO.VC_Nom_Localidad AS 'LOCALIDAD', 
    PDE.descripcion 'ETNIA', 
    (CASE WHEN PD.Fk_Id_Social = '1' THEN 'Víctima del conflicto armado' WHEN PD.Fk_Id_Social = '2' THEN 'Campesino'
        WHEN PD.Fk_Id_Social = '3' THEN 'Persona con discapacidad' WHEN PD.Fk_Id_Social = '4' THEN 'Otro'
        WHEN PD.Fk_Id_Social = '5' THEN 'No aplica' END) AS 'SOCIAL',
    PD.VC_Telefono AS 'TELEFONO'
    FROM tb_participantes_diplomado AS PD
    JOIN tb_instituciones_educativas AS IE ON PD.IN_Id_Entidad = IE.Pk_Id_Institucion
    JOIN tb_localidades AS LO ON PD.Fk_Id_Localidad = LO.Pk_Id_Localidad
    LEFT JOIN parametro_detalle AS PDE ON PD.FK_Id_Etnia = PDE.id_parametro_detalle
    WHERE Fk_Id_Diplomado = $id_diplomado ORDER BY APELLIDOS";
      $informacion = DB::select($sql);
      return $informacion;
  }

}
