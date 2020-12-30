<?php 

namespace App\Models\Diplomados;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AsistenciaDiplomado extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_asistencia_diplomado';
    public $timestamps = false;

}