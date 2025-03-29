<?php

namespace Controller;

use Model\Publisher;
use Src\Request;
use Src\View;

class PublisherController
{
    public function index(Request $request): string
    {
        $publishers = Publisher::all();
        return (new View('site.publishers', ['publishers' => $publishers]))->__toString();
    }

    public function addPublisher(Request $request): string
    {
        if ($request->method === 'POST') {
            try {
                $data = [
                    'name' => $request->name,
                    'country' => $request->country,
                    'foundation_year' => $request->foundation_year
                ];

                if (empty($data['name'])) {
                    throw new \RuntimeException('Название издательства обязательно');
                }

                Publisher::create($data);
                app()->route->redirect('/publishers');
                return '';

            } catch (\Exception $e) {
                return (new View('site.add-publisher', [
                    'error' => $e->getMessage(),
                    'formData' => $request->all()
                ]))->__toString();
            }
        }

        return (new View('site.add-publisher'))->__toString();
    }
}