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
}