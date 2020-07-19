<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AuthMiddleware
 *
 * @package App\Middleware
 */
class AuthMiddleware
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        if(!$_SESSION['auth']){
            return $response->withRedirect('/login');
        }

        $response = $next($request, $response);
        return $response;
    }
}
