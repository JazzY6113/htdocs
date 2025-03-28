<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class LibrarianMiddleware
{
    public function handle(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'librarian') {
            app()->route->redirect('/hello');
            return;
        }

        if (property_exists(Auth::user(), 'is_active') && !Auth::user()->is_active) {
            Auth::logout();
            app()->route->redirect('/login');
        }
    }
}