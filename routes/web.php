<?php

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

use App\Rubro;

Route::get('/', function () {
    $rubros = Rubro::get()->sortByDesc('usuarios_asociados')->take(8);
    return view('welcome')->with('rubros', $rubros);
});

Route::get('/publicacion', function () {
    return view('publicacion');
});

Route::get('/nosotros', function () {
    return view('nosotros');
});

Route::get('/resultados/{comuna_id}/{rubro}', 'PublicacionController@index')->name('Listar rubros home');
Route::post('/publicaciones/busqueda/usuario', 'PublicacionController@index_buscador')->name('Listar rubros home');
Route::get('/publicacion/{id}', 'PublicacionController@ver')->name('Ver publicacion');

Route::get('/rubros/home', 'RubroController@index_home')->name('Listar rubros home');
Route::get('/publicaciones/rubro/{id}', 'RubroController@index_publicaciones')->name('Listar publicaciones por rubro');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/usuario/logeado', 'UsuarioController@logeado')->name('Usuario logeado');
Route::get('/usuarios/unico/{texto}', 'UsuarioController@validar_unico')->name('Validar usuario inexistente');
Route::post('/recuperar/contraseña', 'UsuarioController@recuperar_clave')->name('Recuperar clave');

//Rutas de rubros
Route::get('/rubros/{tipo}', 'RubroController@index')->name('Listar rubros');
Route::post('/rubro/crear/actualizar', 'RubroController@crear_actualizar')->name('Crear o actualizar rubro');
Route::post('/rubro/borrar', 'RubroController@borrar')->name('Borrar rubro');

//Rutas de provincia
Route::get('/provincias/{tipo}', 'ProvinciaController@index')->name('Listar provincias');
Route::post('/provincia/crear/actualizar', 'ProvinciaController@crear_actualizar')->name('Crear o Actualizar provincia');
Route::post('/provincia/borrar', 'ProvinciaController@borrar')->name('Borrar Provincia');

//Rutas de comuna
Route::get('/provincias/comuna/{id}', 'ProvinciaController@index_comuna')->name('Listar comunas de provincia');
Route::get('/comunas/{tipo}', 'ProvinciaController@index_comunas')->name('Listar todas las comunas');
Route::post('/comuna/crear/actualizar', 'ProvinciaController@crear_actualizar_comuna')->name('Crear o Actualizar comunas de provincia');
Route::post('/comuna/borrar', 'ProvinciaController@borrar_comuna')->name('Borrar comunas de provincia Provincia');

//Rutas de planes
Route::get('/planes/{tipo}', 'PlanController@index')->name('Listar planes');
Route::post('/plan/crear/actualizar', 'PlanController@crear_actualizar')->name('Crear o Actualizar plan');
Route::post('/plan/borrar', 'PlanController@borrar')->name('Borrar plan');

//Rutas de usuarios
Route::get('/usuarios/{tipo}', 'UsuarioController@index')->name('Listar usuarios');
Route::post('/usuario/crear/actualizar', 'UsuarioController@crear_actualizar')->name('Crear o Actualizar usuario');
Route::post('/usuario/borrar', 'UsuarioController@borrar')->name('Borrar usuario');
Route::post('/usuario/cambiar/clave', 'UsuarioController@cambiar_clave')->name('Cambiar clave');
Route::post('/usuario/cambiar/sociales', 'UsuarioController@cambiar_sociales')->name('Cambiar sociales');
Route::post('/usuario/cambiar/foto', 'UsuarioController@cambiar_foto')->name('Cambiar foto');
Route::post('/usuario/eliminar/foto', 'UsuarioController@eliminar_foto')->name('Elimnar foto');


Route::post('/usuario/agregar/comunas', 'UsuarioController@agregar_comunas')->name('Agregar comunas al usuario');
Route::get('/usuario/comunas/{id}', 'UsuarioController@index_comunas_usuario')->name('Obtener comunas usuario');
Route::post('/usuario/comuna/borrar', 'UsuarioController@borrar_comuna_usuario')->name('Borrar comunas usuario');

Route::post('/usuario/agregar/rubros', 'UsuarioController@agregar_rubros')->name('Agregar rubros al usuario');
Route::get('/usuario/rubros/{id}', 'UsuarioController@index_rubros_usuario')->name('Obtener rubros usuario');
Route::post('/usuario/rubro/borrar', 'UsuarioController@borrar_rubro_usuario')->name('Borrar rubros usuario');

Route::post('/usuario/crear/actualizar/publicacion', 'UsuarioController@agregar_publicaciones')->name('Agregar publicaciones al usuario');
Route::get('/usuario/publicaciones/{id}', 'UsuarioController@index_publicaciones_usuario')->name('Obtener publicaciones usuario');
Route::post('/usuario/publicacion/borrar', 'UsuarioController@borrar_publicaciones')->name('Borrar publicaciones usuario');

Route::get('/{any}', 'HomeController@index')->where('any', '.*')->name('home');
