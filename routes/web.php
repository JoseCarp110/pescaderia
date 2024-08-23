<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Ruta publica para la pagina de inicio
Route::get('/', [HomeController::class, 'mostrarProductos'])->name('home');

// Ruta protegida para productos (requiere autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index');
    Route::get('/productos/create', [ProductosController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');
});

// Autenticación de Laravel
Auth::routes();

// Ruta protegida para el home de usuarios autenticados
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
