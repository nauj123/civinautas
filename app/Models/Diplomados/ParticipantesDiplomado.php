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

}
