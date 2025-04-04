<?php

namespace Controller;

use Model\User;
use Src\Request;
use Src\View;

class Api
{
    public function index(): void
    {
        $users = User::all()->toArray();

        (new View())->toJSON($users);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }
}