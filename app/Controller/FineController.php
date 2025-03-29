<?php

namespace Controller;

use Model\Fine;
use Src\Request;
use Src\View;

class FineController
{
    public function index(Request $request): string
    {
        $fines = Fine::with(['reader', 'loan.book'])->get();
        return (new View('site.fines', ['fines' => $fines]))->__toString();
    }

    public function payFine(Request $request): void
    {
        $fine = Fine::find($request->fine_id);
        if ($fine) {
            $fine->update(['status' => 'paid']);
        }
        app()->route->redirect('/fines');
    }
}