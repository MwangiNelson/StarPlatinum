<?php

use App\Http\Controllers\Api\itemController;
use App\Http\Controllers\Api\listController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API's for lists
Route::get('lists', [listController::class, 'index']);
Route::get('lists/{id}', [listController::class, 'select']);
Route::get('todos/{id}', [listController::class, 'getItemsFromList']);
Route::post('lists', [listController::class, 'save']);
Route::delete('lists/{id}/delete', [listController::class, 'delete']);
Route::put('lists/{id}/edit', [listController::class, 'edit']);


//API's for to-do items
Route::get('items', [itemController::class, 'index']);
Route::get('items/{id}', [itemController::class, 'select']);
Route::post('items', [itemController::class, 'save']);
Route::delete('items/delete/{id}', [itemController::class, 'delete']);
Route::put('items/edit/{id}', [itemController::class, 'edit']);
Route::delete('clear/{id}', [itemController::class, 'clearList']);
