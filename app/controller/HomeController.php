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
    public function faqs(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'general/faqs.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function privacy(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'general/privacy-policy.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function contact(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'general/contact-us.twig');
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

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface|static
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function download(Request $request, Response $response, $args)
    {
        $token = $request->getParam('token');
        if(!$token) {
            return $response->withRedirect('/error/404');
        }

        $productDetails = $this->loadModel()->getDownloadLinkModel()->getDetailsByToken($token);
        $expiredAt = date('Y-m-d H:i:s', strtotime($productDetails['expired_at']));
        if(strtotime($expiredAt) < strtotime(date('Y-m-d H:i:s')) || $productDetails['download_completed'] == true) {
            return $this->getView()->render($response, 'error/download-error.twig');
        }

        // Update download link fields.
        $data = [
            'download_completed' => true,
            'downloaded_at' => date('Y-m-d H:i:s'),
        ];
        $updated = $this->loadModel()->getDownloadLinkModel()->updateDownloadLinkd($productDetails['id'], $data);
        if($updated) {
            $this->getLogger() ? $this->getLogger()->info('Product Downloaded', ['product_details' => $productDetails]) : null;
        }
        $fileName = $productDetails['slug'] .'.zip';
        header('Content-Disposition: attachment; filename=' . $fileName);
        readfile($productDetails['download_path']);
    }
}
