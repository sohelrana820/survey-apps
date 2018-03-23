<?php

namespace App\components;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

class ComponentLoad
{
    /**
     * @var
     */
    protected $config;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var EmailComponent
     */
    protected $email;

    /**
     * @param $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return EmailComponent
     */
    public function Email()
    {
        $this->email = new EmailComponent();
        $this->email->setConfig($this->config);
        return $this->email;
    }
}
