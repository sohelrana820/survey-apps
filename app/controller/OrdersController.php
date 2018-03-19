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
        $userData  = [
            'email' => $data['email'],
            'is_auto_signup' => true
        ];

        //  Create or update user.
        $user = $this->loadModel()->getUserModel()->getUserByEmail($userData['email']);
        if(!$user) {
            $user = $this->loadModel()->getUserModel()->addUser($userData);
        }

        // Return [false] if user failed to saved or getting user details.
        if(!$user) {
            $this->getLogger()->info('User Not Created', ['user_details' => $userData]);
            $this->getLogger()->info('Stooped The Ordering Flow');
            return false;
        }


        $orderData = [
            'user_id' => $user['id'],
            'fraud_check_status' => null,
            'fraud_check_result' => null,
            'ip_address' => 'string',
            'promo_code' => null,
            'amount' => $data['amount'],
            'notes' => 'Generic order',
        ];

        $order = $this->loadModel()->getOrderModel()->createOrder($orderData);
        var_dump($order);
    }
}