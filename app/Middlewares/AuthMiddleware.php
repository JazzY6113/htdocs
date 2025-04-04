<?php

namespace Middlewares;

use Model\User;
use Src\Request;
use Src\View;

class AuthMiddleware
{
    public function handle(Request $request): Request
    {
        $authHeader = $request->headers['Authorization'] ?? '';

        if (!preg_match('/Bearer\s([a-f0-9]{64})/', $authHeader, $matches)) {
            (new View())->toJSON(['error' => 'Invalid token format'], 401);
            exit();
        }

        $token = $matches[1];
        $user = User::where('api_token', $token)
            ->where('token_expires_at', '>', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            (new View())->toJSON([
                'error' => 'Invalid or expired token',
                'debug' => [
                    'expected_length' => 64,
                    'actual_length' => strlen($token),
                    'token_in_db' => User::where('user_id', 20)->value('api_token')
                ]
            ], 401);
            exit();
        }

        return $request;
    }
}