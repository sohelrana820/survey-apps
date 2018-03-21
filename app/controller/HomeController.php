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
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function beforeRender()
    {
        parent::beforeRender();
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function home(Request $request, Response $response, $args)
    {
        $products = $this->loadModel()->getProductModel()->getPopularProducts();
        $data = [
            'products' => $products,
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
        return $this->getView()->render($response->withStatus(404), 'error/404.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function serverErrorPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response->withStatus(500), 'error/500.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function forbiddenPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response->withStatus(403), 'error/403.twig');
    }
}
