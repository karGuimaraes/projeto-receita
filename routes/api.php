<?php

use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\ReceitaController;
use App\Http\Controllers\TipoReceitaController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::controller(UserController::class)->group(function() {
    Route::post('/user/sign/', 'register');
    Route::get('/user/login/', 'login');
    Route::get('/user/logout/', 'logout')->middleware([JwtMiddleware::class]);
    Route::get('/user/refresh/', 'refresh')->name('refresh')->middleware([JwtMiddleware::class]);
});

Route::group(['middleware' => [JwtMiddleware::class]], function () {
    Route::get('/receitas/tipo-receitas/', [ TipoReceitaController::class, 'index' ]);

    Route::controller(IngredienteController::class)->group(function() {
        Route::get('/receitas/ingrediente/', 'index');
        Route::post('/receitas/ingrediente/', 'store');
        Route::get('/receitas/ingrediente/{id}/', 'show');
        Route::put('/receitas/ingrediente/{id}/', 'update');
        Route::delete('/receitas/ingrediente/{id}/', 'destroy');
        Route::put('/receitas/ingrediente/{id}/restore', 'restore');
    });

    Route::controller(ReceitaController::class)->group(function () {
        Route::get('/receitas/receita/', 'index');
        Route::post('/receitas/receita/', 'store');
        Route::get('/receitas/receita/{id}/', 'show');
        Route::put('/receitas/receita/{id}/', 'update');
        Route::delete('/receitas/receita/{id}/', 'destroy');
        Route::put('/receitas/receita/{id}/restore', 'restore');
    });


});
