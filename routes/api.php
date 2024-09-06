<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\FormularioContactoController;
use App\Http\Controllers\Api\PiezaController;
use App\Http\Controllers\Api\TipoPiezaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas de tu API. Estas rutas son
| cargadas por el RouteServiceProvider dentro de un grupo que tiene el
| middleware "api" aplicado. ¡Crea algo genial!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para Admin
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'store']);
    Route::get('{id}', [AdminController::class, 'show']);
    Route::put('{id}', [AdminController::class, 'update']);  // Corrección aquí
    Route::delete('{id}', [AdminController::class, 'destroy']);
});

//Rutas para TipoPieza
Route::prefix('tipos_piezas')->group(function (){
    Route::get('/',[TipoPiezaController::class, 'index']);
    Route::post('/',[TipoPiezaController::class, 'store']);
    Route::get('{id}',[TipoPiezaController::class, 'show']);
    Route::put('{id}',[TipoPiezaController::class, 'update']);
    Route::delete('{id}',[TipoPiezaController::class, 'destroy']);
});

//Rutas para Piezas
Route::prefix('piezas')->group(function (){
    Route::get('/',[PiezaController::class, 'index']);
    Route::post('/',[PiezaController::class, 'store']);
    Route::get('{id}',[PiezaController::class, 'show']);
    Route::put('{id}',[PiezaController::class, 'update']);
    Route::delete('{id}',[PiezaController::class, 'destroy']);
});

// Rutas para el formulario de contacto
Route::prefix('contactos')->group(function () {
    Route::get('/', [FormularioContactoController::class, 'index']);
    Route::post('/', [FormularioContactoController::class, 'store']);
    Route::get('{id}', [FormularioContactoController::class, 'show']);
    Route::put('{id}', [FormularioContactoController::class, 'update']);
    Route::delete('{id}', [FormularioContactoController::class, 'destroy']);
});
