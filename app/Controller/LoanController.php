<?php

namespace Controller;

use Model\BookLoan;
use Model\Book;
use Model\Reader;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class LoanController
{
    public function loanBook(Request $request): string
    {
        $books = Book::available()->get();
        $readers = Reader::where('status', 'active')->get();

        if ($request->method === 'POST') {
            try {
                $book = Book::find($request->book_id);

                if ($book && $book->isAvailable()) {
                    BookLoan::create([
                        'book_id' => $request->book_id,
                        'reader_id' => $request->reader_id,
                        'librarian_id' => Auth::user()->user_id,
                        'loan_date' => date('Y-m-d'),
                        'due_date' => date('Y-m-d', strtotime('+14 days'))
                    ]);

                    $book->decrement('available_copies');
                    app()->route->redirect('/library');
                    return '';
                }
            } catch (\Exception $e) {
                return (new View('site.loan-book', [
                    'error' => 'Ошибка при выдаче книги: ' . $e->getMessage(),
                    'books' => $books,
                    'readers' => $readers
                ]))->__toString();
            }
        }

        return (new View('site.loan-book', [
            'books' => $books,
            'readers' => $readers
        ]))->__toString();
    }

    public function returnBook(Request $request): string
    {
        if ($request->method === 'GET') {
            $activeLoans = BookLoan::active()->with(['book', 'reader'])->get();
            return (new View('site.return-book', [
                'activeLoans' => $activeLoans
            ]))->__toString();
        }

        if ($request->method === 'POST') {
            try {
                $loan = BookLoan::find($request->loan_id);

                if ($loan) {
                    $loan->update([
                        'return_date' => date('Y-m-d'),
                        'status' => 'returned'
                    ]);

                    $loan->book->increment('available_copies');
                }

                app()->route->redirect('/library');
                return '';

            } catch (\Exception $e) {
                error_log('Return book error: ' . $e->getMessage());
                $activeLoans = BookLoan::active()->with(['book', 'reader'])->get();
                return (new View('site.return-book', [
                    'activeLoans' => $activeLoans,
                    'error' => 'Ошибка при возврате книги'
                ]))->__toString();
            }
        }

        app()->route->redirect('/library');
        return '';
    }

    public function index(Request $request): string
    {
        $loans = BookLoan::with(['book', 'reader'])->get();
        return (new View('site.library', ['loans' => $loans]))->__toString();
    }
}