<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [ImageController::class, 'index'])->name('home');

Route::get('/upload', [ImageController::class, 'uploadForm'])->name('upload');

Route::post('/upload', [ImageController::class, 'upload'])->name('image.upload');

Route::get('/{image_hash}', [ImageController::class, 'show'])->name('image.show');

Route::post('/{image_hash}/like', [ImageController::class, 'like'])->name('image.like');

Route::post('/{image_hash}/dislike', [ImageController::class, 'dislike'])->name('image.dislike');
