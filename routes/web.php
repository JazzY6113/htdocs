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

// Маршруты библиотекаря
Route::add(['GET', 'POST'], '/add-reader', [Controller\LibrarianController::class, 'addReader'])
    ->middleware('auth:librarian');
Route::add('GET', '/library', [Controller\LibrarianController::class, 'dashboard'])
    ->middleware('auth:librarian');
Route::add(['GET', 'POST'], '/add-book', [Controller\LibrarianController::class, 'addBook'])
    ->middleware('auth:librarian');
Route::add(['GET', 'POST'], '/loan-book', [Controller\LibrarianController::class, 'loanBook'])
    ->middleware('auth:librarian');
Route::add(['GET', 'POST'], '/return-book', [Controller\LibrarianController::class, 'returnBook'])
    ->middleware('auth:librarian');
Route::add('GET', '/reader-books', [Controller\LibrarianController::class, 'readerBooks'])
    ->middleware('auth:librarian');
Route::add('GET', '/book-readers', [Controller\LibrarianController::class, 'bookReaders'])
    ->middleware('auth:librarian');
Route::add('GET', '/popular-books', [Controller\LibrarianController::class, 'popularBooks'])
    ->middleware('auth:librarian');