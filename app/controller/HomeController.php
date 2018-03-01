<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

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
        return $this->getView()->render($response, 'home.twig', ['name' => 'Home']);
    }
}