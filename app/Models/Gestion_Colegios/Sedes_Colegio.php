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

}
