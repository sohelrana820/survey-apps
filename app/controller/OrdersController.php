<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class OrdersController
 *
 * @package App\Controller
 */
class OrdersController extends AppController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return $this
     */
    public function backTo(Request $request, Response $response, $args)
    {
        $array = [
            'product_id' => 'ae6366cc-d14b-4e6f-8d43-bfd3304b6121',
            'amount' => rand(1, 15),
            'email' => 'sohel@previewtechs.com',
        ];
        $this->completeOrder($array);
    }

    /**
     * @param $data
     * @throws \Interop\Container\Exception\ContainerException
     */
    private function completeOrder($data)
    {
        $user  = [
            'email' => $data['email']
        ];

        $this->loadModel()->getUserModel()->addUser($user);
    }
}