<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            app()->route->redirect('/hello');
        }
    }
}