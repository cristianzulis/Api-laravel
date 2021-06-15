<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Resources\CategoriasResource;
use App\Models\Categorias;
use App\Models\Productos;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categorias', function () {
    $todo = Categorias::all();
    return response()->json(['status' => 'success', $todo, 200]);
});

Route::get('/productos', function () {
    $prods = Productos::with('imagenes')->get();
    return response()->json(['status' => 'success', $prods, 200]);
});

Route::get('/productos/{subnivel}', function ($subnivel) {
    $prods = Productos::where('id_categoria', $subnivel)->with('imagenes')->get();
    return response()->json(['status' => 'success', $prods, 200]);
});

