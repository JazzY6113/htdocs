<?php

use Src\Route;

// Основные маршруты
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');

// Админ-функционал (добавляем новые)
Route::add('GET', '/users', [Controller\AdminController::class, 'users'])
    ->middleware('auth:admin');
Route::add('POST', '/approve-user', [Controller\AdminController::class, 'approve'])
    ->middleware('auth:admin');
Route::add(['GET', 'POST'], '/create-user', [Controller\AdminController::class, 'create'])
    ->middleware('auth:admin');