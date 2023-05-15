<?php

use App\Http\Controllers\Api\itemController;
use App\Http\Controllers\Api\listController;
use App\Http\Controllers\Api\recipeController;
use App\Http\Controllers\Api\userAuth;
use App\Models\ItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API's for lists
// Route::get('lists', [listController::class, 'index']);
// Route::get('lists/{id}', [listController::class, 'select']);
Route::get('todos/{id}', [listController::class, 'getItemsFromList']);
Route::post('lists', [listController::class, 'save']);
Route::delete('lists/{id}/delete', [listController::class, 'delete']);
Route::put('lists/{id}/edit', [listController::class, 'edit']);


//API's for to-do items
Route::get('task', [itemController::class, 'index']);
Route::get('task/{id}', [itemController::class, 'select']);
Route::post('task', [itemController::class, 'save']);
Route::delete('task/delete/{id}', [itemController::class, 'delete']);
Route::put('task/edit/{id}', [itemController::class, 'edit']);
Route::delete('task/clear/{id}', [itemController::class, 'clearList']);

Route::get('tests', [itemController::class, 'getTest']);
Route::get('tests/{id}', [itemController::class, 'getSpecificTest']);
Route::post('tests', [itemController::class, 'addTest']);

Route::post('user/sign-up', [userAuth::class, 'registerUser']);
Route::post('user/sign-in', [userAuth::class, 'signInUser']);


Route::post('recipe/save', [recipeController::class, 'addToCookBook']);
Route::get('getCookBook/{email}', [recipeController::class, 'getCookBook']);
