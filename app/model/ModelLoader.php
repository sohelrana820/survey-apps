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
     * @return ProductsModel
     */
    public function getProductModel()
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
     * @return OrdersModel
     */
    public function getOrderModel()
    {
        $this->orderModel = new OrdersModel();
        $this->orderModel->setCache($this->cache);
        $this->orderModel->setLogger($this->logger);
        return $this->orderModel;
    }

    /**
     * @return InvoicesModel
     */
    public function getInvoiceModel()
    {
        $this->invoiceModel = new InvoicesModel();
        $this->invoiceModel->setCache($this->cache);
        $this->invoiceModel->setLogger($this->logger);
        return $this->invoiceModel;
    }

    /**
     * @return InvoicesProductsModel
     */
    public function getInvoiceProductModel()
    {
        $this->invoiceProductModel = new InvoicesProductsModel();
        $this->invoiceProductModel->setCache($this->cache);
        $this->invoiceProductModel->setLogger($this->logger);
        return $this->invoiceProductModel;
    }

    /**
     * @return DownloadLinksModel
     */
    public function getDownloadLinkModel()
    {
        $this->downloadLinkModel = new DownloadLinksModel();
        $this->downloadLinkModel->setLogger($this->logger);
        return $this->downloadLinkModel;
    }
}
