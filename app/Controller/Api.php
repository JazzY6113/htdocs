<?php

namespace Controller;

use Model\User;
use Model\Reader;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class Api
{
    public function index(): void
    {
        $readers = Reader::all()->toArray();
        (new View())->toJSON($readers);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function login(Request $request): void
    {
        $credentials = $request->all();

        if ($user = Auth::attempt($credentials)) {
            // Генерируем токен из 32 символов (64 hex-символа)
            $token = bin2hex(random_bytes(32));

            // Обновляем токен и время его действия
            $user->api_token = $token;
            $user->token_expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $user->save();

            (new View())->toJSON([
                'token' => $token, // Отправляем полный токен (64 символа)
                'expires_at' => $user->token_expires_at,
                'user' => [
                    'id' => $user->user_id,
                    'name' => $user->name,
                    'role' => $user->role
                ]
            ]);
        } else {
            (new View())->toJSON(['error' => 'Invalid credentials'], 401);
        }
    }

    public function library(Request $request): void
    {
        $authHeader = $request->headers['Authorization'] ?? '';
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            (new View())->toJSON(['error' => 'Token required'], 401);
            return;
        }

        $token = $matches[1];
        $user = User::where('api_token', $token)
            ->where('token_expires_at', '>', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            (new View())->toJSON(['error' => 'Invalid or expired token'], 401);
            return;
        }

        (new View())->toJSON([
            'user' => $user->toArray(),
            'permissions' => [
                'can_manage_readers' => $user->isLibrarian(),
                'can_add_books' => $user->isLibrarian()
            ]
        ]);
    }
}