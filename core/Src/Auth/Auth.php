<?php

namespace Src\Auth;

use Src\Session;
use SimpleCSRF\CSRF;

class Auth
{
    private static $user;

    public static function init($user)
    {
        self::$user = $user;
        if (self::user()) {
            self::login(self::user());
        }
    }

    public static function generateCSRF()
    {
        return CSRF::generateToken();
    }

    public static function login($user)
    {
        self::$user = $user;
        Session::set('id', self::$user->getId());
    }

    public static function attempt(array $credentials)
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }
        return false;
    }

    public static function user()
    {
        $id = Session::get('id') ?: 0;
        return self::$user->findIdentity($id);
    }

    public static function check()
    {
        return (bool) self::user();
    }

    public static function logout()
    {
        Session::clear('id');
        return true;
    }
}