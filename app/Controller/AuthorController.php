<?php

namespace Controller;

use Model\Author;
use Src\Request;
use Src\View;

class AuthorController
{
    public function index(Request $request): string
    {
        $authors = Author::all();
        return (new View('site.authors', ['authors' => $authors]))->__toString();
    }

    public function addAuthor(Request $request): string
    {
        if ($request->method === 'POST') {
            try {
                $data = [
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'patronymic' => $request->patronymic ?? null,
                    'birth_year' => $request->birth_year,
                    'country' => $request->country
                ];

                if (empty($data['name']) || empty($data['surname'])) {
                    throw new \RuntimeException('Заполните обязательные поля');
                }

                Author::create($data);
                app()->route->redirect('/authors');
                return '';

            } catch (\Exception $e) {
                return (new View('site.add-author', [
                    'error' => $e->getMessage(),
                    'formData' => $request->all()
                ]))->__toString();
            }
        }

        return (new View('site.add-author'))->__toString();
    }
}