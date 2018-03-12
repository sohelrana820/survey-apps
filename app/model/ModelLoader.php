<?php

namespace App\Model;

use Monolog\Logger;

class ModelLoader
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var \Memcache;
     */
    private $cache;

    /**
     * @var UsersModel
     */
    private $userModel;

    /**
     * @var ProductsModel
     */
    private $productsModel;

    /**
     * @param Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Memcache $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return UsersModel
     */
    public function getUserModel()
    {
        $this->userModel = new UsersModel();
        return $this->userModel->setLogger($this->logger);
    }

    /**
     * @return ProductsModel
     */
    public function getProductsModel()
    {
        $this->productsModel = new ProductsModel();
        $this->productsModel->setLogger($this->logger);
        $this->productsModel->setCache($this->cache);
        var_dump($this->productsModel); die();
        return $this->productsModel;
    }
}
