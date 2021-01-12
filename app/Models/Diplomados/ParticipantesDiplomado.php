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

    public function getParticipantesDiplomado($id_diplomado){
		$informacion = ParticipantesDiplomado::select("Pk_Id_Participante", "VC_Identificacion", "VC_Nombres", "VC_Apellidos", "VC_Correo")
		->where([
			["Fk_Id_Diplomado", $id_diplomado]
    ])
    ->orderBy('VC_Nombres','desc')
		->get();
		return $informacion;
	}

}
