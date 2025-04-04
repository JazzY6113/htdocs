<?php

namespace Src\Auth;

use Src\Session;
use SimpleCSRF\CSRF;
use Model\User;

class Auth
{
    private static $user;

    public static function init($identityClass)
    {
        self::$user = new $identityClass;
    }

    public static function generateCSRF()
    {
        return CSRF::generateToken();
    }

    public static function login(User $user): bool
    {
        self::$user = $user;
        Session::set('user_id', $user->getId());
        return true;
    }

    public static function attempt(array $credentials): ?User
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::login($user);
            return $user;
        }
        return null;
    }

    public static function user(): ?User
    {
        $id = Session::get('user_id') ?: 0;
        return self::$user->findIdentity($id);
    }

    public static function check(): bool
    {
        return (bool)self::user();
    }

    public static function logout(): bool
    {
        Session::clear('user_id');
        self::$user = null;
        return true;
    }

    public static function byToken(string $token): bool
    {
        $user = self::$user->where('api_token', $token)->first();
        if ($user) {
            self::$user = $user;
            return true;
        }
        return false;
    }
}