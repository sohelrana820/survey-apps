<?php

namespace App\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends AppController
{
    public function home(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'home.twig', ['name' => 'Home']);
    }
}