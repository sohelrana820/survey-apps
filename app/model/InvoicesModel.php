<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use Rhumsaa\Uuid\Uuid;

/**
 * Class Invoicesodel
 *
 * @package App\Model
 */
class InvoicesModel extends Model
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
    protected $table = 'invoices';

    /**
     * @var array
     */
    protected $fillable = ['uuid', 'order_id', 'user_id', 'subtotal', 'vat', 'tax', 'discount', 'total', 'invoice_date',
        'due_date', 'status', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'uuid' => 'string',
        'order_id' => 'integer',
        'user_id' => 'integer',
        'subtotal' => 'float',
        'vat' => 'float',
        'tax' => 'float',
        'discount' => 'float',
        'total' => 'float',
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
        'status' => 'string',
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
    public function order()
    {
        return $this->belongsTo(OrdersModel::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(InvoicesProductsModel::class, 'invoice_id');
    }

    /**
     * @param $data
     * @return array|bool|null|string
     */
    public function createInvoice($data)
    {
        if(!array_key_exists('uuid', $data) || !$data['uuid']) {
            $data['uuid'] = Uuid::uuid4()->toString();
        }

        try {
            $created = $this->create($data);
            if($created) {
                $created->products()->create($data['products']);
                $created = $created->toArray();
                $invoice = $this->getDetails($created['uuid']);
                $this->logger ? $this->logger->info('New Invoice Created', ['invoice_details' => $invoice]) : null;
                unset($created, $data);
                return $invoice;
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return false;
    }


    /**
     * @param $uuid
     * @param bool $forceCacheGenerate
     * @return array|null|string
     */
    public function getDetails($uuid, $forceCacheGenerate = false)
    {
        $cacheKey = sprintf('invoice_uuid_%s', $uuid);
        $details = $this->cache ? $this->cache->get($cacheKey) : null;

        if($forceCacheGenerate === false && $details) {
            $this->logger ? $this->logger->info('Invoice Returned From Cache', ['invoice_uuid' => $uuid]) : null;
            return $this->mappingInvoiceData($details);
        }

        try{
            $details = $this->where('uuid', $uuid)->first();
            if($details) {
                $this->logger ? $this->logger->info('Invoice Returned From DB', ['invoice_uuid' => $uuid]) : null;
                $this->cache ? $this->cache->set($cacheKey, $details->toArray(), self::CACHE_VALIDITY_1WEEK) : null;
                return $this->mappingInvoiceData($details->toArray());
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return null;
    }

    /**
     * @param $details
     * @return mixed
     */
    private function mappingInvoiceData($details)
    {
        $invoiceProductsModel = new InvoicesProductsModel();
        $invoiceProductsModel->setCache($this->cache);
        $invoiceProductsModel->setLogger($this->logger);
        $details['products'] = $invoiceProductsModel->getProductsByInvoiceId($details['id']);
        return $details;
    }
}
