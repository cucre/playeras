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
    return redirect()->route('login');
});

Route::get('logout', 'Auth\LoginController@logout');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Configuración
Route::get('/config/usuarios/data','UserController@data')->name('usuarios.data');
Route::resource('/config/usuarios','UserController');
Route::resource('/config/permisos','PermissionController');
Route::get('/config/colores/data','ColorController@data')->name('colores.data');
Route::resource('/config/colores','ColorController')->parameters([
    'colores' => 'color'
]);
//CRUD Marca
Route::get('/config/marcas/data', 'BrandController@data')->name('marcas.data');
Route::resource('/config/marcas', 'BrandController')->parameters([
    'marcas' => 'brand'
]);
Route::get('/config/tallas/data','TallaController@data')->name('tallas.data');
Route::resource('/config/tallas','TallaController');
//CRUD Producto
Route::get('/config/productos/data', 'ProductController@data')->name('productos.data');
Route::resource('/config/productos', 'ProductController')->parameters([
    'productos' => 'product'
]);

//Estadísticas
Route::get('/estadisticas','StatisticsController@index')->name('statistics.index');

//Inventario
Route::get('/inventario/data', 'InventoryController@data')->name('inventario.data');
Route::get('/inventario/get_product', 'InventoryController@get_product')->name('inventario.get_product');
Route::resource('/inventario', 'InventoryController')->only(['index', 'store']);