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
     * @var CategoriesModel
     */
    private $categoryModel;

    /**
     * @var ProductsCategoriesModel;
     */
    private $productsCategories;

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
        return $this->productsModel;
    }

    /**
     * @return CategoriesModel
     */
    public function getCategoryModel()
    {
        $this->categoryModel = new CategoriesModel();
        $this->categoryModel->setLogger($this->logger);
        $this->categoryModel->setCache($this->cache);
        return $this->categoryModel;
    }

    /**
     * @return ProductsCategoriesModel
     */
    public function getProductsCategooriesModel()
    {
        $this->productsCategories = new ProductsCategoriesModel();
        $this->productsCategories->setLogger($this->logger);
        $this->productsCategories->setCache($this->cache);
        return $this->productsCategories;
    }
}
