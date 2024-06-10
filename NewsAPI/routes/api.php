<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiNewsController;
use App\Http\Controllers\ApiComunidadesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiFiltrosController;
use App\Http\Controllers\ApiUsuariosController;
use App\Http\Controllers\ApiNoticiasNoConfirmadasController;
use App\Http\Controllers\ApiNoticiasEliminadasController;
use App\Http\Controllers\ApiComunidadesNoConfirmadasController;
use App\Http\Controllers\ApiLoginController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('news', ApiNewsController::class);
    Route::apiResource('comunidades', ApiComunidadesController::class);
    Route::apiResource('newsFilters', ApiFiltrosController::class);
    Route::apiResource('usuarios', ApiUsuariosController::class);
    Route::apiResource('noticiasNoConfirmadas', ApiNoticiasNoConfirmadasController::class);
    Route::apiResource('noticiasEliminadas', ApiNoticiasEliminadasController::class);
    Route::apiResource('comunidadesNoConfirmadas', ApiComunidadesNoConfirmadasController::class);
    Route::post("inicioSesion",[ApiLoginController::class,'login']);
    Route::delete('/noticiasNoConfirmadas/{id}/archive', [ApiNoticiasEliminadasController::class, 'archiveAndDestroy']);

});

Route::post("login",[UserController::class,'index']);

