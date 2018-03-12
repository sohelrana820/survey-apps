<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

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
        $model = $this->loadModel();
        var_dump($model); die();
        return $this->getView()->render($response, 'products/products.twig');
    }
}