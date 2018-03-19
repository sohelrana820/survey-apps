<?php

namespace App\helpers\components;


class ComponentLoad
{
    protected $config;

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