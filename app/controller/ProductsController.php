<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class ProductsController
 *
 * @package App\Controller
 */
class ProductsController extends AppController
{
    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function products(Request $request, Response $response, $args)
    {
        $products = $this->loadModel()->getProductsModel()->searchProducts($request->getQueryParams());
        $categories = $this->loadModel()->getCategoryModel()->getCategories();
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        return $this->getView()->render($response, 'products/products.twig', $data);
    }
}