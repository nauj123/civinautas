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
	Route::get('Diplomados/diplomados', 'Diplomados\DiplomadosController@index')->name('diplomados')->middleware("PermisosModulos:diplomados");
});

Route::post('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name("logout");
Route::get('/home', 'HomeController@index')->name('home');


/**
 * Rutas administración
 */

Route::post('/administracion/getOptionsParametro', 'Administracion\ParametrosController@getOptionsParametro');
Route::post('/administracion/getOptionsIDParametroDetalle', 'Administracion\ParametrosController@getOptionsIDParametroDetalle');
Route::post('/administracion/getTipoActividad', 'Administracion\ParametrosController@getTipoActividad');
Route::post('/administracion/getParametros', 'Administracion\ParametrosController@getParametros');
Route::post('/administracion/getParametroAsociados', 'Administracion\ParametrosController@getParametroAsociados');
Route::post('/administracion/modificarParametroAsociado', 'Administracion\ParametrosController@modificarParametroAsociado');
Route::post('/administracion/guardarNuevoParametroAsociado', 'Administracion\ParametrosController@guardarNuevoParametroAsociado');
Route::post('/administracion/getLocalidades', 'Administracion\ParametrosController@getLocalidades');
Route::post('/administracion/getUpz', 'Administracion\ParametrosController@getUpz');
Route::post('/administracion/getMeses', 'Administracion\ParametrosController@getMeses');

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
Route::post('/Gestion_Colegios/getInicialesIdLocalidad', 'Gestion_Colegios\ColegiosController@getInicialesIdLocalidad');
Route::post('/Gestion_Colegios/getInformacionInstitucion', 'Gestion_Colegios\ColegiosController@getInformacionInstitucion');
Route::post('/Gestion_Colegios/actualizarInformacionInstitucion', 'Gestion_Colegios\ColegiosController@actualizarInformacionInstitucion');

/**
 * Rutas grupos
 */
Route::post('/Gestion_Grupos/getGruposMediador', 'Gestion_Grupos\GruposController@getGruposMediador');
Route::post('/Gestion_Grupos/guardarNuevoGrupo', 'Gestion_Grupos\GruposController@guardarNuevoGrupo');
Route::post('/Gestion_Grupos/getOptionsGruposMediador', 'Gestion_Grupos\GruposController@getOptionsGruposMediador');
Route::post('/Gestion_Grupos/getBuscarEstudianteSimat', 'Gestion_Grupos\GruposController@getBuscarEstudianteSimat');
Route::post('/Gestion_Grupos/agregarEstudianteGrupo', 'Gestion_Grupos\GruposController@agregarEstudianteGrupo');
Route::post('/Gestion_Grupos/getEstudiantesGrupo', 'Gestion_Grupos\GruposController@getEstudiantesGrupo');
Route::post('/Gestion_Grupos/getEstudiantesGrupoAsistencia', 'Gestion_Grupos\GruposController@getEstudiantesGrupoAsistencia');
Route::post('/Gestion_Grupos/guardarNuevoEstudiante', 'Gestion_Grupos\GruposController@guardarNuevoEstudiante');
Route::post('/Gestion_Grupos/getEstadoEstudiante', 'Gestion_Grupos\GruposController@getEstadoEstudiante');
Route::post('/Gestion_Grupos/InactivarEstudiante', 'Gestion_Grupos\GruposController@InactivarEstudiante');
Route::post('/Gestion_Grupos/ActivarEstudiante', 'Gestion_Grupos\GruposController@ActivarEstudiante');
Route::post('/Gestion_Grupos/InactivarGrupo', 'Gestion_Grupos\GruposController@InactivarGrupo');
Route::post('/Gestion_Grupos/getTotalGrupos', 'Gestion_Grupos\GruposController@getTotalGrupos');


/**
 * Rutas gestión simat
 */
Route::post('/Gestion_Simat/subirArchivo', 'Gestion_Simat\SimatController@subirArchivo');

Route::post('/Gestion_Simat/getInfoArchivosSubidos', 'Gestion_Simat\SimatController@getInfoArchivosSubidos');
Route::post('/Gestion_Simat/buscarEstudiante', 'Gestion_Simat\SimatController@buscarEstudiante');
Route::post('/Gestion_Simat/getDatosEstudiante', 'Gestion_Simat\SimatController@getDatosEstudiante');
Route::post('/Gestion_Simat/modificarEstudiante', 'Gestion_Simat\SimatController@modificarEstudiante');
Route::post('/Gestion_Simat/getEstudiantesColegioSimat', 'Gestion_Simat\SimatController@getEstudiantesColegioSimat');

/**
 * Rutas registro de asistencia
 */
Route::post('/Registro_Asistencia/guardarActividadAsistencia', 'Registro_Asistencia\AsistenciaController@guardarActividadAsistencia');
Route::post('/Registro_Asistencia/getListadoActividadesGrupo', 'Registro_Asistencia\AsistenciaController@getListadoActividadesGrupo');
Route::post('/Registro_Asistencia/getEncabezadoAtencion', 'Registro_Asistencia\AsistenciaController@getEncabezadoAtencion');
Route::post('/Registro_Asistencia/getAsistenciaAtencion', 'Registro_Asistencia\AsistenciaController@getAsistenciaAtencion');

/**
 * Rutas reportes
 */
Route::post('/Reportes/getReporteConsolidado', 'Reportes\ReportesController@getReporteConsolidado');
Route::post('/Reportes/getConsolidadoCicloVital', 'Reportes\ReportesController@getConsolidadoCicloVital');
Route::post('/Reportes/getConsultaCompleta', 'Reportes\ReportesController@getConsultaCompleta');

/**
 * Rutas gráficas home
 */
Route::post('getTotalColegios', 'HomeController@getTotalColegios');
Route::post('getTotalGrupos', 'HomeController@getTotalGrupos');
Route::post('getTotalBeneficiarios', 'HomeController@getTotalBeneficiarios');
Route::post('getTotalBeneficiariosPorGenero', 'HomeController@getTotalBeneficiariosPorGenero');
Route::post('getTotalAtenciones', 'HomeController@getTotalAtenciones');
Route::post('getTotalBeneficiariosAtendidosPorGenero', 'HomeController@getTotalBeneficiariosAtendidosPorGenero');
Route::post('getTotalCiclosVitales', 'HomeController@getTotalCiclosVitales');

/**
 * Rutas Diplomados 
 */
Route::post('/Diplomados/guardarNuevoDiplomado', 'Diplomados\DiplomadosController@guardarNuevoDiplomado');
Route::post('/Diplomados/getDiplomadosMediador', 'Diplomados\DiplomadosController@getDiplomadosMediador');
Route::post('/Diplomados/getOptionsDiplomadosMediador', 'Diplomados\DiplomadosController@getOptionsDiplomadosMediador');
Route::post('/Diplomados/guardarParticipantesDiplomado', 'Diplomados\DiplomadosController@guardarParticipantesDiplomado');
Route::post('/Diplomados/getInfoParticipantesDiplomado', 'Diplomados\DiplomadosController@getInfoParticipantesDiplomado');
Route::post('/Diplomados/guardarAsistenciaDiplomado', 'Diplomados\DiplomadosController@guardarAsistenciaDiplomado');

/**
 * Rutas caracterización 
 */
Route::post('/Caracterizacion/getInfoColegiosEstudiantes', 'Caracterizacion\CaracterizacionController@getInfoColegiosEstudiantes');
Route::post('/Caracterizacion/getInfoColegiosEstudiantes', 'Caracterizacion\CaracterizacionController@getInfoColegiosEstudiantes');
Route::post('/Caracterizacion/getInfoGruposEstudiantes', 'Caracterizacion\CaracterizacionController@getInfoGruposEstudiantes');
Route::post('/Caracterizacion/getInfoEstudiantes', 'Caracterizacion\CaracterizacionController@getInfoEstudiantes');
Route::post('/Caracterizacion/getInfoEstudiante', 'Caracterizacion\CaracterizacionController@getInfoEstudiante');







