<?php

namespace Middlewares;

use Exception;
use Src\Request;
use SimpleCSRF\CSRF;

class CSRFMiddleware
{
    public function handle(Request $request)
    {
        if ($request->method !== 'POST') {
            return;
        }

        if (empty($request->get('csrf_token')) || !CSRF::verifyToken($request->get('csrf_token'))) {
            throw new Exception('Request not authorized');
        }
    }
}