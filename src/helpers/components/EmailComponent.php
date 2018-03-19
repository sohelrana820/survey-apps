<?php

namespace App\helpers\components;
use Mailgun\Mailgun;

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
     * @param $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function send($to, $subject, $message)
    {
        $form = sprintf('%s <%s>', $this->config['email']['from_name'], $this->config['email']['from_email']);
        /*$mailgun = \Mailgun\Mailgun::create('key-8cef2210bed7c5c71ce94a1f5480b4f9');
        $mailgun->messages()->send('sohelrana.me', [
            'from'    => $form,
            'to'      => $to,
            'subject' => $subject,
            'text'    => $message
        ]);*/

        $mg = \Mailgun\Mailgun::create($this->config['mailgun']['api_key']);
        $mg->messages()->send('sohelrana.me', [
            'from'    => 'info@sohelrana.me',
            'to'      => 'me.sohelrana@gmail.com',
            'subject' => $subject,
            'html'    => $message
        ]);
    }
}