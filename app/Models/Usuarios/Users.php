<?php 

namespace App\Models\Usuarios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'users';
    public $timestamps = false;

    public function getUsuarios(){
    	$sql = "SELECT 
        id,
        i.descripcion AS 'tipo_identificacion', 
        u.identificacion AS 'identificacion',
        CONCAT_WS(' ', u.primer_nombre, u.segundo_nombre, u.primer_apellido, u.segundo_apellido) AS 'nombre',
        u.fecha_nacimiento AS 'fnacimiento', 
        u.genero AS 'genero', 
        u.email AS 'email',
        u.celular AS 'celular', 
        r.descripcion AS 'rol' 
        FROM users u
        JOIN parametro_detalle i ON i.id_parametro_detalle = u.fk_tipo_documento AND i.fk_parametro = 1
        LEFT JOIN parametro_detalle r ON r.id_parametro_detalle = u.fk_rol AND r.fk_parametro = 5";
        $informacion = DB::select($sql);
        return $informacion;
    }
    public function getInfoUsuario($user_id){
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
    }
}
