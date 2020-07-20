<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AuthController
 *
 * @package App\Controller
 */
class AuthController extends AppController
{
    /**
     * @param Request  $request
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
     * @param Request  $request
     * @param Response $response
     * @param $args
     */
    public function login(Request $request, Response $response, $args)
    {
        $requestData = $request->getParsedBody();
        $user = $this->loadModel()->getUserModel()->getUserByEmail($requestData['email']);
        $passwordMatched = password_verify($requestData['password'], $user['password']);
        if($passwordMatched)
        {
            $_SESSION['auth'] = $user;
            if($this->isAdmin()){
                return $response->withRedirect('/survey/menu');
            }
            return $response->withRedirect('/survey');
        }

        $this->flash->addMessage('error', 'Sorry, invalid email or password');
        return $response->withRedirect('/login');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     */
    public function logout(Request $request, Response $response, $args)
    {
        session_destroy();
        unset($_SESSION['auth']);
        return $response->withRedirect('/login');
    }
}
