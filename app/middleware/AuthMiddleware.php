<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AuthMiddleware
 * @package App\Middleware
 */
class AuthMiddleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        // Write your business logic here

        $response = $next($request, $response);
        return $response;
    }
}