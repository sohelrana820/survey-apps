<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AuthController
 * @package App\Controller
 */
class AuthController  extends AppController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function signupPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'auth/signup.twig');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     */
    public function signup(Request $request, Response $response, $args)
    {
        var_dump($request->getParsedBody()); die();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function loginPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'auth/login.twig');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     */
    public function login(Request $request, Response $response, $args)
    {
        var_dump($request->getParsedBody()); die();
    }

}