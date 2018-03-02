<?php

namespace App\Controller;

use Monolog\Logger;
use Noodlehaus\Config;
use Slim\Container;
use Slim\Flash\Messages;
use Slim\Views\Twig;

/**
 * Class AppController
 * @package App\Controller
 */
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
     * @var Messages
     */
    protected $flash;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Config;
     */
    protected $config;

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
     * @return mixed | Messages
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function getFlash()
    {
        $this->flash = $this->container->get('flash');
        return $this->flash;
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
}