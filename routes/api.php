<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes handle all frontend API requests for Blog, Service,
| Gallery, and Contact resources.
|--------------------------------------------------------------------------
*/

// Simple API check
Route::get('/check', function () {
    return response()->json(['status' => 'API is working']);
});

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
*/
Route::get('/blogs', [BlogController::class, 'index']);
Route::post('/blogs', [BlogController::class, 'store']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);
Route::post('/blogs/{id}', [BlogController::class, 'update']);
Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Service Routes
|--------------------------------------------------------------------------
*/
Route::get('/services', [ServiceController::class, 'index']);
Route::post('/services', [ServiceController::class, 'store']);
Route::get('/services/{id}', [ServiceController::class, 'show']);
Route::post('/services/{id}', [ServiceController::class, 'update']);
Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Gallery Routes
|--------------------------------------------------------------------------
*/
Route::get('/gallery', [GalleryController::class, 'index']);
Route::post('/gallery', [GalleryController::class, 'store']);
Route::get('/gallery/{id}', [GalleryController::class, 'show']);
Route::post('/gallery/{id}', [GalleryController::class, 'update']);
Route::delete('/gallery/{id}', [GalleryController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| Contact Routes
|--------------------------------------------------------------------------
*/
Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contacts/{id}', [ContactController::class, 'show']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
