<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ModuloCategorias;
use App\Http\Livewire\ModuloProductos;

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
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/categorias', ModuloCategorias::class)->name('categorias');
    Route::get('/productos', ModuloProductos::class)->name('productos');
});
