<?php

namespace App\components;

use Mailgun\Mailgun;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class EmailComponent
 * @package App\helpers\components
 */
class EmailComponent extends ComponentLoad
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
     * @var
     */
    public $fromEmail;

    /**
     * @var
     */
    public $replyTo;

    /**
     * @var Mailgun
     */
    private $mailgun;


    /**
     * @param $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;
        $this->fromEmail = sprintf('%s <%s>', $this->config['email']['from_name'], $this->config['email']['from_email']);
        $this->replyTo = sprintf('%s <%s>', $this->config['email']['support_name'], $this->config['email']['support_email']);
        $this->mailgun = Mailgun::create($this->config['mailgun']['api_key']);
        return $this;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param $to
     * @param $subject
     * @param $message
     * @return bool
     */
    public function send($to, $subject, $message)
    {
        try {
            $this->mailgun->messages()->send($this->config['mailgun']['domain'], [
                'from'    => $this->fromEmail,
                /*'h:Reply-To'    => $this->fromEmail,*/
                'to'      => $to,
                'subject' => $subject,
                'html'    => $message
            ]);
            $this->logger ? $this->logger->info('Email Send Successful', ['recipient' => $to, 'subject' => $subject]) : null;
            return true;

        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
            $this->logger ? $this->logger->error('Email Send Error', ['recipient' => $to, 'subject' => $subject]) : null;
        }

        return false;
    }

    /**
     * @param $to
     * @param $subject
     * @param $message
     */
    public function sendContactMesage($to, $replyTo, $subject, $message)
    {
        try {
            $this->mailgun->messages()->send($this->config['mailgun']['domain'], [
                'from'    => $this->fromEmail,
                'h:Reply-To'    => $replyTo,
                'to'      => $to,
                'subject' => $subject,
                'html'    => $message
            ]);
        } catch (\Exception $ex) {
            print_r($ex->getTrace());
            //print_r($mg);
        }
    }
}
