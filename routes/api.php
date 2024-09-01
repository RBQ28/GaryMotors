<?php

use App\Http\Controllers\Api\AdminController;
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


