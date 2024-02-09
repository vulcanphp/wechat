<?php

use VulcanPhp\PhpRouter\Route;
use App\Http\Controllers\WeChat;
use App\Http\Middlewares\AuthGuard;
use App\Http\Middlewares\LoginGuard;
use App\Http\Controllers\UserManager;

Route::group(['middlewares' => [LoginGuard::class]], function () {
    Route::view('/account', 'auth');
    Route::post('/login', [UserManager::class, 'login']);
    Route::post('/register', [UserManager::class, 'register']);
});

Route::group(['middlewares' => [AuthGuard::class]], function () {
    Route::view('/', 'index');
    Route::form('/profile', [UserManager::class, 'updateProfile']);
    Route::post('/activities', [UserManager::class, 'updateActivities']);
    Route::post('/timestamps', [UserManager::class, 'updateTimestamps']);
    Route::post('/send/message', [WeChat::class, 'sendMessage']);
    Route::post('/socket/{id}', [WeChat::class, 'sendToSocket']);
    Route::post('/messages', [WeChat::class, 'messageList']);
    Route::post('/pusher-auth', [WeChat::class, 'pusherAuth']);
    Route::post('/logout', [UserManager::class, 'logout']);
    Route::get('/{username}', [WeChat::class, 'user']);
});
