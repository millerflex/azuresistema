<?php

use Illuminate\Support\Facades\Route;




use App\Http\Controllers\ChatController;

Route::get('/chatbot', [ChatController::class, 'form']);
Route::post('/chatbot', [ChatController::class, 'handle']);

Route::get('/', function () {
    return redirect('admin');
});


Route::post('/chat', [ChatController::class, 'chat']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('home');

//Ruta para ir a la vista principal
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware('auth');

//Rutas para usuario - empresa
Route::get('/crear_empresa', [App\Http\Controllers\EmpresaController::class, 'create'])->name('admin.empresas.create');
//Ruta para mostrar las provincias al seleccionar un país mediante ajax 
Route::get('/crear_empresa/pais/{id_pais}', [App\Http\Controllers\EmpresaController::class, 'buscar_estado'])->name('admin.empresas.create.buscar_estado');
//Ruta para mostrar las ciudades al seleccionar un estado/provincia mediante ajax 
Route::get('/crear_empresa/estado/{id_estado}', [App\Http\Controllers\EmpresaController::class, 'buscar_ciudad'])->name('admin.empresas.create.buscar_ciudad');
Route::post('/crear_empresa/create', [App\Http\Controllers\EmpresaController::class, 'store'])->name('admin.empresas.store');

//Rutas para configuracion
Route::get('/admin/configuracion', [App\Http\Controllers\EmpresaController::class, 'edit'])->name('admin.configuracion.edit')->middleware('auth', 'can:Configuracion del sistema');
//Ruta para mostrar las provincias al seleccionar un país mediante ajax 
Route::get('/admin/configuracion/pais/{id_pais}', [App\Http\Controllers\EmpresaController::class, 'buscar_estado'])->name('admin.configuracion.empresas.create.buscar_estado');
//Ruta para mostrar las ciudades al seleccionar un estado/provincia mediante ajax 
Route::get('/admin/configuracion/estado/{id_estado}', [App\Http\Controllers\EmpresaController::class, 'buscar_ciudad'])->name('admin.configuracion.empresas.create.buscar_ciudad');
Route::put('/admin/configuracion/{id}', [App\Http\Controllers\EmpresaController::class, 'update'])->name('admin.configuracion.update')->middleware('auth');

//Rutas para Roles
Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index')->middleware('auth', 'can:roles - index');
Route::get('/admin/roles/reporte', [App\Http\Controllers\RoleController::class, 'reporte'])->name('admin.roles.reporte')->middleware('auth');
Route::get('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('admin.roles.create')->middleware('auth', 'can:roles - create');
Route::post('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store')->middleware('auth');
Route::get('/admin/roles/show/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('admin.roles.show')->middleware('auth', 'can:roles - show');
Route::get('/admin/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('auth', 'can:roles - edit');
Route::get('/admin/roles/{id}/asignar', [App\Http\Controllers\RoleController::class, 'asignar'])->name('admin.roles.asignar')->middleware('auth');
Route::put('/admin/roles/asignar/{id}', [App\Http\Controllers\RoleController::class, 'update_asignar'])->name('admin.roles.update_asignar')->middleware('auth');
Route::put('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update')->middleware('auth');
Route::delete('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth', 'can:roles - delete');

//Rutas para Permisos
Route::get('/admin/permisos', [App\Http\Controllers\PermisoController::class, 'index'])->name('admin.permisos.index')->middleware('auth', 'can:permiso - index');
//Route::get('/admin/permisos/reporte', [App\Http\Controllers\PermisoController::class, 'reporte'])->name('admin.permisos.reporte')->middleware('auth');
Route::get('/admin/permisos/create', [App\Http\Controllers\PermisoController::class, 'create'])->name('admin.permisos.create')->middleware('auth', 'can:permiso - create');
Route::post('/admin/permisos/create', [App\Http\Controllers\PermisoController::class, 'store'])->name('admin.permisos.store')->middleware('auth');
Route::get('/admin/permisos/show/{id}', [App\Http\Controllers\PermisoController::class, 'show'])->name('admin.permisos.show')->middleware('auth', 'can:permiso - show');
Route::get('/admin/permisos/{id}/edit', [App\Http\Controllers\PermisoController::class, 'edit'])->name('admin.permisos.edit')->middleware('auth', 'can:permiso - edit');
Route::put('/admin/permisos/{id}', [App\Http\Controllers\PermisoController::class, 'update'])->name('admin.permisos.update')->middleware('auth');
Route::delete('/admin/permisos/{id}', [App\Http\Controllers\PermisoController::class, 'destroy'])->name('admin.permisos.destroy')->middleware('auth', 'can:permiso - delete');

//Rutas para usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware('auth', 'can:usuarios - index');
Route::get('/admin/usuarios/reporte', [App\Http\Controllers\UsuarioController::class, 'reporte'])->name('admin.usuarios.reporte')->middleware('auth', 'can:usuarios - reportes');
Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware('auth', 'can:usuarios - create');
Route::post('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware('auth');
Route::get('/admin/usuarios/show/{id}', [App\Http\Controllers\UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware('auth', 'can:usuarios - show');
Route::get('/admin/usuarios/{id}/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware('auth', 'can:usuarios - edit');
Route::put('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware('auth');
Route::delete('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware('auth', 'can:usuarios - delete');

//Rutas para categorias
Route::get('/admin/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('admin.categorias.index')->middleware('auth', 'can:categorias - index');
Route::get('/admin/categorias/reporte', [App\Http\Controllers\CategoriaController::class, 'reporte'])->name('admin.categorias.reporte')->middleware('auth', 'can:categorias - reportes');
Route::get('/admin/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('admin.categorias.create')->middleware('auth', 'can:categorias - create');
Route::post('/admin/categorias/create', [App\Http\Controllers\CategoriaController::class, 'store'])->name('admin.categorias.store')->middleware('auth');
Route::get('/admin/categorias/show/{id}', [App\Http\Controllers\CategoriaController::class, 'show'])->name('admin.categorias.show')->middleware('auth', 'can:categorias - show');
Route::get('/admin/categorias/{id}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('admin.categorias.edit')->middleware('auth', 'can:categorias - edit');
Route::put('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('admin.categorias.update')->middleware('auth');
Route::delete('/admin/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('admin.categorias.destroy')->middleware('auth', 'can:categorias - delete');

//Rutas para productos
Route::get('/admin/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('admin.productos.index')->middleware('auth', 'can:productos - index');
Route::get('/admin/productos/reporte', [App\Http\Controllers\ProductoController::class, 'reporte'])->name('admin.productos.reporte')->middleware('auth', 'can:productos - reportes');
Route::get('/admin/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('admin.productos.create')->middleware('auth', 'can:productos - create');
Route::post('/admin/productos/create', [App\Http\Controllers\ProductoController::class, 'store'])->name('admin.productos.store')->middleware('auth');
Route::get('/admin/productos/show/{id}', [App\Http\Controllers\ProductoController::class, 'show'])->name('admin.productos.show')->middleware('auth', 'can:productos - show');
Route::get('/admin/productos/{id}/edit', [App\Http\Controllers\ProductoController::class, 'edit'])->name('admin.productos.edit')->middleware('auth', 'can:productos - edit');
Route::put('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('admin.productos.update')->middleware('auth');
Route::delete('/admin/productos/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('admin.productos.destroy')->middleware('auth', 'can:productos - delete');

//Rutas para proveedores
Route::get('/admin/proveedores', [App\Http\Controllers\ProveedorController::class, 'index'])->name('admin.proveedores.index')->middleware('auth', 'can:proveedores - index');
Route::get('/admin/proveedores/reporte', [App\Http\Controllers\ProveedorController::class, 'reporte'])->name('admin.proveedores.reporte')->middleware('auth', 'can:proveedores - reportes');
Route::get('/admin/proveedores/create', [App\Http\Controllers\ProveedorController::class, 'create'])->name('admin.proveedores.create')->middleware('auth', 'can:proveedores - create');
Route::post('/admin/proveedores/create', [App\Http\Controllers\ProveedorController::class, 'store'])->name('admin.proveedores.store')->middleware('auth');
Route::get('/admin/proveedores/show/{id}', [App\Http\Controllers\ProveedorController::class, 'show'])->name('admin.proveedores.show')->middleware('auth', 'can:proveedores - show');
Route::get('/admin/proveedores/{id}/edit', [App\Http\Controllers\ProveedorController::class, 'edit'])->name('admin.proveedores.edit')->middleware('auth', 'can:proveedores - edit');
Route::put('/admin/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'update'])->name('admin.proveedores.update')->middleware('auth');
Route::delete('/admin/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'destroy'])->name('admin.proveedores.destroy')->middleware('auth', 'can:proveedores - delete');

//Rutas para compras
Route::get('/admin/compras', [App\Http\Controllers\CompraController::class, 'index'])->name('admin.compras.index')->middleware('auth', 'can:compras - index');
Route::get('/admin/compras/reporte', [App\Http\Controllers\CompraController::class, 'reporte'])->name('admin.compras.reporte')->middleware('auth', 'can:compras - reportes');
Route::get('/admin/compras/create', [App\Http\Controllers\CompraController::class, 'create'])->name('admin.compras.create')->middleware('auth', 'can:compras - create');
Route::post('/admin/compras/create', [App\Http\Controllers\CompraController::class, 'store'])->name('admin.compras.store')->middleware('auth');
Route::get('/admin/compras/show/{id}', [App\Http\Controllers\CompraController::class, 'show'])->name('admin.compras.show')->middleware('auth', 'can:compras - show');
Route::get('/admin/compras/{id}/edit', [App\Http\Controllers\CompraController::class, 'edit'])->name('admin.compras.edit')->middleware('auth', 'can:compras - edit');
Route::put('/admin/compras/{id}', [App\Http\Controllers\CompraController::class, 'update'])->name('admin.compras.update')->middleware('auth');
Route::delete('/admin/compras/{id}', [App\Http\Controllers\CompraController::class, 'destroy'])->name('admin.compras.destroy')->middleware('auth', 'can:compras - delete');

//Rutas para compras temporales
Route::post('/admin/compras/create/tmp', [App\Http\Controllers\TmpCompraController::class, 'tmp_compras'])->name('admin.compras.tmp_compras')->middleware('auth');
Route::delete('/admin/compras/create/tmp/{id}', [App\Http\Controllers\TmpCompraController::class, 'destroy'])->name('admin.compras.tmp_compras.destroy')->middleware('auth');

//Rutas para los detalles de las compras
Route::post('/admin/compras/detalle/create', [App\Http\Controllers\DetalleCompraController::class, 'store'])->name('admin.detalle.compras')->middleware('auth');
Route::delete('/admin/compras/detalle/{id}', [App\Http\Controllers\DetalleCompraController::class, 'destroy'])->name('admin.detalle.compras.destroy')->middleware('auth');

//Rutas para clientes
Route::get('/admin/clientes', [App\Http\Controllers\ClienteController::class, 'index'])->name('admin.clientes.index')->middleware('auth', 'can:clientes - index');
Route::get('/admin/clientes/reporte', [App\Http\Controllers\ClienteController::class, 'reporte'])->name('admin.clientes.reporte')->middleware('auth', 'can:clientes - reportes');
Route::get('/admin/clientes/create', [App\Http\Controllers\ClienteController::class, 'create'])->name('admin.clientes.create')->middleware('auth', 'can:clientes - create');
Route::post('/admin/clientes/create', [App\Http\Controllers\ClienteController::class, 'store'])->name('admin.clientes.store')->middleware('auth');
Route::get('/admin/clientes/show/{id}', [App\Http\Controllers\ClienteController::class, 'show'])->name('admin.clientes.show')->middleware('auth', 'can:clientes - show');
Route::get('/admin/clientes/{id}/edit', [App\Http\Controllers\ClienteController::class, 'edit'])->name('admin.clientes.edit')->middleware('auth', 'can:clientes - edit');
Route::put('/admin/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'update'])->name('admin.clientes.update')->middleware('auth');
Route::delete('/admin/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'destroy'])->name('admin.clientes.destroy')->middleware('auth', 'can:clientes - delete');

//Rutas para ventas
Route::get('/admin/ventas', [App\Http\Controllers\VentaController::class, 'index'])->name('admin.ventas.index')->middleware('auth', 'can:ventas - index');
Route::get('/admin/ventas/reporte', [App\Http\Controllers\VentaController::class, 'reporte'])->name('admin.ventas.reporte')->middleware('auth', 'can:ventas - reportes');
Route::get('/admin/ventas/create', [App\Http\Controllers\VentaController::class, 'create'])->name('admin.ventas.create')->middleware('auth', 'can:ventas - create');
Route::post('/admin/ventas/create', [App\Http\Controllers\VentaController::class, 'store'])->name('admin.ventas.store')->middleware('auth');
Route::get('/admin/ventas/pdf/{id}', [App\Http\Controllers\VentaController::class, 'pdf'])->name('admin.ventas.pdf')->middleware('auth', 'can:ventas - impresion - factura');
Route::get('/admin/ventas/show/{id}', [App\Http\Controllers\VentaController::class, 'show'])->name('admin.ventas.show')->middleware('auth', 'can:ventas - show');
Route::get('/admin/ventas/{id}/edit', [App\Http\Controllers\VentaController::class, 'edit'])->name('admin.ventas.edit')->middleware('auth', 'can:ventas - edit');
Route::put('/admin/ventas/{id}', [App\Http\Controllers\VentaController::class, 'update'])->name('admin.ventas.update')->middleware('auth');
Route::delete('/admin/ventas/{id}', [App\Http\Controllers\VentaController::class, 'destroy'])->name('admin.ventas.destroy')->middleware('auth', 'can:ventas - delete');
Route::post('/admin/ventas/cliente/create', [App\Http\Controllers\VentaController::class, 'store_cliente'])->name('admin.ventas.cliente.store')->middleware('auth');

//Rutas para ventas temporales
Route::post('/admin/ventas/create/tmp', [App\Http\Controllers\TmpVentaController::class, 'tmp_ventas'])->name('admin.ventas.tmp_ventas')->middleware('auth');
Route::delete('/admin/ventas/create/tmp/{id}', [App\Http\Controllers\TmpVentaController::class, 'destroy'])->name('admin.ventas.tmp_ventas.destroy')->middleware('auth');

//Rutas para los detalles de las ventas
Route::post('/admin/ventas/detalle/create', [App\Http\Controllers\DetalleVentaController::class, 'store'])->name('admin.detalle.ventas')->middleware('auth');
Route::delete('/admin/ventas/detalle/{id}', [App\Http\Controllers\DetalleVentaController::class, 'destroy'])->name('admin.detalle.ventas.destroy')->middleware('auth');

//Rutas para arqueo de caja
Route::get('/admin/arqueos', [App\Http\Controllers\ArqueoController::class, 'index'])->name('admin.arqueos.index')->middleware('auth', 'can:arqueos - index');
Route::get('/admin/arqueos/reporte', [App\Http\Controllers\ArqueoController::class, 'reporte'])->name('admin.arqueos.reporte')->middleware('auth', 'can:arqueos - reportes');
Route::get('/admin/arqueos/create', [App\Http\Controllers\ArqueoController::class, 'create'])->name('admin.arqueos.create')->middleware('auth', 'can:arqueos - create');
Route::post('/admin/arqueos/create', [App\Http\Controllers\ArqueoController::class, 'store'])->name('admin.arqueos.store')->middleware('auth');
Route::get('/admin/arqueos/show/{id}', [App\Http\Controllers\ArqueoController::class, 'show'])->name('admin.arqueos.show')->middleware('auth', 'can:arqueos - show');
Route::get('/admin/arqueos/{id}/edit', [App\Http\Controllers\ArqueoController::class, 'edit'])->name('admin.arqueos.edit')->middleware('auth', 'can:arqueos - edit');
Route::get('/admin/arqueos/{id}/ingreso-egreso', [App\Http\Controllers\ArqueoController::class, 'ingresoegreso'])->name('admin.arqueos.ingresoegreso')->middleware('auth', 'can:arqueos - ingresos - egresos');
Route::post('/admin/arqueos/create_ingreso_egreso', [App\Http\Controllers\ArqueoController::class, 'store_ingreso_egreso'])->name('admin.arqueos.store_ingreso_egreso')->middleware('auth');
Route::put('/admin/arqueos/{id}', [App\Http\Controllers\ArqueoController::class, 'update'])->name('admin.arqueos.update')->middleware('auth');
Route::delete('/admin/arqueos/{id}', [App\Http\Controllers\ArqueoController::class, 'destroy'])->name('admin.arqueos.destroy')->middleware('auth', 'can:arqueos - delete');
Route::get('/admin/arqueos/{id}/cierre', [App\Http\Controllers\ArqueoController::class, 'cierre'])->name('admin.arqueos.cierre')->middleware('auth', 'can:arqueos - cierre - caja');
Route::post('/admin/arqueos/create_cierre', [App\Http\Controllers\ArqueoController::class, 'store_cierre'])->name('admin.arqueos.store_cierre')->middleware('auth');