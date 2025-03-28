<?php

namespace Controller;

use Model\User;
use Src\Request;
use Src\View;
use Src\Auth\Auth;

class AdminController
{
    public function users(Request $request): string
    {
        $pendingUsers = User::where('is_active', false)->get();
        return new View('site.users', ['users' => $pendingUsers]);
    }

    public function approve(Request $request): void
    {
        $user = User::find($request->id);
        if ($user) {
            $user->update([
                'is_active' => true,
                'role' => $request->role
            ]);
        }
        app()->route->redirect('/users');
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/users');
        }
        return new View('site.create-user');
    }
}