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

//    public function addReader(Request $request)
//    {
//        if ($request->method === 'POST') {
//            try {
//                $cardNumber = trim($request->library_card_number);
//                if (empty($cardNumber)) {
//                    $cardNumber = $this->generateLibraryCardNumber();
//                }
//
//                $data = [
//                    'library_card_number' => $cardNumber,
//                    'surname' => $request->surname,
//                    'name' => $request->name,
//                    'patronymic' => $request->patronymic ?? null,
//                    'address' => $request->address,
//                    'phone' => $request->phone,
//                    'registration_date' => date('Y-m-d'),
//                    'status' => 'active'
//                ];
//
//                if (empty($data['surname']) || empty($data['name']) ||
//                    empty($data['address']) || empty($data['phone'])) {
//                    throw new \RuntimeException('Заполните все обязательные поля');
//                }
//
//                $reader = new Reader();
//                $reader->fill($data);
//
//                if (!$reader->save()) {
//                    throw new \RuntimeException('Ошибка сохранения читателя');
//                }
//
//                app()->route->redirect('/library');
//                return '';
//
//            } catch (\Exception $e) {
//                return (new View('site.add-reader', [
//                    'error' => $e->getMessage(),
//                    'formData' => $request->all()
//                ]))->__toString();
//            }
//        }
//
//        return (new View('site.add-reader'))->__toString();
//    }

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

//    public function addBook(Request $request): string
//    {
//        $publishers = Publisher::all();
//        $authors = Author::all();
//        $genres = \Model\Genre::all();
//
//        if ($request->method === 'POST') {
//            try {
//                $data = [
//                    'title' => $request->title,
//                    'author_id' => $request->author_id,
//                    'publisher_id' => $request->publisher_id,
//                    'publication_year' => $request->publication_year,
//                    'price' => $request->price,
//                    'total_copies' => $request->total_copies,
//                    'available_copies' => $request->total_copies,
//                    'is_new_edition' => isset($request->is_new_edition) ? 1 : 0,
//                    'summary' => $request->summary ?? null
//                ];
//
//                if (empty($data['title']) || empty($data['author_id']) || empty($data['publisher_id'])) {
//                    throw new \RuntimeException('Заполните все обязательные поля');
//                }
//
//                $book = Book::create($data);
//
//                // Привязываем жанры
//                if (!empty($request->genres)) {
//                    $book->genres()->attach($request->genres);
//                }
//
//                app()->route->redirect('/library');
//                return '';
//
//            } catch (\Exception $e) {
//                return (new View('site.add-book', [
//                    'error' => 'Ошибка при добавлении книги: ' . $e->getMessage(),
//                    'publishers' => $publishers,
//                    'authors' => $authors,
//                    'genres' => $genres,
//                    'formData' => $request->all()
//                ]))->__toString();
//            }
//        }
//
//        return (new View('site.add-book', [
//            'publishers' => $publishers,
//            'authors' => $authors,
//            'genres' => $genres
//        ]))->__toString();
//    }

//    public function loanBook(Request $request): string
//    {
//        $books = Book::available()->get();
//        $readers = Reader::where('status', 'active')->get();
//
//        if ($request->method === 'POST') {
//            try {
//                $book = Book::find($request->book_id);
//
//                if ($book && $book->isAvailable()) {
//                    BookLoan::create([
//                        'book_id' => $request->book_id,
//                        'reader_id' => $request->reader_id,
//                        'librarian_id' => Auth::user()->user_id,
//                        'loan_date' => date('Y-m-d'),
//                        'due_date' => date('Y-m-d', strtotime('+14 days'))
//                    ]);
//
//                    $book->decrement('available_copies');
//                    header('Location: /library');
//                    exit;
//                }
//            } catch (\Exception $e) {
//                return (new View('site.loan-book', [
//                    'error' => 'Ошибка при выдаче книги: ' . $e->getMessage(),
//                    'books' => $books,
//                    'readers' => $readers
//                ]))->__toString();
//            }
//        }
//
//        return (new View('site.loan-book', [
//            'books' => $books,
//            'readers' => $readers
//        ]))->__toString();
//    }

//    public function returnBook(Request $request): string
//    {
//        if ($request->method === 'GET') {
//            $activeLoans = BookLoan::active()->with(['book', 'reader'])->get();
//            return (new View('site.return-book', [
//                'activeLoans' => $activeLoans
//            ]))->__toString();
//        }
//
//        if ($request->method === 'POST') {
//            try {
//                $loan = BookLoan::find($request->loan_id);
//
//                if ($loan) {
//                    $loan->update([
//                        'return_date' => date('Y-m-d'),
//                        'status' => 'returned'
//                    ]);
//
//                    if ($loan->isOverdue()) {
//                        \Model\Fine::create([
//                            'reader_id' => $loan->reader_id,
//                            'loan_id' => $loan->loan_id,
//                            'amount' => $loan->calculateFine(),
//                            'reason' => 'Просрочка возврата на ' . $loan->getOverdueDays() . ' дней',
//                            'issue_date' => date('Y-m-d'),
//                            'status' => 'unpaid'
//                        ]);
//                    }
//
//                    $loan->book->increment('available_copies');
//                }
//
//                app()->route->redirect('/return-book');
//                return '';
//
//            } catch (\Exception $e) {
//                error_log('Return book error: ' . $e->getMessage());
//                $activeLoans = BookLoan::active()->with(['book', 'reader'])->get();
//                return (new View('site.return-book', [
//                    'activeLoans' => $activeLoans,
//                    'error' => 'Ошибка при возврате книги'
//                ]))->__toString();
//            }
//        }
//
//        app()->route->redirect('/library');
//        return '';
//    }

    public function manageFines(Request $request)
    {
        $fines = Fine::with(['reader', 'loan.book'])->get();
        return (new View('site.fines', ['fines' => $fines]))->__toString();
    }

//    public function payFine(Request $request)
//    {
//        $fine = Fine::find($request->fine_id);
//        if ($fine) {
//            $fine->markAsPaid();
//        }
//        app()->route->redirect('/manage-fines');
//    }

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