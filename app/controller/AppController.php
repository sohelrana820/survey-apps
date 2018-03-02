<?php

namespace App\Controller;

use Noodlehaus\Config;
use Slim\Container;
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
}