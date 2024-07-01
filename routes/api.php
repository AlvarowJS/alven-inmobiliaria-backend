<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PublicidadController as Publicidad;
use App\Http\Controllers\Api\V1\CaracteristicaController as Caracteristica;
use App\Http\Controllers\Api\V1\GeneralController as General;
use App\Http\Controllers\Api\V1\DireccionController as Direccion;
use App\Http\Controllers\Api\V1\ContactoController as Contacto;
use App\Http\Controllers\Api\V1\AsesorController as Asesor;
use App\Http\Controllers\Api\V1\ClienteController as Cliente;
use App\Http\Controllers\Api\V1\PropiedadController as Propiedad;
use App\Http\Controllers\Api\V1\BasicoController as Basico;
use App\Http\Controllers\Api\V1\FotoController as Foto;
use App\Http\Controllers\Api\V1\MedioController as Medio;
use App\Http\Controllers\Api\V1\PresentacionController as Presentacion;
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

// Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/v1/publicidad', Publicidad::class);
    Route::apiResource('/v1/caracteristica', Caracteristica::class);
    Route::apiResource('/v1/general', General::class);
    Route::apiResource('/v1/direccion', Direccion::class);
    Route::apiResource('/v1/contacto', Contacto::class);
    Route::apiResource('/v1/asesor', Asesor::class);
    Route::apiResource('/v1/cliente', Cliente::class);
    Route::apiResource('/v1/propiedades', Propiedad::class);
    Route::apiResource('/v1/basicos', Basico::class);
    Route::apiResource('/v1/medios', Medio::class);
    Route::apiResource('/v1/fotos', Foto::class);
    Route::apiResource('/v1/presentacion', Presentacion::class);

    Route::put('/v1/cliente-id/{id}', [Cliente::class, 'registarIdCliente']);
    Route::post('/v1/fotos-img', [Foto::class, 'update_fotos']);
    Route::post('/v1/registrar-cliente', [Cliente::class, 'registarCliente']);
    Route::put('/v1/actualizar-propiedad/{id}', [Propiedad::class, 'actualizarEstado']);
    Route::put('/v1/estado-propiedad/{id}', [Propiedad::class, 'cambiarEstado']);
    Route::post('/v1/publicidad-mapa', [Publicidad::class, 'update_fotos']);
    Route::post('/v1/presentacion-foto', [Presentacion::class, 'updateFoto']);
    
// });

Route::get('/v1/propiedades-publico', [Propiedad::class, 'indexTrue']);
Route::get('/v1/exportar-propiedad/{id},{id_user}/{estado}', [Propiedad::class, 'exportarPDF']);
Route::get('/v1/ver-propiedad/{id}', [Propiedad::class, 'show']);
Route::post('/v1/contacto-register', [Contacto::class, 'store']);
Route::post('/v1/asesor-foto', [Asesor::class, 'update_fotos']);
Route::get('/v1/asesor-publico', [Asesor::class, 'indexPublic']);
Route::post('/v1/ordernar-fotos', [Foto::class, 'ordenar']);

Route::get('/v1/general-id', [General::class, 'generarId']);
Route::post('/v1/propiedad-filtrado', [Propiedad::class, 'filtrarStatus']);

Route::get('/v1/exportexcel/{status}/{asesor}/{inicio}/{fin}', [Propiedad::class, 'export']);
// Route::get('/v1/exportexcel', [Propiedad::class, 'export']);
