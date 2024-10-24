<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LikeController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);

Route::get('/likes', [LikeController::class, 'index']);
Route::post('/likes', [LikeController::class, 'toggleLike']);
Route::get('/likes/status', [LikeController::class, 'checkLikeStatus']);
