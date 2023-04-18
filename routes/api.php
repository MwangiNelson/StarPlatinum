<?php

use App\Http\Controllers\Api\itemController;
use App\Http\Controllers\Api\listController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//API's for lists
Route::get('lists', [listController::class, 'index']);
Route::get('lists/{id}', [listController::class, 'select']);
Route::post('lists', [listController::class, 'save']);
Route::delete('lists/{id}/delete', [listController::class, 'delete']);
Route::put('lists/{id}/edit', [listController::class, 'edit']);

//API's for items
Route::get('items', [itemController::class, 'index']);
Route::get('items/{id}', [itemController::class, 'select']);
Route::post('items', [itemController::class, 'save']);
Route::delete('items/{id}/delete', [itemController::class, 'delete']);
Route::put('items/{id}/edit', [itemController::class, 'edit']);
