<?php

namespace App\Controller;

use Rhumsaa\Uuid\Uuid;
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
            'product_id' => 'ae6366c1-d14b-4e6f-8d43-bfd3304b6121',
            'amount' => rand(1, 15),
            'email' => 'sohel@previewtechs.com',
        ];
        $this->completeOrder($array);
    }

    /**
     * @param $data
     * @return bool
     * @throws \Interop\Container\Exception\ContainerException
     */
    private function completeOrder($data)
    {
        //  Create or update user.
        $userData  = [
            'email' => $data['email'],
            'is_auto_signup' => true
        ];
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

        // Create new order
        $orderData = $this->prepareOrderData($data, $user);
        $order = $this->loadModel()->getOrderModel()->createOrder($orderData);

        // Return [false] if order not create.
        if(!$order) {
            $this->getLogger()->info('Order Not Created', ['order_details' => $orderData]);
            $this->getLogger()->info('Stooped The Ordering Flow');
            return false;
        }

        // Create new invoice
        $invoiceData = $this->prepareInvoiceData($data, $user, $order);
        $invoice = $this->loadModel()->getInvoiceModel()->createInvoice($invoiceData);

        // Return [false] if invoice not create.
        if(!$invoice) {
            $this->getLogger()->info('Invoice Not Created', ['invoice_details' => $invoiceData]);
            $this->getLogger()->info('Stooped The Ordering Flow');
            return false;
        }

        $downloadLink =
        var_dump($user, $order, $invoice);
        die();
    }

    /**
     * @param $data
     * @param $user
     * @return array
     */
    private function prepareOrderData($data, $user)
    {
        $orderData = [
            'user_id' => $user['id'],
            'fraud_check_status' => null,
            'fraud_check_result' => null,
            'ip_address' => 'string',
            'promo_code' => null,
            'amount' => $data['amount'],
            'notes' => 'Generic order',
        ];

        return $orderData;
    }

    /**
     * @param $data
     * @param $user
     * @param $order
     * @return array
     * @throws \Interop\Container\Exception\ContainerException
     */
    private function prepareInvoiceData($data, $user, $order)
    {
        $productDetails = $this->loadModel()->getProductModel()->getProduct($data['product_id']);
        $invoiceData = [
            'order_id' => $order['id'],
            'user_id' => $user['id'],
            'subtotal' => $data['amount'],
            'vat' => 0,
            'tax' => 0,
            'discount' => 0,
            'total' => $data['amount'],
            'invoice_date' => date('Y-m-d H:i:s'),
            'due_date' => date('Y-m-d H:i:s'),
            'status' => 'paid',
            'products' => [
                'uuid' => Uuid::uuid4()->toString(),
                'product_id' => $productDetails['id'],
                'name' => $productDetails['title'],
                'file_path' => $productDetails['uuid'],
                'unit_price' => $productDetails['price'],
                'quantity' => 1,
                'subtotal' => $productDetails['price'],
            ],
        ];

        return $invoiceData;
    }
}