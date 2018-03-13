<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class ProductsModel
 *
 * @package App\Model
 */
class ProductsModel extends Model
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
     * @var \Memcached;
     */
    private $cache;

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = ['uuid', 'title', 'slug', 'thumb_image', 'main_image',
        'demo_url', 'description', 'price', 'sells', 'rating', 'total_viewed', 'download_path',
        'tags', 'layout', 'product_type', 'key_features', 'browsers_compatible', 'is_featured'];

    /**
     * @var array
     */
    protected $casts = [
        'uuid' => 'string',
        'title'    => 'string',
        'slug'    => 'string',
        'thumb_image' => 'string',
        'main_image' => 'string',
        'demo_url' => 'string',
        'description' => 'string',
        'price' => 'decimal',
        'sells' => 'integer',
        'rating' => 'decimal',
        'total_viewed' => 'integer',
        'download_path' => 'string',
        'tags' => 'string',
        'layout' => 'string',
        'product_type' => 'string',
        'key_features' => 'string',
        'browsers_compatible' => 'string',
        'is_featured' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $hidden = ['password'];

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
     * @return $this
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @param $productUuid
     * @param bool $forceCacheGenerate
     * @return array|null|string
     */
    public function getProduct($productUuid, $forceCacheGenerate = false)
    {
        $cacheKey = sprintf('product_uuid_%s', $productUuid);
        $details = $this->cache ? $this->cache->get($cacheKey) : null;


        if($forceCacheGenerate === false && $details) {
            $this->logger ? $this->logger->info('Product Returned From Cache', ['product_uuid' => $productUuid]) : null;
            return $details;
        }

        try{
            $details = $this->where('uuid', $productUuid)->first();
            if($details) {
                $this->logger ? $this->logger->info('Product Returned From DB', ['product_uuid' => $productUuid]) : null;
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
     * @param $productUuids
     * @return array
     */
    public function getProductBatch($productUuids)
    {
        $cacheKeys = [];
        foreach ($productUuids as $key => $value) {
            $cacheKeys[] = sprintf('product_uuid_%s', $value);
        }

        $products = $this->cache ? $this->cache->getMulti($cacheKeys) : [];
        if($products && sizeof($products) === sizeof($productUuids)) {
            return array_values($products);
        }

        $products = [];
        foreach ($productUuids as $key => $value) {
            array_push($products, $this->getProduct($value));
        }
        return $products;
    }

    /**
     * @param array $queryParams
     * @param array $options
     * @return array
     */
    public function searchProducts($queryParams = [], $options = [])
    {
        $page = 1;
        $perPage = 12;

        if(array_key_exists('page', $queryParams)) {
            $page = intval($queryParams['page']);
        }

        if(array_key_exists('perPage', $queryParams)) {
            $perPage = intval($queryParams['perPage']);
        }

        $products = [];
        try {
            $productsObj = $this;
            $productsObj = $productsObj->select('products.uuid');


            if(array_key_exists('cat', $queryParams)) {
                $productsObj = $productsObj->where('products_categories.category_id', 1);
            }

            $productsObj = $productsObj->paginate(
                $perPage,
                ['*'],
                'products',
                $page
            );
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        $uuids = [];
        foreach ($productsObj as $product) {
            array_push($uuids, $product['uuid']);
        }

        $products = $this->getProductBatch($uuids);
        return [
            'products' => $products,
            'searchedParams' => $queryParams,
            'pagination' => [
                'total' => $productsObj->total(),
                'lastPage' => $productsObj->lastPage(),
                'perPage' => $productsObj->perPage(),
                'currentPage' => $productsObj->currentPage(),
                'pageName' => $productsObj->getPageName(),
            ]
        ];
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getPopularProducts($limit = 8)
    {
        $products = [];
        try {
            $productsObj = $this->select('uuid')->orderBy('sales', 'DESC')->limit($limit)->get();
            if($productsObj) {
                $products = $productsObj->toArray();
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        $uuids = [];
        foreach ($products as $product) {
            array_push($uuids, $product['uuid']);
        }
        return $this->getProductBatch($uuids);
    }
}
