<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use DB;

use Closure;

class PermisosModulos
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $nombre_modulo)
    {
        $permiso = DB::table('modulo')->where('url',$nombre_modulo)->first();
        if($permiso){
            $rol_id = $this->auth->getUser()->fk_rol;
            $validar_permiso = DB::table('modulo_rol')
            ->where([
                ['fk_rol', $rol_id],
                ['fk_modulo', $permiso->pk_id_modulo]
            ])
            ->first();

            if($validar_permiso){
               return $next($request);
           }else{
            return redirect()->route('home');
        }
    }
}
}
