<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QRController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\HuggingFaceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/insert-users', [UserController::class, 'insertUsers']);
Route::get('/users', [UserController::class, 'getUsers']);
Route::get('/expert-ai', [ChatController::class, 'show']);
Route::post('/send', [ChatController::class, 'send']);
Route::get('/content-upload', [UserController::class, 'getCKEditor']);
Route::post('/upload-image', [UserController::class, 'uploadImage'])->name('ckeditor.upload');
Route::post('/submit-content', [UserController::class, 'submitContent'])->name('submit.content');

Route::get('/QRGenerator', [QRController::class, 'show'])->name('qr.show');
Route::post('/qr-generate', [QRController::class, 'generateQR'])->name('qr.generate');

Route::get('/high-charts', [ChartController::class, 'index'])->name('charts.index');
Route::get('/process-image', [ImageController::class, 'show'])->name('image.show');
// Route::get('/process-image', [ImageController::class, 'show'])->name('image.show');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');
});

Route::get('/image-manipulation', [HuggingFaceController::class, 'index']);
Route::post('/upload', [HuggingFaceController::class, 'classifyImage'])->name('classify.image');

Route::get('/object-detection', [HuggingFaceController::class, 'objectDetection']);
Route::post('/object-detection-matching', [HuggingFaceController::class, 'objectDetectionMatching'])->name('object-detection-matching');