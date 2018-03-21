<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use Rhumsaa\Uuid\Uuid;

/**
 * Class DownloadLinksModel
 *
 * @package App\Model
 */
class DownloadLinksModel extends Model
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var string
     */
    protected $table = 'download_links';

    /**
     * @var array
     */
    protected $fillable = ['invoices_products_id', 'product_id', 'link', 'token', 'download_completed', 'downloaded_at', 'expired_at', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'invoices_products_id' => 'integer',
        'product_id' => 'integer',
        'link' => 'string',
        'token' => 'string',
        'downloaded_at' => 'datetime',
        'download_completed' => 'boolean',
        'expired_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @param $logger
     * @return $this
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoiceProduct()
    {
        return $this->belongsTo(InvoicesProductsModel::class, 'invoices_products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'product_id');
    }

    /**
     * @param $invoiceProducts
     * @param $home
     * @return array
     */
    public function generateDownLinks($invoiceProducts, $home){
        $result = [];
        foreach ($invoiceProducts as $product) {
            $token = Uuid::uuid4()->toString();
            $link = sprintf('%s?token=%s', $home, $token);
            $data = [
                'invoices_products_id' => $product['id'],
                'product_id' => $product['product_id'],
                'link' => $link,
                'token' => $token,
                'download_completed' => false,
                'expired_at' => date('Y-m-d H:i:s', strtotime("+20 minutes", strtotime(date('Y-m-d H:i:s'))))
            ];
            $created = $this->create($data);
            $result[] = $created->toArray();
        }

        return $result;
    }

    /**
     * @param $token
     * @return null
     */
    public function getDetailsByToken($token){
        try {
            $details = $this->where('download_links.token', $token)
                ->select('download_links.*', 'products.slug', 'products.download_path')
                ->join('products', function($products) {
                    $products->on('download_links.product_id', '=', 'products.id');
                })
                ->first();
            if($details) {
                $this->logger ? $this->logger->info('Download Info Fetch', ['token' => $token, 'download_info' => $details->toArray()]) : null;
                return $details->toArray();
            }
        } catch ( \Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return null;
    }
}
