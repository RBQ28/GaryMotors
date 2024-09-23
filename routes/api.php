<?php
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Api\AccesorioController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\FormularioContactoController;
use App\Http\Controllers\Api\MotosController;
use App\Http\Controllers\Api\PiezaController;
use App\Http\Controllers\Api\TipoAccesorioController;
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

// Rutas de autenticación para administradores
Route::prefix('auth/admin')->group(function () {
    Route::post('/register', [AdminAuthController::class, 'register']); // Registro
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login'); // Mostrar formulario de inicio de sesión
    Route::post('/login', [AdminAuthController::class, 'login']); // Procesar inicio de sesión
});


// Rutas para Admin
Route::prefix('admin')->group(function () {    
    Route::get('/', [AdminController::class, 'index']);
    Route::post('/', [AdminController::class, 'store']);
    Route::get('{id}', [AdminController::class, 'show']);
    Route::middleware('auth:sanctum')->put('{id}', [AdminController::class, 'update']);
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

Route::prefix('motos')->group(function () {
    Route::get('/', [MotosController::class, 'index']);
    Route::post('/', [MotosController::class, 'store']);
    Route::get('{id}', [MotosController::class, 'show']);
    Route::put('{id}', [MotosController::class, 'update']);
    Route::delete('{id}', [MotosController::class, 'destroy']);
});

Route::prefix('tipo_accesorio')->group(function () {
    Route::get('/', [TipoAccesorioController::class, 'index']);
    Route::post('/', [TipoAccesorioController::class, 'store']);
    Route::get('{id}', [TipoAccesorioController::class, 'show']);
    Route::put('{id}', [TipoAccesorioController::class, 'update']);
    Route::delete('{id}', [TipoAccesorioController::class, 'destroy']);
});

Route::prefix('accesorio')->group(function () {
    Route::get('/', [AccesorioController::class, 'index']);
    Route::post('/', [AccesorioController::class, 'store']);
    Route::get('{id}', [AccesorioController::class, 'show']);
    Route::put('{id}', [AccesorioController::class, 'update']);
    Route::delete('{id}', [AccesorioController::class, 'destroy']);
});