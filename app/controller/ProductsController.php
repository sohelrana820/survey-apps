<?php

namespace App\Controller;

use http\Env\Response;
use Slim\Http\Request;

/**
 * Class ProductsController
 * @package App\Controller
 */
class ProductsController extends AppController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function products(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'products/products.twig');
    }
}