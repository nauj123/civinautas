<?php 

namespace App\Models\Gestion_Colegios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Colegios extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_instituciones_educativas';
    public $timestamps = false;

  public function getInstitucionesEducativas(){
    	$sql = "SELECT 
        IE.Pk_Id_Institucion AS 'IDINSTITUCIONAL',
        PDT.descripcion AS 'TIPOINSTITUCION',
        IE.VC_Nombre_Institucion AS 'NOMBRE',
        IE.VC_Codigo_Dane AS 'CODIGODANE',
        LO.VC_Nom_Localidad AS 'LOCALIDAD',
        CONCAT(UP.IN_Codigo_Upz,' ',UP.VC_Nombre_Upz) AS 'UPZ',
        IE.IN_Sedes AS 'SEDES'
        FROM tb_instituciones_educativas AS IE
        JOIN parametro_detalle AS PDT ON IE.Fk_Tipo_Institucion = PDT.id_parametro_detalle AND PDT.fk_parametro = 6
        JOIN tb_localidades AS LO ON IE.Fk_Id_Localidad = LO.Pk_Id_Localidad 
        JOIN tb_upz AS UP ON IE.Fk_Id_Upz = UP.Pk_Id_Upz";
        $informacion = DB::select($sql);
        return $informacion;
    }
   /*   public function getInfoUsuario($user_id){
        $usuario = Users::select(
            "id",
            "primer_nombre",
            "segundo_nombre",
            "primer_apellido",
            "segundo_apellido",
            "fk_tipo_documento as tipo_documento",
            "identificacion",
            "fecha_nacimiento",
            "genero",
            "email",
            "celular",
            "fk_rol as rol"
        )
        ->where("id", $user_id)
        ->get();
        return $usuario;
    }

    public function getListadoUsuarios(){
    	$usuarios = Users::select(Users::raw("CONCAT(GROUP_CONCAT('<option value=\"', id, '\">', CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido) , '</option>' SEPARATOR '')) AS 'option'"))
    	->get();
    	return $usuarios;
    } */
}
