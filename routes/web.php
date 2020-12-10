<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
})->name('welcome');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
	Route::get('usuarios/gestion-usuarios', 'Usuarios\UsuariosController@index')->name('gestion-usuarios')->middleware("PermisosModulos:gestion-usuarios");
	Route::get('administracion/administracion-parametros', 'Administracion\ParametrosController@index')->name('administracion-parametros')->middleware("PermisosModulos:administracion-parametros");
	Route::get('Gestion_Simat/gestion-simat', 'Gestion_Simat\SimatController@index')->name('gestion-simat')->middleware("PermisosModulos:gestion-simat");
	Route::get('Gestion_Colegios/gestion-colegios', 'Gestion_Colegios\ColegiosController@index')->name('gestion-colegios')->middleware("PermisosModulos:gestion-colegios");
	Route::get('Gestion_Grupos/gestion-grupos', 'Gestion_Grupos\GruposController@index')->name('gestion-grupos')->middleware("PermisosModulos:gestion-grupos");
	Route::get('Caracterizacion/caracterizacion-estudiantes', 'Caracterizacion\CaracterizacionController@index')->name('caracterizacion-estudiantes')->middleware("PermisosModulos:caracterizacion-estudiantes");
	Route::get('Reportes/reportes-consultas', 'Reportes\ReportesController@index')->name('reportes-consultas')->middleware("PermisosModulos:reportes-consultas");
	Route::get('Registro_Asistencia/registro-asistencia', 'Registro_Asistencia\AsistenciaController@index')->name('registro-asistencia')->middleware("PermisosModulos:registro-asistencia");
});

Route::post('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name("logout");
Route::get('/home', 'HomeController@index')->name('home');


/**
 * Rutas administración
 */

Route::post('/administracion/getOptionsParametro', 'Administracion\ParametrosController@getOptionsParametro');
Route::post('/administracion/getParametros', 'Administracion\ParametrosController@getParametros');
Route::post('/administracion/getParametroAsociados', 'Administracion\ParametrosController@getParametroAsociados');
Route::post('/administracion/modificarParametroAsociado', 'Administracion\ParametrosController@modificarParametroAsociado');
Route::post('/administracion/guardarNuevoParametroAsociado', 'Administracion\ParametrosController@guardarNuevoParametroAsociado');
Route::post('/administracion/getLocalidades', 'Administracion\ParametrosController@getLocalidades');
Route::post('/administracion/getUpz', 'Administracion\ParametrosController@getUpz');


/**
 * Rutas usuarios
 */
Route::post('/usuarios/guardarNuevoUsuario', 'Usuarios\UsuariosController@guardarNuevoUsuario');
Route::post('/usuarios/getUsuarios', 'Usuarios\UsuariosController@getUsuarios');
Route::get('/usuarios/perfil-usuario', 'Usuarios\UsuariosController@perfilUsuario')->name("perfil-usuario");
Route::post('/usuarios/getInfoUsuario', 'Usuarios\UsuariosController@getInfoUsuario');
Route::post('/usuarios/actualizarInfoUsuario', 'Usuarios\UsuariosController@actualizarInfoUsuario');
Route::post('/usuarios/getListadoUsuarios', 'Usuarios\UsuariosController@getListadoUsuarios');

/**
 * Rutas instituciones educativas
 */
Route::post('/Gestion_Colegios/guardarNuevaInstitucion', 'Gestion_Colegios\ColegiosController@guardarNuevaInstitucion');
Route::post('/Gestion_Colegios/getInstitucionesEducativas', 'Gestion_Colegios\ColegiosController@getInstitucionesEducativas');
Route::post('/Gestion_Colegios/getOptionsInstituciones', 'Gestion_Colegios\ColegiosController@getOptionsInstituciones');

/**
 * Rutas instituciones educativas
 */
Route::post('/Gestion_Grupos/guardarNuevoGrupo', 'Gestion_Grupos\GruposController@guardarNuevoGrupo');

