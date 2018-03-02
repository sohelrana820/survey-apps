<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AppController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function home(Request $request, Response $response, $args)
    {
        $this->getFlash()->addMessage('success', 'You are ready to work!');
        $this->getLogger()->info('Application has been running successfully!');
        return $this->getView()->render($response, 'home.twig', ['message' => $this->getFlash()->getMessages()]);
    }
}