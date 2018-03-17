<?php
require 'vendor/autoload.php';


$mg = \Mailgun\Mailgun::create('key-8cef2210bed7c5c71ce94a1f5480b4f9');

# Now, compose and send your message.
# $mg->messages()->send($domain, $params);
/*$mg->messages()->send('sohelrana.me', [
    'from'    => 'info@sohelrana.me',
    'to'      => 'me.sohelrana@gmail.com',
    'subject' => 'How You Theme Worked',
    'text'    => 'I have purchased your Car Deaelr - WP Theme.'
]);*/