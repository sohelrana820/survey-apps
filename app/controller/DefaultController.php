<?php

namespace App\Controller;

use Previewtechs\WebsiteUtilities\RobotsDotTxtGenerator\RobotsDotTxtGenerator;
use Previewtechs\WebsiteUtilities\RobotsDotTxtGenerator\RobotsDotTxtRules;
use Previewtechs\WebsiteUtilities\SitemapGenerator\SitemapGenerator;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class DefaultController
 *
 * @package App\Controller
 */
class DefaultController extends AppController
{
    /**
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function beforeRender()
    {
        parent::beforeRender();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function robotsTXT(Request $request, Response $response)
    {
        $rulesOne = new RobotsDotTxtRules('*');
        $rulesOne->allow('/')
            ->allow('/pages/*')
            ->allow('/sitemap.xml')
            ->allow('/robots.txt');

        $robotGenerator = new RobotsDotTxtGenerator();
        $robotGenerator->setNewLine("\n");
        $robotGenerator->addRules($rulesOne);
        return $robotGenerator->respondAsTextFile($response);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function sitemapXML(Request $request, Response $response)
    {
        $urls = [
            $this->getSettings()['site_url'] => [
                'changefreq' => 'daily',
                'priority' => 1,
                'lastmod' => date('Y-m-d')
            ],
            $this->getSettings()['site_url'] . '/pages/contact-us' => [
                'changefreq' => 'weekly',
                'priority' => 1,
                'lastmod' => date('Y-m-d')
            ],
            $this->getSettings()['site_url'] . '/pages/faq' => [
                'changefreq' => 'weekly',
                'priority' => 1,
                'lastmod' => date('Y-m-d')
            ],
            $this->getSettings()['site_url'] . '/pages/privacy-policy' => [
                'changefreq' => 'weekly',
                'priority' => 1,
                'lastmod' => date('Y-m-d')
            ],
            $this->getSettings()['site_url'] . '/pages/terms-and-conditions' => [
                'changefreq' => 'weekly',
                'priority' => 1,
                'lastmod' => date('Y-m-d')
            ],
        ];

        try {
            $products = $this->loadModel()->getProductModel()->getActiveProductLists();
            foreach ($products as $key => $product) {
                $urls[$this->getSettings()['site_url'] . '/products/' . $key] = [
                    'changefreq' => 'weekly',
                    'priority' => 1,
                    'lastmod' => date('Y-m-d')
                ];
            }
        } catch (\Exception $exception) {
            $this->getLogger()->info('Failed to Fetch Job List');
        }

        $gen = new SitemapGenerator();
        $gen->loadUrls($urls);
        return $gen->respondAsXML($response);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function home(Request $request, Response $response, $args)
    {
        $products = $this->loadModel()->getProductModel()->getPopularProducts();
        $data = [
            'products' => $products,
        ];
        return $this->getView()->render($response, 'home.twig', $data);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function faqs(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'general/faqs.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function privacy(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'general/privacy-policy.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function termsAndConditions(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response, 'general/terms-and-conditions.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function contact(Request $request, Response $response, $args)
    {
        $data = [
            'captcha' => $this->config['google-re-captcha']
        ];
        return $this->getView()->render($response, 'general/contact-us.twig', $data);
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return static
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function contactUs(Request $request, Response $response, $args)
    {
        /**
         * Checking all expected fields is exist of not.
         */
        $postData = $request->getParsedBody();
        $requiredFields = ['name', 'email', 'purpose', 'subject', 'message'];
        foreach ($requiredFields as $key => $value) {
            if (!array_key_exists($value, $postData)) {
                $return = [
                    'success' => false,
                    'message' => 'All field is required'
                ];
                $this->getLogger() ? $this->getLogger()->info('Failed to Received Support Email', ['data' => $postData]) : null;
                return $response->withStatus(200)->withJson($return);
            }
        }

        /**
         * Fetching email template and then sent to message to support
         */
        $emailRender = $this->getView()->fetch('/email/contact.twig', ['data' => $postData]);
        $supportEmail = sprintf('%s <%s>', $this->config['email']['support_name'], $this->config['email']['support_email']);
        $replyTo = sprintf('%s <%s>', $postData['name'], $postData['email']);
        $this->loadComponent()->Email()->sendContactMesage($supportEmail, $replyTo, 'New Message Received', $emailRender);
        $this->getLogger() ? $this->getLogger()->info('Receive Support Email', ['data' => $postData]) : null;
        $return = [
            'success' => true,
            'message' => 'Thanks for getting in touch with us! We’ll get back to you shortly.'
        ];
        return $response->withStatus(200)->withJson($return);
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function notFoundPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response->withStatus(404), 'error/404.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function serverErrorPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response->withStatus(500), 'error/500.twig');
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function forbiddenPage(Request $request, Response $response, $args)
    {
        return $this->getView()->render($response->withStatus(403), 'error/403.twig');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface|static
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function download(Request $request, Response $response, $args)
    {
        $token = $request->getParam('token');
        $this->getLogger() ? $this->getLogger()->info('Someone Trying to Download Product', ['token' => $token]) : null;
        if (!$token) {
            $this->getLogger() ? $this->getLogger()->warning('Trying Download Without Token', ['token' => $token]) : null;
            return $response->withRedirect('/error/404');
        }

        $productDetails = $this->loadModel()->getDownloadLinkModel()->getDetailsByToken($token);
        $expiredAt = date('Y-m-d H:i:s', strtotime($productDetails['expired_at']));
        if (strtotime($expiredAt) < strtotime(date('Y-m-d H:i:s')) || $productDetails['download_completed'] == true) {
            $this->getLogger() ? $this->getLogger()->warning('Invalid or Expired Download Link', ['token' => $token, 'product_details' => $productDetails]) : null;
            return $this->getView()->render($response, 'error/download-error.twig');
        } else {
            $this->getView()->render($response, 'general/download-success.twig');
        }
        $this->getLogger() ? $this->getLogger()->info('Download Link Verified', ['token' => $token, 'product_details' => $productDetails]) : null;

        // Fetch and create license file
        $licenseContent = $this->getView()->fetch('general/license-format.twig', ['data' => $productDetails]);
        $tmpPath = $this->getSettings()['tmp_path'];
        $fp = fopen($tmpPath . "/LICENSE.txt","wb");
        $written = fwrite($fp,$licenseContent);
        if(!$written) {
            $this->getLogger() ? $this->getLogger()->error('Failed to Generate Licence File', ['token' => $token, 'product_details' => $productDetails]) : null;
        }
        fclose($fp);
        $this->getLogger() ? $this->getLogger()->info('Licence File Generate', ['token' => $token, 'product_details' => $productDetails]) : null;

        $downloadDocumentPath = $tmpPath . '/' . $productDetails['slug']. '.zip';
        $downloadDocumentName = $productDetails['slug']. '.zip';

        $zip = new \ZipArchive();
        if ($zip->open($downloadDocumentPath, \ZipArchive::CREATE) !== TRUE) {
            $this->getLogger() ? $this->getLogger()->error('Failed To Prepare Download Product', ['token' => $token, 'product_details' => $productDetails]) : null;
            exit("cannot open <$downloadDocumentPath>\n");
        }
        $zip->addFile($productDetails['download_path'], 'template.zip');
        $zip->addFile($tmpPath . "/LICENSE.txt", 'LICENSE.txt');
        $zip->close();
        $this->getLogger() ? $this->getLogger()->error('Prepared Download Products', ['token' => $token, 'product_details' => $productDetails]) : null;

        // Update download link fields.
        $data = [
            'download_completed' => true,
            'downloaded_at' => date('Y-m-d H:i:s'),
        ];
        $updated = $this->loadModel()->getDownloadLinkModel()->updateDownloadLinkd($productDetails['id'], $data);
        if ($updated) {
            $this->getLogger() ? $this->getLogger()->info('Product Download Completed', ['product_details' => $productDetails]) : null;
        }

        // Download the created zip file
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename = $downloadDocumentName");
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile("$downloadDocumentPath");

        // Remove some files
        unlink($downloadDocumentPath);
        unlink($tmpPath . "/LICENSE.txt");
        exit();
    }
}
