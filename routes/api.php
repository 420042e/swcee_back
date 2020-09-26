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
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CategoriaController;

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
Route::apiResource('buscarci',BuscarCIController::class);

Route::group(['middleware'=>'auth:api'], function(){
    Route::apiResource('eventos', EventoController::class);
    Route::apiResource('categoria', CategoriaController::class);
    Route::apiResource('email', EmailRController::class);
    Route::apiResource('asistentes', AsistenteController::class);
    Route::apiResource('confirmacionci', ConfirmacionCIController::class);
    Route::apiResource('confirmacionqr', ConfirmacionQRController::class);
    Route::apiResource('asistencia', AsistenciaController::class);
    Route::apiResource('reporte', ReporteController::class);
    Route::apiResource('certificado', CertificadoController::class);
    Route::get('users',[UserController::class, 'index']);
    Route::put('users/{user}',[UserController::class, 'update']);
    Route::post('logout',[UserController::class, 'logout']);
});