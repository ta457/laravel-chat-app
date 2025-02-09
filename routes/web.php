<?php

use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SendMessageController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('/chat/{roomCode}', [ChatRoomController::class, 'index'])->name('chatroom');
    Route::post('/chat/create', [ChatRoomController::class, 'createRoom'])->name('create.room');

    Route::post('/message', SendMessageController::class)->name('send.message');
});
