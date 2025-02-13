<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index']);
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store']);
    Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show']);
    Route::post('/users/{user}', [\App\Http\Controllers\UserController::class, 'sendLike']);

    Route::controller(\App\Http\Controllers\ChatController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/chat', 'messages');
        Route::post('/send', 'send');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
