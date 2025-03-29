<?php

namespace Controller;

use Model\Reader;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class ReaderController
{
    public function addReader(Request $request): string
    {
        if ($request->method === 'POST') {
            try {
                $cardNumber = trim($request->library_card_number);
                if (empty($cardNumber)) {
                    $cardNumber = $this->generateLibraryCardNumber();
                }

                $data = [
                    'library_card_number' => $cardNumber,
                    'surname' => $request->surname,
                    'name' => $request->name,
                    'patronymic' => $request->patronymic ?? null,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'registration_date' => date('Y-m-d'),
                    'status' => 'active'
                ];

                if (empty($data['surname']) || empty($data['name']) ||
                    empty($data['address']) || empty($data['phone'])) {
                    throw new \RuntimeException('Заполните все обязательные поля');
                }

                $reader = new Reader();
                $reader->fill($data);

                if (!$reader->save()) {
                    throw new \RuntimeException('Ошибка сохранения читателя');
                }

                app()->route->redirect('/library');
                return '';

            } catch (\Exception $e) {
                return (new View('site.add-reader', [
                    'error' => $e->getMessage(),
                    'formData' => $request->all()
                ]))->__toString();
            }
        }

        return (new View('site.add-reader'))->__toString();
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

    public function index(Request $request): string
    {
        $readers = Reader::all();
        return (new View('site.library', ['readers' => $readers]))->__toString();
    }
}