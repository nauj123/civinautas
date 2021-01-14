<?php 

namespace App\Models\Gestion_Colegios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sedes_Colegio extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_sedes_instituciones';
    public $timestamps = false;


    public function getSedesInstitucion($id_institucion){
        $sede = Sedes_Colegio::select(
          "Fk_Id_Institucion",
          "Fk_Id_Localidad",
          "Fk_Id_Upz",
          "VC_Nombre_Sede",
          "VC_Dane12"
        )        
        ->where("Fk_Id_Institucion", $id_institucion)
        ->get();
        return $sede;
      } 

      public function getOptionsSedes($id_institucion){
        $parametro = Sedes_Colegio::select(Sedes_Colegio::raw("CONCAT(GROUP_CONCAT('<option value=\"', Pk_Id_Sede, '\">', VC_Nombre_Sede , '</option>' SEPARATOR '')) AS 'option'"))
        ->where([
          ['Fk_Id_Institucion', $id_institucion]
        ])
        ->get();
        return $parametro;
      }
}
