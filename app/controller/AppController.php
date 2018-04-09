<?php

namespace App\Controller;

use App\components\ComponentLoad;
use App\Model\ModelLoader;
use Monolog\Logger;
use Noodlehaus\Config;
use Slim\Container;
use Slim\Flash\Messages;
use Slim\Views\Twig;

/**
 * Class AppController
 *
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
     * @var \Memcached
     */
    protected $cache;

    /**
     * @var Config;
     */
    protected $config;

    /**
     * AppController constructor.
     *
     * @param  Container $container
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->config = $this->container['config'];
        $this->beforeRender();
    }

    /**
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function beforeRender()
    {
        $this->getView()['CategoriesSeeder'] = $this->loadModel()->getCategoryModel()->getMostProductsCategories();
        $this->getView()['recent_products'] = $this->loadModel()->getProductModel()->getRecentProducts(9);
        $this->getView()['message'] = $this->getFlash()->getMessages();
    }

    /**
     * @return mixed
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function getSettings()
    {
        return $this->container->get('settings');
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

    /**
     * @return mixed|Logger
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function getCache()
    {
        $this->cache = $this->container->get('cache');
        return $this->cache;
    }

    /**
     * @return ModelLoader
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function loadModel()
    {
        $models = new ModelLoader();
        $models->setLogger($this->getLogger());
        $models->setCache($this->getCache());
        return $models;
    }

    /**
     * @return ComponentLoad
     */
    public function loadComponent()
    {
        $compoents = new ComponentLoad();
        $compoents->setConfig($this->config);
        $compoents->setLogger($this->logger);
        return $compoents;
    }
}
