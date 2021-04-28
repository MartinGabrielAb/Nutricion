<?php

use Illuminate\Support\Facades\Auth;
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
	if (Auth::check()) {
		$user = Auth::user();
        return view('home',compact('user'));
	}else{
    	return view('auth.login');
	}
});
// cmentario
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//menu
Route::middleware(['auth'])->group(function(){
	Route::post('menu','MenuController@store')->name('menu.store')->middleware('permission:menu.store');
	Route::get('menu','MenuController@index')->name('menu.index')->middleware('permission:menu.index');
	Route::get('menu/create','MenuController@create')->name('menu.create')->middleware('permission:menu.create');
	Route::put('menu/{id}','MenuController@update')->name('menu.update')->middleware('permission:menu.update');
	Route::get('menu/{id}','MenuController@show')->name('menu.show')->middleware('permission:menu.show');
	Route::delete('menu/{id}','MenuController@destroy')->name('menu.destroy')->middleware('permission:menu.destroy');
	Route::get('menu/{id}/edit','MenuController@edit')->name('menu.edit')->middleware('permission:menu.edit');
});
Route::resource('/menu','MenuController');
//salas
Route::middleware(['auth'])->group(function(){
	Route::post('salas','SalaController@store')->name('salas.store')->middleware('permission:salas.store');
	Route::get('salas','SalaController@index')->name('salas.index')->middleware('permission:salas.index');
	Route::get('salas/create','SalaController@create')->name('salas.create')->middleware('permission:salas.create');
	Route::put('salas/{id}','SalaController@update')->name('salas.update')->middleware('permission:salas.update');
	Route::get('salas/{id}','SalaController@show')->name('salas.show')->middleware('permission:salas.show');
	Route::delete('salas/{id}','SalaController@destroy')->name('salas.destroy')->middleware('permission:salas.destroy');
	Route::get('salas/{id}/edit','SalaController@edit')->name('salas.edit')->middleware('permission:salas.edit');
});
//pacientes
Route::middleware(['auth'])->group(function(){
	Route::post('pacientes','PacienteController@store')->name('pacientes.store')->middleware('permission:pacientes.store');
	Route::get('pacientes','PacienteController@index')->name('pacientes.index')->middleware('permission:pacientes.index');
	Route::get('pacientes/create','PacienteController@create')->name('pacientes.create')->middleware('permission:pacientes.create');
	Route::put('pacientes/{id}','PacienteController@update')->name('pacientes.update')->middleware('permission:pacientes.update');
	Route::get('pacientes/{id}','PacienteController@show')->name('pacientes.show')->middleware('permission:pacientes.show');
	Route::delete('pacientes/{id}','PacienteController@destroy')->name('pacientes.destroy')->middleware('permission:pacientes.destroy');
	Route::get('pacientes/{id}/edit','PacienteController@edit')->name('pacientes.edit')->middleware('permission:pacientes.edit');
});
// //profesionales // ****ver que se va a hacer con esta ruta. -> si se la borra ver permisos
// Route::middleware(['auth'])->group(function(){
// 	Route::post('profesionales/store','ProfesionalController@store')->name('profesionales.store')->middleware('permission:profesionales.store');
// 	Route::get('profesionales','ProfesionalController@index')->name('profesionales.index')->middleware('permission:profesionales.index');
// 	Route::get('profesionales/create','ProfesionalController@create')->name('profesionales.create')->middleware('permission:profesionales.create');
// 	Route::put('profesionales/{id}','ProfesionalController@update')->name('profesionales.update')->middleware('permission:profesionales.update');
// 	Route::get('profesionales/{id}','ProfesionalController@show')->name('profesionales.show')->middleware('permission:profesionales.show');
// 	Route::delete('profesionales/{id}','ProfesionalController@destroy')->name('profesionales.destroy')->middleware('permission:profesionales.destroy');
// 	Route::get('profesionales/{id}/edit','ProfesionalController@edit')->name('profesionales.edit')->middleware('permission:profesionales.edit');
// });
// //empleados // ****ver que se va a hacer con esta ruta.
// Route::middleware(['auth'])->group(function(){
// 	Route::post('empleados/store','EmpleadoController@store')->name('empleados.store')->middleware('permission:empleados.store');
// 	Route::get('empleados','EmpleadoController@index')->name('empleados.index')->middleware('permission:empleados.index');
// 	Route::get('empleados/create','EmpleadoController@create')->name('empleados.create')->middleware('permission:empleados.create');
// 	Route::put('empleados/{id}','EmpleadoController@update')->name('empleados.update')->middleware('permission:empleados.update');
// 	Route::get('empleados/{id}','EmpleadoController@show')->name('empleados.show')->middleware('permission:empleados.show');
// 	Route::delete('empleados/{id}','EmpleadoController@destroy')->name('empleados.destroy')->middleware('permission:empleados.destroy');
// 	Route::get('empleados/{id}/edit','EmpleadoController@edit')->name('empleados.edit')->middleware('permission:empleados.edit');
// });
//piezas
Route::middleware(['auth'])->group(function(){
	Route::post('piezas','PiezaController@store')->name('piezas.store')->middleware('permission:piezas.store');
	Route::get('piezas','PiezaController@index')->name('piezas.index')->middleware('permission:piezas.index');
	Route::get('piezas/create','PiezaController@create')->name('piezas.create')->middleware('permission:piezas.create');
	Route::put('piezas/{id}','PiezaController@update')->name('piezas.update')->middleware('permission:piezas.update');
	Route::get('piezas/{id}','PiezaController@show')->name('piezas.show')->middleware('permission:piezas.show');
	Route::delete('piezas/{id}','PiezaController@destroy')->name('piezas.destroy')->middleware('permission:piezas.destroy');
	Route::get('piezas/{id}/edit','PiezaController@edit')->name('piezas.edit')->middleware('permission:piezas.edit');
});
//camas
Route::middleware(['auth'])->group(function(){
	Route::post('camas','CamaController@store')->name('camas.store')->middleware('permission:camas.store');
	Route::get('camas','CamaController@index')->name('camas.index')->middleware('permission:camas.index');
	Route::get('camas/create','CamaController@create')->name('camas.create')->middleware('permission:camas.create');
	Route::put('camas/{id}','CamaController@update')->name('camas.update')->middleware('permission:camas.update');
	Route::get('camas/{id}','CamaController@show')->name('camas.show')->middleware('permission:camas.show');
	Route::delete('camas/{id}','CamaController@destroy')->name('camas.destroy')->middleware('permission:camas.destroy');
	Route::get('camas/{id}/edit','CamaController@edit')->name('camas.edit')->middleware('permission:camas.edit');
});
//menuportipopaciente
Route::middleware(['auth'])->group(function(){
	Route::post('menuportipopaciente','MenuPorTipoPacienteController@store')->name('menuportipopaciente.store')->middleware('permission:menuportipopaciente.store');
	Route::get('menuportipopaciente','MenuPorTipoPacienteController@index')->name('menuportipopaciente.index')->middleware('permission:menuportipopaciente.index');
	Route::get('menuportipopaciente/create','MenuPorTipoPacienteController@create')->name('menuportipopaciente.create')->middleware('permission:menuportipopaciente.create');
	Route::put('menuportipopaciente/{id}','MenuPorTipoPacienteController@update')->name('menuportipopaciente.update')->middleware('permission:menuportipopaciente.update');
	Route::get('menuportipopaciente/{id}','MenuPorTipoPacienteController@show')->name('menuportipopaciente.show')->middleware('permission:menuportipopaciente.show');
	Route::delete('menuportipopaciente/{id}','MenuPorTipoPacienteController@destroy')->name('menuportipopaciente.destroy')->middleware('permission:menuportipopaciente.destroy');
	Route::get('menuportipopaciente/{id}/edit','MenuPorTipoPacienteController@edit')->name('menuportipopaciente.edit')->middleware('permission:menuportipopaciente.edit');
});
//comidaportipopaciente
Route::middleware(['auth'])->group(function(){
	Route::post('comidaportipopaciente','ComidaPorTipoPacienteController@store')->name('comidaportipopaciente.store')->middleware('permission:comidaportipopaciente.store');
	Route::get('comidaportipopaciente','ComidaPorTipoPacienteController@index')->name('comidaportipopaciente.index')->middleware('permission:comidaportipopaciente.index');
	Route::get('comidaportipopaciente/create','ComidaPorTipoPacienteController@create')->name('comidaportipopaciente.create')->middleware('permission:comidaportipopaciente.create');
	Route::put('comidaportipopaciente/{id}','ComidaPorTipoPacienteController@update')->name('comidaportipopaciente.update')->middleware('permission:comidaportipopaciente.update');
	Route::get('comidaportipopaciente/{id}','ComidaPorTipoPacienteController@show')->name('comidaportipopaciente.show')->middleware('permission:comidaportipopaciente.show');
	Route::delete('comidaportipopaciente/{id}','ComidaPorTipoPacienteController@destroy')->name('comidaportipopaciente.destroy')->middleware('permission:comidaportipopaciente.destroy');
	Route::get('comidaportipopaciente/{id}/edit','ComidaPorTipoPacienteController@edit')->name('comidaportipopaciente.edit')->middleware('permission:comidaportipopaciente.edit');
});
//alimentos
Route::middleware(['auth'])->group(function(){
	Route::post('alimentos','AlimentoController@store')->name('alimentos.store')->middleware('permission:alimentos.store');
	Route::get('alimentos','AlimentoController@index')->name('alimentos.index')->middleware('permission:alimentos.index');
	Route::get('alimentos/create','AlimentoController@create')->name('alimentos.create')->middleware('permission:alimentos.create');
	Route::put('alimentos/{id}','AlimentoController@update')->name('alimentos.update')->middleware('permission:alimentos.update');
	Route::get('alimentos/{id}','AlimentoController@show')->name('alimentos.show')->middleware('permission:alimentos.show');
	Route::delete('alimentos/{id}','AlimentoController@destroy')->name('alimentos.destroy')->middleware('permission:alimentos.destroy');
	Route::get('alimentos/{id}/edit','AlimentoController@edit')->name('alimentos.edit')->middleware('permission:alimentos.edit');
});
//alimentosporproveedor
Route::middleware(['auth'])->group(function(){
	Route::post('alimentosporproveedor','AlimentoPorProveedorController@store')->name('alimentosporproveedor.store')->middleware('permission:alimentosporproveedor.store');
	Route::get('alimentosporproveedor','AlimentoPorProveedorController@index')->name('alimentosporproveedor.index')->middleware('permission:alimentosporproveedor.index');
	Route::get('alimentosporproveedor/create','AlimentoPorProveedorController@create')->name('alimentosporproveedor.create')->middleware('permission:alimentosporproveedor.create');
	Route::put('alimentosporproveedor/{id}','AlimentoPorProveedorController@update')->name('alimentosporproveedor.update')->middleware('permission:alimentosporproveedor.update');
	Route::get('alimentosporproveedor/{id}','AlimentoPorProveedorController@show')->name('alimentosporproveedor.show')->middleware('permission:alimentosporproveedor.show');
	Route::delete('alimentosporproveedor/{id}','AlimentoPorProveedorController@destroy')->name('alimentosporproveedor.destroy')->middleware('permission:alimentosporproveedor.destroy');
	Route::get('alimentosporproveedor/{id}/edit','AlimentoPorProveedorController@edit')->name('alimentosporproveedor.edit')->middleware('permission:alimentosporproveedor.edit');
});
//comidas
Route::middleware(['auth'])->group(function(){
	Route::post('comidas','ComidaController@store')->name('comidas.store')->middleware('permission:comidas.store');
	Route::get('comidas','ComidaController@index')->name('comidas.index')->middleware('permission:comidas.index');
	Route::get('comidas/create','ComidaController@create')->name('comidas.create')->middleware('permission:comidas.create');
	Route::put('comidas/{id}','ComidaController@update')->name('comidas.update')->middleware('permission:comidas.update');
	Route::get('comidas/{id}','ComidaController@show')->name('comidas.show')->middleware('permission:comidas.show');
	Route::delete('comidas/{id}','ComidaController@destroy')->name('comidas.destroy')->middleware('permission:comidas.destroy');
	Route::get('comidas/{id}/edit','ComidaController@edit')->name('comidas.edit')->middleware('permission:comidas.edit');

});
//alimentosporcomida
Route::middleware(['auth'])->group(function(){
	Route::post('alimentosporcomida','AlimentoPorComidaController@store')->name('alimentosporcomida.store')->middleware('permission:alimentosporcomida.store');
	Route::get('alimentosporcomida','AlimentoPorComidaController@index')->name('alimentosporcomida.index')->middleware('permission:alimentosporcomida.index');
	Route::get('alimentosporcomida/create','AlimentoPorComidaController@create')->name('alimentosporcomida.create')->middleware('permission:alimentosporcomida.create');
	Route::put('alimentosporcomida/{id}','AlimentoPorComidaController@update')->name('alimentosporcomida.update')->middleware('permission:alimentosporcomida.update');
	Route::get('alimentosporcomida/{id}','AlimentoPorComidaController@show')->name('alimentosporcomida.show')->middleware('permission:alimentosporcomida.show');
	Route::delete('alimentosporcomida/{id}','AlimentoPorComidaController@destroy')->name('alimentosporcomida.destroy')->middleware('permission:alimentosporcomida.destroy');
	Route::get('alimentosporcomida/{id}/edit','AlimentoPorComidaController@edit')->name('alimentosporcomida.edit')->middleware('permission:alimentosporcomida.edit');
});
//nutrientesporalimento
Route::middleware(['auth'])->group(function(){
	Route::post('nutrientesporalimento','NutrientePorAlimentoController@store')->name('nutrientesporalimento.store')->middleware('permission:nutrientesporalimento.store');
	Route::get('nutrientesporalimento','NutrientePorAlimentoController@index')->name('nutrientesporalimento.index')->middleware('permission:nutrientesporalimento.index');
	Route::get('nutrientesporalimento/create','NutrientePorAlimentoController@create')->name('nutrientesporalimento.create')->middleware('permission:nutrientesporalimento.create');
	Route::put('nutrientesporalimento/{id}','NutrientePorAlimentoController@update')->name('nutrientesporalimento.update')->middleware('permission:nutrientesporalimento.update');
	Route::get('nutrientesporalimento/{id}','NutrientePorAlimentoController@show')->name('nutrientesporalimento.show')->middleware('permission:nutrientesporalimento.show');
	Route::delete('nutrientesporalimento/{id}','NutrientePorAlimentoController@destroy')->name('nutrientesporalimento.destroy')->middleware('permission:nutrientesporalimento.destroy');
	Route::get('nutrientesporalimento/{id}/edit','NutrientePorAlimentoController@edit')->name('nutrientesporalimento.edit')->middleware('permission:nutrientesporalimento.edit');
});
//relevamientos
Route::middleware(['auth'])->group(function(){
	Route::post('relevamientos','RelevamientoController@store')->name('relevamientos.store')->middleware('permission:relevamientos.store');
	Route::get('relevamientos','RelevamientoController@index')->name('relevamientos.index')->middleware('permission:relevamientos.index');
	Route::get('relevamientos/create','RelevamientoController@create')->name('relevamientos.create')->middleware('permission:relevamientos.create');
	Route::put('relevamientos/{id}','RelevamientoController@update')->name('relevamientos.update')->middleware('permission:relevamientos.update');
	Route::get('relevamientos/{id}','RelevamientoController@show')->name('relevamientos.show')->middleware('permission:relevamientos.show');
	Route::delete('relevamientos/{id}','RelevamientoController@destroy')->name('relevamientos.destroy')->middleware('permission:relevamientos.destroy');
	Route::get('relevamientos/{id}/edit','RelevamientoController@edit')->name('relevamientos.edit')->middleware('permission:relevamientos.edit');
});
//detallesrelevamiento
Route::middleware(['auth'])->group(function(){
	Route::post('detallesrelevamiento','DetalleRelevamientoController@store')->name('detallesrelevamiento.store')->middleware('permission:detallesrelevamiento.store');
	Route::get('detallesrelevamiento','DetalleRelevamientoController@index')->name('detallesrelevamiento.index')->middleware('permission:detallesrelevamiento.index');
	Route::get('detallesrelevamiento/create','DetalleRelevamientoController@create')->name('detallesrelevamiento.create')->middleware('permission:detallesrelevamiento.create');
	Route::put('detallesrelevamiento/{id}','DetalleRelevamientoController@update')->name('detallesrelevamiento.update')->middleware('permission:detallesrelevamiento.update');
	Route::get('detallesrelevamiento/{id}','DetalleRelevamientoController@show')->name('detallesrelevamiento.show')->middleware('permission:detallesrelevamiento.show');
	Route::delete('detallesrelevamiento/{id}','DetalleRelevamientoController@destroy')->name('detallesrelevamiento.destroy')->middleware('permission:detallesrelevamiento.destroy');
	Route::get('detallesrelevamiento/{id}/edit','DetalleRelevamientoController@edit')->name('detallesrelevamiento.edit')->middleware('permission:detallesrelevamiento.edit');
});
//historial
Route::middleware(['auth'])->group(function(){
	Route::get('historial/elegirMenu/{idRelevamiento}', 'HistorialController@elegirMenu')->name('historial.elegirMenu')->middleware('permission:historial.elegirMenu');
	Route::post('historial','HistorialController@store')->name('historial.store')->middleware('permission:historial.store');
	Route::get('historial','HistorialController@index')->name('historial.index')->middleware('permission:historial.index');
	Route::get('historial/create','HistorialController@create')->name('historial.create')->middleware('permission:historial.create');
	Route::put('historial/{id}','HistorialController@update')->name('historial.update')->middleware('permission:historial.update');
	Route::get('historial/{id}','HistorialController@show')->name('historial.show')->middleware('permission:historial.show');
	Route::delete('historial/{id}','HistorialController@destroy')->name('historial.destroy')->middleware('permission:historial.destroy');
	Route::get('historial/{id}/edit','HistorialController@edit')->name('historial.edit')->middleware('permission:historial.edit');
});
//usuarios
Route::middleware(['auth'])->group(function(){
	Route::post('usuarios','UsuarioController@store')->name('usuarios.store')->middleware('permission:usuarios.store');
	Route::get('usuarios','UsuarioController@index')->name('usuarios.index')->middleware('permission:usuarios.index');
	Route::get('usuarios/create','UsuarioController@create')->name('usuarios.create')->middleware('permission:usuarios.create');
	Route::put('usuarios/{id}','UsuarioController@update')->name('usuarios.update')->middleware('permission:usuarios.update');
	Route::get('usuarios/{id}','UsuarioController@show')->name('usuarios.show')->middleware('permission:usuarios.show');
	Route::delete('usuarios/{id}','UsuarioController@destroy')->name('usuarios.destroy')->middleware('permission:usuarios.destroy');
	Route::get('usuarios/{id}/edit','UsuarioController@edit')->name('usuarios.edit')->middleware('permission:usuarios.edit');
});
//proveedores
Route::middleware(['auth'])->group(function(){
	Route::post('proveedores','ProveedorController@store')->name('proveedores.store')->middleware('permission:proveedores.store');
	Route::get('proveedores','ProveedorController@index')->name('proveedores.index')->middleware('permission:proveedores.index');
	Route::get('proveedores/create','ProveedorController@create')->name('proveedores.create')->middleware('permission:proveedores.create');
	Route::put('proveedores/{id}','ProveedorController@update')->name('proveedores.update')->middleware('permission:proveedores.update');
	Route::get('proveedores/{id}','ProveedorController@show')->name('proveedores.show')->middleware('permission:proveedores.show');
	Route::delete('proveedores/{id}','ProveedorController@destroy')->name('proveedores.destroy')->middleware('permission:proveedores.destroy');
	Route::get('proveedores/{id}/edit','ProveedorController@edit')->name('proveedores.edit')->middleware('permission:proveedores.edit');
});
//personas
Route::middleware(['auth'])->group(function(){
	Route::post('personas','PersonaController@store')->name('personas.store')->middleware('permission:personas.store');
	// Route::get('personas','PersonaController@index')->name('personas.index')->middleware('permission:personas.index');
	// Route::get('personas/create','PersonaController@create')->name('personas.create')->middleware('permission:personas.create');
	Route::put('personas/{id}','PersonaController@update')->name('personas.update')->middleware('permission:personas.update');
	// Route::get('personas/{id}','PersonaController@show')->name('personas.show')->middleware('permission:personas.show');
	// Route::delete('personas/{id}','PersonaController@destroy')->name('personas.destroy')->middleware('permission:personas.destroy');
	// Route::get('personas/{id}/edit','PersonaController@edit')->name('personas.edit')->middleware('permission:personas.edit');
});
//roles
Route::middleware(['auth'])->group(function(){
	Route::post('roles','RoleController@store')->name('roles.store')->middleware('permission:roles.store');
	Route::get('roles','RoleController@index')->name('roles.index')->middleware('permission:roles.index');
	Route::get('roles/create','RoleController@create')->name('roles.create')->middleware('permission:roles.create');
	Route::put('roles/{id}','RoleController@update')->name('roles.update')->middleware('permission:roles.update');
	Route::get('roles/{id}','RoleController@show')->name('roles.show')->middleware('permission:roles.show');
	Route::delete('roles/{id}','RoleController@destroy')->name('roles.destroy')->middleware('permission:roles.destroy');
	Route::get('roles/{id}/edit','RoleController@edit')->name('roles.edit')->middleware('permission:roles.edit');
});
Auth::routes();

// Las rutas comentadas habría que borrarlas
// Route::get('getPacientes','AjaxDataController@getPacientes')->name('ajaxData.getPacientes');

Route::get('getEmpleados','AjaxDataController@getEmpleados')->name('ajaxData.getEmpleados');

Route::get('getProfesionales','AjaxDataController@getProfesionales')->name('ajaxData.getProfesionales');

Route::get('getMenues','AjaxDataController@getMenues')->name('ajaxData.getMenues');
Route::get('getMenuTipo','AjaxDataController@getMenuTipo')->name('ajaxData.getMenuTipo');
Route::get('getComidaPorTipoPaciente','AjaxDataController@getComidaPorTipoPaciente')->name('ajaxData.getComidaPorTipoPaciente');

Route::get('getParticulares','AjaxDataController@getParticulares')->name('ajaxData.getParticulares');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('getAlimentos','AjaxDataController@getAlimentos')->name('ajaxData.getAlimentos');

Route::get('getComidas','AjaxDataController@getComidas')->name('ajaxData.getComidas');

Route::get('getNutrientesPorAlimento','AjaxDataController@getNutrientesPorAlimento')->name('ajaxData.getNutrientesPorAlimento');

Route::get('getRelevamientos','AjaxDataController@getRelevamientos')->name('ajaxData.getRelevamientos');


Route::get('getUsuarios','AjaxDataController@getUsuarios')->name('ajaxData.getUsuarios');
