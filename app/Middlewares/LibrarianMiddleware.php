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
            return;
        }

        if (property_exists($user, 'is_active') && !$user->is_active) {
            Auth::logout();
            app()->route->redirect('/login');
        }
    }
}