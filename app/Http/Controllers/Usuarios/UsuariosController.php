<?php
namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios\Users;
use App\Models\Usuarios\UsuarioRol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct(){
		$this->middleware('auth');
	}
	public function index(){
		return view('usuarios/gestion_usuarios');
	}
	public function guardarNuevousuario(Request $request){
		$usuario = new Users;
		$usuario->fk_tipo_documento = $request->tipo_documento;
		$usuario->identificacion = $request->identificacion;
		$usuario->primer_nombre = $request->primer_nombre;
		$usuario->segundo_nombre = $request->segundo_nombre;
		$usuario->primer_apellido = $request->primer_apellido;
		$usuario->segundo_apellido = $request->segundo_apellido;
		$usuario->fecha_nacimiento = $request->fecha_nacimiento;
		$usuario->genero = $request->genero;
		$usuario->email = $request->email;
		$usuario->email = $request->email_verificacion;
		$usuario->celular = $request->celular;
		$usuario->fk_rol = $request->rol;
		$usuario->password = Hash::make($request->identificacion);
		if($usuario->save())
			return 200;
	}
	public function getUsuarios(Request $request){
		$usuario = new Users;
		$resultado = $usuario->getUsuarios();
		return response()->json($resultado, 200);
	}
	public function perfilUsuario(){
		return view('usuarios/perfil_usuario');	
	}
	public function getInfoUsuario(Request $request){ 
		$usuario = new Users;
		$user_id = $request->id_usuario == "" ? auth()->user()->id : $request->id_usuario;
		$resultado = $usuario->getInfoUsuario($user_id);
		return response()->json($resultado[0], 200);
	}
	public function actualizarInfoUsuario(Request $request){
		$usuario = new Users;
		$user_id = $request->id_usuario == "" ? auth()->user()->id : $request->id_usuario;
		$array_update = [];

		$array_update["primer_nombre"] = $request->primer_nombre;
		$array_update["segundo_nombre"] = $request->segundo_nombre;
		$array_update["primer_apellido"] = $request->primer_apellido;
		$array_update["segundo_apellido"] = $request->segundo_apellido;
		$array_update["fk_tipo_documento"] = $request->tipo_documento;
		$array_update["identificacion"] = $request->identificacion;
		$array_update["fecha_nacimiento"] = $request->fecha_nacimiento;
		$array_update["genero"] = $request->genero;
		$array_update["email"] = $request->email;
		$array_update["celular"] = $request->celular;

		if($request->rol != "")
			$array_update["fk_rol"] = $request->rol;

		$usuario->where('id', $user_id)
		->update($array_update);
		if($usuario){
			return 200;
		}
	}
	public function getListadoUsuarios(Request $request){
		$usuario = new Users;
		$resultado = $usuario->getListadoUsuarios();
		return response()->json($resultado[0]);
	}
	public function InactivarUsuario(Request $request){
		$usuario = new Users;
		$usuario_id =  $request->id_usuario;
		$array_update = [];
		$array_update["IN_Estado"] = 0;
		$user_id = auth()->user()->id;
		$Observaciones = 'Usuario: '.$user_id.'; Motivo Inactivación: '.$request->observacion.'; Fecha Inactivación: '.date("Y-m-d H:i:s");
		$array_update["VC_Observaciones"] = $Observaciones;
		$usuario->where('id', $usuario_id)
		->update($array_update);
		if($usuario){
			return 200;
		}
	}
	public function ActivarUsuario(Request $request){
		$estudiantegrupo = new Users;
		$usuario_id =  $request->id_usuario;
		$array_update = [];
		$array_update["IN_Estado"] = 1;
		$estudiantegrupo->where('id', $usuario_id)
		->update($array_update);
		if($estudiantegrupo){
			return 200;
		}
	}

	
	
}
