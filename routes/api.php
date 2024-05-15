<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::group(['prefix' => 'posts'], function () {
    Route::post('/', [PostController::class, 'store']);
    Route::patch('/{post}', [PostController::class, 'update']);
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{post}', [PostController::class, 'show']);
    Route::group(['prefix' => 'images'], function () {
        Route::post('/', [PostController::class, 'storeImage']);
    });
});
