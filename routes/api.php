<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PublicidadController as Publicidad;
use App\Http\Controllers\Api\V1\CaracteristicaController as Caracteristica;
use App\Http\Controllers\Api\V1\GeneralController as General;
use App\Http\Controllers\Api\V1\DireccionController as Direccion;
use App\Http\Controllers\Api\V1\ContactoController as Contacto;
use App\Http\Controllers\Api\V1\AsesorController as Asesor;
use App\Http\Controllers\Api\AuthController as Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [Auth::class, 'login']);
Route::post('/register', [Auth::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/v1/publicidad', Publicidad::class);
    Route::apiResource('/v1/caracteristica', Caracteristica::class);
    Route::apiResource('/v1/general', General::class);
    Route::apiResource('/v1/direccion', Direccion::class);
    Route::apiResource('/v1/contacto', Contacto::class);
    Route::apiResource('/v1/asesor', Asesor::class);
});
