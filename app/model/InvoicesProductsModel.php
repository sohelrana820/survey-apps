<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class InvoicesProductsModel
 *
 * @package App\Model
 */
class InvoicesProductsModel extends Model
{
    /**
     *  1 Hour cache validity period in seconds
     */
    const CACHE_VALIDITY_1HOUR = 3600;
    /**
     *  3 Hours cache validity period in seconds
     */
    const CACHE_VALIDITY_3HOURS = 10800;
    /**
     *  6 Hours cache validity period in seconds
     */
    const CACHE_VALIDITY_6HOURS = 21600;
    /**
     *  12 Hours cache validity period in seconds
     */
    const CACHE_VALIDITY_12HOURS = 43200;
    /**
     *  1 Day cache validity period in seconds
     */
    const CACHE_VALIDITY_1DAY = 86400;
    /**
     *  3 Days cache validity period in seconds
     */
    const CACHE_VALIDITY_3DAYS = 259200;
    /**
     *  5 Days cache validity period in seconds
     */
    const CACHE_VALIDITY_5DAYS = 432000;
    /**
     *  1 Week cache validity period in seconds
     */
    const CACHE_VALIDITY_1WEEK = 604800;
    /**
     *  1 Month cache validity period in seconds
     */
    const CACHE_VALIDITY_1MONTH = 2592000;
    /**
     * 1 Week cache validity period in seconds
     */
    const CACHE_VALIDITY_LONG = 604800;
    /**
     * 1 Month cache validity period in seconds
     */
    const CACHE_VALIDITY_VERY_LONG = 2592000;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var \Memcache;
     */
    private $cache;

    /**
     * @var string
     */
    protected $table = 'invoices_products';

    /**
     * @var array
     */
    protected $fillable = ['uuid', 'invoice_id', 'product_id', 'name', 'file_path', 'unit_price', 'quantity', 'subtotal', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'uuid' => 'string',
        'invoice_id' => 'integer',
        'product_id' => 'integer',
        'name' => 'string',
        'unit_price' => 'float',
        'quantity' => 'integer',
        'subtotal' => 'float',
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
     * @param $cache
     * @return $this;
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(InvoicesModel::class, 'invoice_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downloadLinks()
    {
        return $this->hasMany(DownloadLinksModel::class, 'invoices_products_id');
    }

    /**
     * @param $uuid
     * @param bool $forceCacheGenerate
     * @return array|null|string
     */
    public function getDetails($uuid, $forceCacheGenerate = false)
    {
        $cacheKey = sprintf('invoice_product_uuid_%s', $uuid);
        $details = $this->cache ? $this->cache->get($cacheKey) : null;

        if ($forceCacheGenerate === false && $details) {
            $this->logger ? $this->logger->info('Invoice Product Returned From Cache', ['invoice_product_uuid' => $uuid]) : null;
            return $details;
        }

        try {
            $details = $this->where('uuid', $uuid)->first();
            if ($details) {
                $this->logger ? $this->logger->info('Invoice Product Returned From DB', ['invoice_product_uuid' => $uuid]) : null;
                $this->cache ? $this->cache->set($cacheKey, $details->toArray(), self::CACHE_VALIDITY_1WEEK) : null;
                return $details->toArray();
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return null;
    }


    /**
     * @param $uuids
     * @return array
     */
    public function getBatch($uuids)
    {
        $cacheKeys = [];
        foreach ($uuids as $key => $value) {
            $cacheKeys[] = sprintf('invoice_product_uuid_%s', $value);
        }

        $invoiceProducts = $this->cache ? $this->cache->getMulti($cacheKeys) : [];
        if ($invoiceProducts && sizeof($invoiceProducts) === sizeof($uuids)) {
            return array_values($invoiceProducts);
        }

        $invoiceProducts = [];
        foreach ($uuids as $key => $value) {
            array_push($invoiceProducts, $this->getDetails($value));
        }
        return $invoiceProducts;
    }

    /**
     * @param $invoiceId
     * @return array
     */
    public function getProductsByInvoiceId($invoiceId)
    {
        $products = [];
        try {
            $invoiceProductsObj = $this->select('uuid')->where('invoice_id', $invoiceId)->get();
            if ($invoiceProductsObj) {
                $products = $invoiceProductsObj->toArray();
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        $uuids = [];
        foreach ($products as $product) {
            array_push($uuids, $product['uuid']);
        }
        return $this->getBatch($uuids);
    }
}
