<?php

use App\Http\Controllers\CaminhaoController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\TransportadoraController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('transportadoras', TransportadoraController::class);
Route::put('transportadoras/{id}/status', [TransportadoraController::class, 'updateStatus']);
Route::get('transportadoras/{id}/motoristas', [TransportadoraController::class, 'showWithMotoristas']);
Route::put('transportadoras/{id}/motoristas', [TransportadoraController::class, 'updateMotoristas']);

Route::apiResource('motoristas', MotoristaController::class);
Route::get('motoristas/{id}/caminhoes', [MotoristaController::class, 'showWithCaminhoes']);

Route::apiResource('modelo', ModeloController::class);
Route::apiResource('caminhao', CaminhaoController::class);