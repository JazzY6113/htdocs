<?php

use Src\Route;

// Основные маршруты
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');

// Админ маршруты
Route::add('GET', '/users', [Controller\AdminController::class, 'users'])
    ->middleware('auth:admin');
Route::add('POST', '/approve-user', [Controller\AdminController::class, 'approve'])
    ->middleware('auth:admin');
Route::add(['GET', 'POST'], '/create-user', [Controller\AdminController::class, 'create'])
    ->middleware('auth:admin');

// Читатель маршруты
Route::add(['GET', 'POST'], '/add-reader', [Controller\ReaderController::class, 'addReader'])
    ->middleware('auth:librarian');
Route::add('GET', '/readers', [Controller\ReaderController::class, 'index'])
    ->middleware('auth:librarian');

Route::add('GET', '/library', [Controller\LibrarianController::class, 'dashboard'])
    ->middleware('auth:librarian');

// Книга маршруты
Route::add(['GET', 'POST'], '/add-book', [Controller\BookController::class, 'addBook'])
    ->middleware('auth:librarian');
Route::add('GET', '/books', [Controller\BookController::class, 'index'])
    ->middleware('auth:librarian');

// Выдача маршруты
Route::add(['GET', 'POST'], '/loan-book', [Controller\LoanController::class, 'loanBook'])
    ->middleware('auth:librarian');
Route::add(['GET', 'POST'], '/return-book', [Controller\LoanController::class, 'returnBook'])
    ->middleware('auth:librarian');
Route::add('GET', '/loans', [Controller\LoanController::class, 'index'])
    ->middleware('auth:librarian');

// Библиотекарь маршруты
Route::add('GET', '/reader-books', [Controller\LibrarianController::class, 'readerBooks'])
    ->middleware('auth:librarian');
Route::add('GET', '/book-readers', [Controller\LibrarianController::class, 'bookReaders'])
    ->middleware('auth:librarian');
Route::add('GET', '/popular-books', [Controller\LibrarianController::class, 'popularBooks'])
    ->middleware('auth:librarian');
Route::add('GET', '/manage-fines', [Controller\LibrarianController::class, 'manageFines'])
    ->middleware('auth:librarian');

// Штрафы маршруты
Route::add('GET', '/fines', [Controller\FineController::class, 'index'])
    ->middleware('auth:librarian');
Route::add('POST', '/pay-fine', [Controller\FineController::class, 'payFine'])
    ->middleware('auth:librarian');