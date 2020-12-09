<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
	/**
    * The table associated with the model.
    *
    * @var string
    */
	protected $table = 'modulo';
	public $timestamps = false;

	public function getModulos($id_usuario){
		$modulos = Modulo::select("nombre_modulo", "icono", "url")
		->join("modulo_rol as mr", "mr.fk_modulo", "=", "pk_id_modulo")
		->join("users as u", "u.fk_rol", "=", "mr.fk_rol")
		->where([
			["u.id", $id_usuario],
			["estado", 1]
		])
		->get();
		return $modulos;
	}
}
