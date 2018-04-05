<?php

namespace App\Controller;

use App\helpers\Utility;
use Cake\Utility\Text;
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
        $this->getLogger() ? $this->getLogger()->info('Order Process Started', ['data' => $data]) : null;

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
        if (!$user) {
            $user = $this->loadModel()->getUserModel()->addUser($userData);
        }

        /**
         * Return [false] if user failed to saved or getting user details.
         */
        if (!$user) {
            $this->getLogger() ? $this->getLogger()->error('Failed to Manage Order\'s User', ['user' => $user]) : null;
            $return = ['success' => false];
            /**
             * @TODO need to do something
             */
        } else {
            $this->getLogger() ? $this->getLogger()->info('Order\'s User Managed', ['user' => $user]) : null;
        }

        /**
         * Create new order
         * If failed to create order [return = false]
         */
        $orderData = $this->prepareOrderData($data, $user);
        $order = $this->loadModel()->getOrderModel()->createOrder($orderData);
        if (!$order) {
            $this->getLogger()->error('Failed to Store Order Data', ['order_details' => $orderData]);
            $return = ['success' => false];
            /**
             * @TODO need to do something
             */
        } else {
            $this->getLogger()->info('Stored Order Data', ['order_details' => $orderData]);
        }

        /**
         * Create new invoice
         * If failed to create invoice [return = false]
         */
        $invoiceData = $this->prepareInvoiceData($data, $user, $order);
        $invoice = $this->loadModel()->getInvoiceModel()->createInvoice($invoiceData);
        if (!$invoice) {
            $this->getLogger()->error('Failed to Store Order Data', ['invoice_details' => $invoiceData]);
            $return = ['success' => false];
            /**
             * @TODO need to do something
             */
        } else {
            $this->getLogger()->info('Stored Order Data', ['invoice_details' => $invoiceData]);
        }

        /**
         * Increment product sales
         */
        $updated = $this->loadModel()->getProductModel()->singleFieldIncrement($data['product_uuid'], 'sales');
        if($updated) {
            $this->getLogger()->info('Product Sales Updated');
        }

        /**
         * Generate download links
         */
        $downloadUrl = Utility::baseURL() . '/download';
        $downloadLinks = $this->loadModel()->getDownloadLinkModel()->generateDownLinks($invoice['products'], $downloadUrl);
        if(count($downloadLinks) < 1) {
            $this->getLogger() ? $this->getLogger()->error('Failed to Generate Download Link') : null;
        }

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

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return static
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function sendLinks(Request $request, Response $response, $args)
    {
        // Check expected data is exist or not
        $postData = $request->getParsedBody();
        if (!array_key_exists('email', $postData) || !$postData['email']) {
            $return = [
                'success' => false,
                'message' => 'Please provide the valid email input'
            ];
            return $response->withJson($return);
        }

        $this->getLogger() ? $this->getLogger()->info('Sent Download Link Process Started') : null;

        // Check user is exist or not
        $user = $this->loadModel()->getUserModel()->getUserByEmail($postData['email']);
        if (!$user) {
            $return = [
                'success' => false,
                'message' => 'Sorry, we couldn\'t fetch this email address'
            ];
            $this->getLogger() ? $this->getLogger()->warning('Purchases Email Could\'nt Fetched', ['email_address' => $postData['email']]) : null;
            return $response->withJson($return);
        }

        // Check this user purchased this item or not
        $generateProduct = false;
        $products = $this->loadModel()->getInvoiceModel()->getInvoiceProductsByUserId($user['id']);
        foreach ($products as $product) {
            if ($product['uuid'] == $postData['product_uuid']) {
                $generateProduct[] = $product;
                break;
            }
        }
        if (!$generateProduct) {
            $return = [
                'success' => false,
                'message' => 'Sorry, you didn\'t purchases this product'
            ];
            $this->getLogger() ? $this->getLogger()->warning('Product Didn\'t Purchases By Email', ['email_address' => $postData['email']]) : null;
            return $response->withJson($return);
        }

        /**
         * Generate download links
         */
        $data = [
            'user' => $user,
        ];
        $downloadUrl = Utility::baseURL() . '/download';
        $downloadLinks = $this->loadModel()->getDownloadLinkModel()->generateDownLinks($generateProduct, $downloadUrl);
        if(count($downloadLinks) < 1) {
            $return = [
                'success' => false,
                'message' => 'Sorry, something went wrong download link does\'nt sent. Please try later'
            ];
            $this->getLogger() ? $this->getLogger()->error('Failed to Generate Download Link') : null;
            return $response->withJson($return);
        }

        $data['downloadLinks'] = $downloadLinks;
        $invoiceRender = $this->getView()->fetch('email/send-link.twig', ['data' => $data]);

        $this->getLogger() ? $this->getLogger()->info('Content Ready For Send Link', ['content' => $data]) : null;
        $to = sprintf('%s %s <%s>', $user['first_name'], $user['last_name'], $user['email']);
        $send = $this->loadComponent()->Email()->send($to, 'New Download Link - Theme Vessel', $invoiceRender);
        if($send) {
            $return = [
                'success' => true,
                'message' => 'New download link has been sent to your email address '
            ];
            $this->getLogger() ? $this->getLogger()->info('Download Link Sent!', ['content' => $data]) : null;
        } else {
            $return = [
                'success' => false,
                'message' => 'Sorry, something went wrong download link does\'nt sent. Please try later'
            ];
            $this->getLogger() ? $this->getLogger()->error('Failed To Sent Download Link', ['content' => $data]) : null;
        }

        $this->getLogger() ? $this->getLogger()->info('Sent Download Link Process Ended Successfully!') : null;
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
                'license_id' => Text::uuid(),
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
