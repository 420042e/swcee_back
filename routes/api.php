<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailRController;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\ConfirmacionCIController;
use App\Http\Controllers\ConfirmacionQRController;
use App\Http\Controllers\BuscarCIController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemIController;
use App\Http\Controllers\ImgSController;
use App\Http\Controllers\MembreteController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TAsistenteController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\SendMailUserController;
use App\Http\Controllers\UsrConfigController;
use App\Http\Controllers\ItemQRController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\TieneRecursoController;
use App\Http\Controllers\TipoRecursoController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users',[UserController::class, 'store']);

Route::post('login',[UserController::class, 'login']);

Route::apiResource('registro', RegistroController::class);
Route::apiResource('buscarci', BuscarCIController::class);
Route::apiResource('enviarcorreo', SendMailController::class);
Route::apiResource('enviarcorreouser', SendMailUserController::class);

Route::get('membrete/{filename}', [MembreteController::class, 'show']);
Route::get('imgs/{filename}', [ImgSController::class, 'show']);
Route::get('itemQR/{filename}', [ItemQRController::class, 'show']);

Route::apiResource('archivo', ArchivoController::class);
Route::get('descargarArchi/{filename}', [ArchivoController::class, 'descargarArchi']);

Route::group(['middleware'=>'auth:api'], function(){
    Route::apiResource('eventos', EventoController::class);
    Route::apiResource('categoria', CategoriaController::class);
    Route::apiResource('tipo_asistente', TAsistenteController::class);
    Route::apiResource('tipo_recurso', TipoRecursoController::class);
    Route::apiResource('email', EmailRController::class);
    Route::apiResource('asistentes', AsistenteController::class);
    Route::apiResource('confirmacionci', ConfirmacionCIController::class);
    Route::apiResource('confirmacionqr', ConfirmacionQRController::class);
    Route::apiResource('asistencia', AsistenciaController::class);
    Route::apiResource('rol', RolController::class);
    Route::apiResource('reporte', ReporteController::class);
    Route::apiResource('certificado', CertificadoController::class);
    Route::get('certificado64/{id_certificado}', [CertificadoController::class, 'certificado64']);
    Route::apiResource('itemQR', ItemQRController::class);
    Route::get('generarQR64', [ItemQRController::class, 'generarQR64']);
    Route::get('itemQR64/{id_certificado}', [ItemQRController::class, 'itemQR64']);
    Route::apiResource('item', ItemController::class);
    Route::apiResource('itemsi', ItemIController::class);
    Route::apiResource('recurso', RecursoController::class);
    Route::apiResource('tieneRecurso', TieneRecursoController::class);
    //Route::apiResource('archivo', ArchivoController::class);
    //Route::get('descargarArchi/{filename}', [ArchivoController::class, 'descargarArchi']);
    Route::get('itemsi64/{id_certificado}', [ItemIController::class, 'itemsi64']);
    //Route::apiResource('imgs', ImgSController::class);
    //Route::apiResource('membrete', MembreteController::class);
    Route::get('membrete', [MembreteController::class, 'index']);
    Route::post('membrete', [MembreteController::class, 'store']);
    Route::delete('membrete/{filename}', [MembreteController::class, 'destroy']);
    Route::get('imgs', [ImgSController::class, 'index']);
    Route::post('imgs', [ImgSController::class, 'store']);
    Route::delete('imgs/{filename}', [ImgSController::class, 'destroy']);
    Route::get('users',[UserController::class, 'index']);
    Route::get('users/{user}',[UserController::class, 'show']);
    Route::put('users/{user}',[UserController::class, 'update']);
    Route::put('usrconfig/{user}',[UsrConfigController::class, 'update']);
    Route::delete('users/{user}',[UserController::class, 'destroy']);
    Route::post('verificar',[UserController::class, 'verificarPass']);
    Route::post('logout',[UserController::class, 'logout']);
});