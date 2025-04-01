<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class LibrarianMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'librarian') {
            app()->route->redirect('/hello');
        }
    }
}