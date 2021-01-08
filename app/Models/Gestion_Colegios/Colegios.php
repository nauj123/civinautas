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

   //  public function atenciones(){
   //   return $this->hasManyThrough(
   //    "App\Models\Registro_Asistencia\Atencion",
   //    "App\Models\Gestion_Grupos\Grupos",
   //    "Fk_Id_Institucion",
   //    "Fk_Id_Grupo",
   //    "Pk_Id_Institucion",
   //    "Pk_Id_Grupo"
   //  );
   // }

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
     LEFT JOIN tb_upz AS UP ON IE.Fk_Id_Upz = UP.Pk_Id_Upz";
     $informacion = DB::select($sql);
     return $informacion;
   }
   public function getOptionsInstituciones(){
     $instituciones = Colegios::select(Colegios::raw("CONCAT(GROUP_CONCAT('<option value=\"', Pk_Id_Institucion, '\">', VC_Nombre_Institucion , '</option>' SEPARATOR '')) AS 'option'"))
     ->where("IN_Estado", 1)
     ->get();
     return $instituciones;
   }
   public function getInicialesIdLocalidad($id_atencion) {
    $sql = "SELECT 
    CONCAT(IE.VC_Iniciales,'-0',IE.Fk_Id_Localidad) AS 'CODIGO'
    FROM tb_instituciones_educativas AS IE 
    WHERE IE.Pk_Id_Institucion = $id_atencion"; 
    $informacion = DB::select($sql);
    return $informacion;
  }
  public function getInformacionInstitucion($id_institucion){
    $liga = Colegios::select(
      "Pk_Id_Institucion",
      "Fk_Tipo_Institucion",
      "VC_Nombre_Institucion",
      "VC_Codigo_Dane",
      "VC_Iniciales",
      "Fk_Id_Localidad",
      "Fk_Id_Upz",
      "IN_Sedes"   
    )        
    ->where("Pk_Id_Institucion", $id_institucion)
    ->get();
    return $liga;
  } 
}
