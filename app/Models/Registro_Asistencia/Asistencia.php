<?php 

namespace App\Models\Registro_Asistencia; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asistencia extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_asistencia';
    public $timestamps = false;
}
