<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//registrar usuarios
Route::post('/auth/register',[AuthController::class, 'register']);
//loggear
Route::post('/auth/login',[AuthController::class, 'login']);
//cerrar sesion
Route::post('/auth/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');

//ruta para categorias de productos
Route::apiResource('/category',CategoryController::class);
//ruta de pagos
Route::apiResource('/pay',PayController::class);
// ruta direccion domicilio
Route::apiResource('/site',SiteController::class);
//creacion de productos
Route::apiResource('/product',ProductController::class);
