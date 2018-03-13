<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class HomeController
 *
 * @package App\Controller
 */
class HomeController extends AppController
{
    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function home(Request $request, Response $response, $args)
    {
        $products = $this->loadModel()->getProductsModel()->getPopularProducts();
        $categories = $this->loadModel()->getCategoryModel()->getCategories();
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        return $this->getView()->render($response, 'home.twig', $data);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function notFoundPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response->withStatus(404), '404.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function ServerErrorPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response->withStatus(500), '500.twig');
    }
}
