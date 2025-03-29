<?php

namespace Controller;

use Model\Book;
use Model\Author;
use Model\Publisher;
use Model\Genre;
use Src\Request;
use Src\View;

class BookController
{
    public function addBook(Request $request): string
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $genres = Genre::all();

        if ($request->method === 'POST') {
            try {
                $data = [
                    'title' => $request->title,
                    'author_id' => $request->author_id,
                    'publisher_id' => $request->publisher_id,
                    'publication_year' => $request->publication_year,
                    'price' => $request->price,
                    'total_copies' => $request->total_copies,
                    'available_copies' => $request->total_copies,
                    'is_new_edition' => isset($request->is_new_edition) ? 1 : 0,
                    'summary' => $request->summary ?? null
                ];

                if (empty($data['title']) || empty($data['author_id']) || empty($data['publisher_id'])) {
                    throw new \RuntimeException('Заполните все обязательные поля');
                }

                $book = Book::create($data);

                if (!empty($request->genres)) {
                    $book->genres()->attach($request->genres);
                }

                app()->route->redirect('/library');
                return '';

            } catch (\Exception $e) {
                return (new View('site.add-book', [
                    'error' => 'Ошибка при добавлении книги: ' . $e->getMessage(),
                    'publishers' => $publishers,
                    'authors' => $authors,
                    'genres' => $genres,
                    'formData' => $request->all()
                ]))->__toString();
            }
        }

        return (new View('site.add-book', [
            'publishers' => $publishers,
            'authors' => $authors,
            'genres' => $genres
        ]))->__toString();
    }

    public function index(Request $request): string
    {
        $books = Book::with(['author', 'publisher'])->get();
        return (new View('site.library', ['books' => $books]))->__toString();
    }
}