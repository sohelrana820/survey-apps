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
     * @var QuestionsModel
     */
    private $productsModel;

    /**
     * @var CategoriesModel
     */
    private $categoryModel;

    /**
     * @var OrdersModel
     */
    private $orderModel;

    /**
     * @var InvoicesModel
     */
    private $invoiceModel;

    /**
     * @var InvoicesProductsModel
     */
    private $invoiceProductModel;

    /**
     * @var DownloadLinksModel
     */
    private $downloadLinkModel;

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
     * @return QuestionsModel
     */
    public function getProductModel()
    {
        $this->productsModel = new QuestionsModel();
        $this->productsModel->setLogger($this->logger);
        $this->productsModel->setCache($this->cache);
        return $this->productsModel;
    }
}
