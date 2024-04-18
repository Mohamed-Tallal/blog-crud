<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\CommentController;

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

Route::apiResource('blog', BlogController::class)->only(['index' , 'show']);
Route::apiResource('posts', PostController::class);

Route::delete('comments/bulk-delete', [CommentController::class , 'bulkDelete']);
Route::apiResource('/comments', CommentController::class);
