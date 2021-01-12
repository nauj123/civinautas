<?php 

namespace App\Models\Diplomados;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SesionDiplomado extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_sesion_diplomado';
    public $timestamps = false;

    public function getEncabezadoConsultaDiplomado($id_diplomado) {
        $informacion = SesionDiplomado::select(SesionDiplomado::raw("Pk_Id_Sesion_Diplomado, DT_Fecha_Sesion"))
        ->where([
          ['Fk_Id_Diplomado', $id_diplomado]
        ])
        ->get();
        return $informacion;
    } 

}