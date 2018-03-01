<?php

namespace App\Controller;


use Monolog\Logger;
use Noodlehaus\Config;
use Slim\Container;
use Slim\Views\Twig;

class AppController
{
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var Twig
     */
    protected $view;
    /**
     * @var Config;
     */
    protected $config;
    /**
     * @var Logger
     */
    protected $logger;
    /**
     * @var
     */
    protected $flash;
    /**
     * AppController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->config = $this->container['config'];
    }

    /**
     * @return mixed|Twig
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function getView()
    {
        $this->view = $this->container->get('view');
        return $this->view;
    }

    /**
     * @return mixed|Logger
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function getLogger()
    {
        $this->logger = $this->container->get('logger');
        return $this->logger;
    }

    /**
     * @return mixed
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function getFlash()
    {
        return $this->flash = $this->container->get('flash');
    }
}