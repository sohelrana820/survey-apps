<?php

namespace App\Controller;

use GuzzleHttp\Client;
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
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function order(Request $request, Response $response, $args)
    {
        $return = ['success' => true];
        $data = $request->getParsedBody();

        /**
         * Create or update user.
         */
        $userData  = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'is_auto_signup' => true
        ];
        $user = $this->loadModel()->getUserModel()->getUserByEmail($userData['email']);
        if(!$user) {
            $user = $this->loadModel()->getUserModel()->addUser($userData);
        }

        /**
         * Return [false] if user failed to saved or getting user details.
         */
        if(!$user) {
            $this->getLogger()->info('User Not Created', ['user_details' => $userData]);
            $this->getLogger()->info('Stooped The Ordering Flow');
            $return = ['success' => false];
            /**
             * @TODO need to do something
             */
        }

        /**
         * Create new order
         * If failed to create order [return = false]
         */
        $orderData = $this->prepareOrderData($data, $user);
        $order = $this->loadModel()->getOrderModel()->createOrder($orderData);
        if(!$order) {
            $this->getLogger()->info('Order Not Created', ['order_details' => $orderData]);
            $this->getLogger()->info('Stooped The Ordering Flow');
            $return = ['success' => false];
            /**
             * @TODO need to do something
             */
        }

        /**
         * Create new invoice
         * If failed to create invoice [return = false]
         */
        $invoiceData = $this->prepareInvoiceData($data, $user, $order);
        $invoice = $this->loadModel()->getInvoiceModel()->createInvoice($invoiceData);
        if(!$invoice) {
            $this->getLogger()->info('Invoice Not Created', ['invoice_details' => $invoiceData]);
            $this->getLogger()->info('Stooped The Ordering Flow');
            $return = ['success' => false];
            /**
             * @TODO need to do something
             */
        }

        /**
         * Increment product sales
         */
        $this->loadModel()->getProductModel()->singleFieldIncrement($data['product_uuid'], 'sales');

        /**
         * Generate download links
         */
        $downloadUrl = $request->getUri()->getBaseUrl() . '/download';
        $downloadLinks = $this->loadModel()->getDownloadLinkModel()->generateDownLinks($invoice['products'], $downloadUrl);

        /**
         * Send email to buyer
         */
        $invoiceDetails = [
            'user' => $user,
            'order' => $order,
            'invoice' => $invoice,
            'downloadLinks' => $downloadLinks
        ];
        $invoiceRender = $this->getView()->fetch('email/invoice.twig', ['data' => $invoiceDetails]);
        $to = sprintf('%s %s <%s>', $user['first_name'], $user['last_name'], $user['email']);
        $sent = $this->loadComponent()->Email()->send($to, 'Order Has Been Confirm - Theme Vessel', $invoiceRender);
        return $response->withStatus(200)->withJson($return);
    }


    public function sendLinks(Request $request, Response $response, $args)
    {
        // Check expected data is exist or not
        $postData = $request->getParsedBody();
        if(!array_key_exists('email', $postData) || !$postData['email']) {
            $return = [
                'success' => false,
                'message' => 'Please provide the valid email input'
            ];
            return $response->withJson($return);
        }

        // Check user is exist or not
        $user = $this->loadModel()->getUserModel()->getUserByEmail($postData['email']);
        if(!$user) {
            $return = [
                'success' => false,
                'message' => 'Sorry, we couldn\'t fetch this email address'
            ];
            return $response->withJson($return);
        }

        // Check this user purchased this item or not
        $generateProduct = false;
        $products = $this->loadModel()->getInvoiceModel()->getInvoiceProductsByUserId($user['id']);
        foreach ( $products as $product)
        {
            if($product['uuid'] == $postData['product_uuid']) {
                $generateProduct = $product;
            }
        }
        if(!$generateProduct) {
            $return = [
                'success' => false,
                'message' => 'Sorry, you didn\'t purchases this product'
            ];
            return $response->withJson($return);
        }

        /**
         * Generate download links
         */
        $data = [
            'product' => $generateProduct,
            'user' => $user,
        ];
        $downloadUrl = $request->getUri()->getBaseUrl() . '/download';
        $downloadLinks = $this->loadModel()->getDownloadLinkModel()->generateDownLinks($data, $downloadUrl);
        $data['downloadLinks'] = $downloadLinks;
        $invoiceRender = $this->getView()->fetch('email/send-link.twig', ['data' => $data]);
        $to = sprintf('%s %s <%s>', $user['first_name'], $user['last_name'], $user['email']);
        $this->loadComponent()->Email()->send($to, 'New Download Link - Theme Vessel', $invoiceRender);
        $return = [
            'success' => true,
            'message' => 'New Download link has been sent to your email address '
        ];
        return $response->withJson($return);
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
        $productDetails = $this->loadModel()->getProductModel()->getProduct($data['product_uuid']);
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
            'orderID' => $data['orderID'],
            'payerID' => $data['payerID'],
            'paymentID' => $data['paymentID'],
            'paymentToken' => $data['paymentToken'],
            'payment_create_time' => $data['payment_create_time'],
            'full_response' => $data['full_response'],
            'products' => [
                'uuid' => Uuid::uuid4()->toString(),
                'product_id' => $productDetails['id'],
                'name' => $productDetails['title'],
                'file_path' => $this->config['download_path'] .'/' .$productDetails['uuid'],
                'unit_price' => $productDetails['price'],
                'quantity' => 1,
                'subtotal' => $productDetails['price'],
            ],
        ];

        return $invoiceData;
    }
}