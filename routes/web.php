<?php

use Src\Route;

// Публичные маршруты (не требуют авторизации)
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

// Маршруты для авторизованных пользователей (любая роль)
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');

// Админские маршруты (только для role=admin)
Route::add('GET', '/users', [Controller\AdminController::class, 'users'])
    ->middleware('auth', 'admin');
Route::add('POST', '/approve-user', [Controller\AdminController::class, 'approve'])
    ->middleware('auth', 'admin');
Route::add(['GET', 'POST'], '/create-user', [Controller\AdminController::class, 'create'])
    ->middleware('auth', 'admin');

// Маршруты библиотекаря (только для role=librarian)
Route::add(['GET', 'POST'], '/add-reader', [Controller\ReaderController::class, 'addReader'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/readers', [Controller\ReaderController::class, 'index'])
    ->middleware('auth', 'librarian');
Route::add(['GET', 'POST'], '/add-book', [Controller\BookController::class, 'addBook'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/books', [Controller\BookController::class, 'index'])
    ->middleware('auth', 'librarian');
Route::add(['GET', 'POST'], '/loan-book', [Controller\LoanController::class, 'loanBook'])
    ->middleware('auth', 'librarian');
Route::add(['GET', 'POST'], '/return-book', [Controller\LoanController::class, 'returnBook'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/loans', [Controller\LoanController::class, 'index'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/library', [Controller\LibrarianController::class, 'dashboard'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/reader-books', [Controller\LibrarianController::class, 'readerBooks'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/book-readers', [Controller\LibrarianController::class, 'bookReaders'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/popular-books', [Controller\LibrarianController::class, 'popularBooks'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/manage-fines', [Controller\LibrarianController::class, 'manageFines'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/fines', [Controller\FineController::class, 'index'])
    ->middleware('auth', 'librarian');
Route::add('POST', '/pay-fine', [Controller\FineController::class, 'payFine'])
    ->middleware('auth', 'librarian');
Route::add('GET', '/library-search', [Controller\LibrarianController::class, 'searchBooks'])
    ->middleware('auth', 'librarian');