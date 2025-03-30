<?php

namespace Controller;

use Model\Book;
use Model\BookLoan;
use Model\Reader;
use Model\Author;
use Model\Publisher;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class LibrarianController
{
    public function dashboard(Request $request): string
    {
        try {
            $activeLoans = BookLoan::active()->with(['book', 'reader'])->get();

            return (new View('site.library-dashboard', [
                'activeLoans' => $activeLoans
            ]))->__toString();

        } catch (\Exception $e) {
            error_log('Dashboard error: ' . $e->getMessage());
            return (new View('site.error', [
                'message' => 'Произошла ошибка при загрузке данных'
            ]))->__toString();
        }
    }

    private function generateLibraryCardNumber(): string
    {
        $prefix = 'R' . date('Ymd');
        $attempts = 0;

        do {
            $number = $prefix . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
            $attempts++;

            if ($attempts > 10) {
                throw new \RuntimeException('Не удалось сгенерировать уникальный номер');
            }

        } while (Reader::where('library_card_number', $number)->exists());

        return $number;
    }

    public function manageFines(Request $request)
    {
        $fines = Fine::with(['reader', 'loan.book'])->get();
        return (new View('site.fines', ['fines' => $fines]))->__toString();
    }

    public function readerBooks(Request $request): string
    {
        $readerId = $request->reader_id ?? null;
        $readers = Reader::all();

        $loans = BookLoan::query()
            ->with(['book', 'reader'])
            ->where('status', 'loaned');

        if ($readerId) {
            $loans->where('reader_id', $readerId);
        }

        return (new View('site.reader-books', [
            'loans' => $loans->get(),
            'readers' => $readers,
            'selectedReader' => $readerId ? Reader::find($readerId) : null
        ]))->__toString();
    }

    public function bookReaders(Request $request): string
    {
        $bookId = $request->book_id ?? null;
        $books = Book::all();

        $loans = BookLoan::query()
            ->with(['book', 'reader'])
            ->whereNotNull('return_date');

        if ($bookId) {
            $loans->where('book_id', $bookId);
        }

        return (new View('site.book-readers', [
            'loans' => $loans->orderBy('loan_date', 'desc')->get(),
            'books' => $books,
            'selectedBook' => $bookId ? Book::find($bookId) : null
        ]))->__toString();
    }

    public function popularBooks(Request $request): string
    {
        $popularBooks = Book::withCount(['loans' => function($query) {
            $query->whereNotNull('return_date');
        }])
            ->orderBy('loans_count', 'desc')
            ->limit(10)
            ->get();

        return (new View('site.popular-books', [
            'books' => $popularBooks
        ]))->__toString();
    }
}