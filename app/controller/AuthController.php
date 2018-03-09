<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthController  extends AppController
{
    public function signupPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'auth/signup.twig');
    }

    public function signup(Request $request, Response $response, $args)
    {
        var_dump($request->getParsedBody()); die();
    }

    public function loginPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'auth/login.twig');
    }

    public function login(Request $request, Response $response, $args)
    {
        var_dump($request->getParsedBody()); die();
    }

}