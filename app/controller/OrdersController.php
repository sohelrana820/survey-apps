<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class OrdersController
 *
 * @package App\Controller
 */
class OrdersController extends AppController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return $this
     */
    public function backTo(Request $request, Response $response, $args)
    {
        return $response->write('I am back');
    }
}