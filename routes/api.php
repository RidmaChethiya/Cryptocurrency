<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\tokenController;
use App\Http\Controllers\CurrencyController;

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


Route::post('/user/registration', [tokenController::class, 'register']);
Route::post('/user/login', [tokenController::class, 'login']);

Route::get('/currency/list', [CurrencyController::class, 'index']);
Route::get('/currency/show/{id}', [CurrencyController::class, 'show']);
Route::get('/currency/search/{name}', [CurrencyController::class, 'search']);
// Route::get('/currency/autoUpdate', [CurrencyController::class, 'autoUpdate']);

//token protection
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/currency/save', [CurrencyController::class, 'store']);
    Route::put('/currency/update/{id}', [CurrencyController::class, 'update']);
    Route::delete('/currency/delete/{id}', [CurrencyController::class, 'destroy']);

    Route::post('/user/logout', [tokenController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
