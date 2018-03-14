<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class CategoriesModel
 *
 * @package App\Model
 */
class CategoriesModel extends Model
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
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'created_at', 'modified_at'];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
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
     * @return $this
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(ProductsModel::class, 'products_categories', 'category_id', 'product_id');
    }

    /**
     * @param $categorySlug
     * @param bool         $forceCacheGenerate
     * @return mixed|null
     */
    public function getCategory($categorySlug, $forceCacheGenerate = false)
    {
        $cacheKey = sprintf('category_slug_%s', str_replace('-', '_', $categorySlug));
        $details = $this->cache ? $this->cache->get($cacheKey) : null;
        if ($forceCacheGenerate === false && $details) {
            $this->logger ? $this->logger->info('Category Returned From Cache', ['category_slug' => $categorySlug]) : null;
            return $details;
        }

        try {
            $details = $this->where('slug', $categorySlug)->first();
            if ($details) {
                $this->logger ? $this->logger->info('Category Returned From DB', ['category_slug' => $categorySlug]) : null;
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
     * @param $categorySlugs
     * @return array|mixed
     */
    public function getCategoryBatch($categorySlugs)
    {
        $cacheKeys = [];
        foreach ($categorySlugs as $key => $value) {
            $cacheKeys[] = sprintf('category_slug_%s', str_replace('-', '_', $value));
        }

        $categories = $this->cache ? $this->cache->getMulti($cacheKeys) : [];
        if ($categories && sizeof($categories) === sizeof($categorySlugs)) {
            return array_values($categories);
        }

        $categories = [];
        foreach ($categorySlugs as $key => $value) {
            array_push($categories, $this->getCategory($value));
        }
        return $categories;
    }


    /**
     * @return array|mixed
     */
    public function getMostProductsCategories()
    {
        $categories = [];
        try {
            $categoryObj = $this->selectRaw('categories.slug, count(products_categories.product_id) as total_products')
                ->leftjoin(
                    'products_categories', function ($join) {
                        $join->on('categories.id', '=', 'products_categories.category_id');
                    }
                )
                ->groupBy('categories.id')->orderBy('total_products', 'DESC')
                ->get();
            $categories = $categoryObj->toArray();
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        $uuids = [];
        foreach ($categories as $category) {
            array_push($uuids, $category['slug']);
        }

        return $this->getCategoryBatch($uuids);
    }


    /**
     * @return array|mixed
     */
    public function getCategories()
    {
        $categories = [];
        try {
            $categoryObj = $this->select('slug')->get();
            if ($categoryObj) {
                $categories = $categoryObj->toArray();
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        $uuids = [];
        foreach ($categories as $category) {
            array_push($uuids, $category['slug']);
        }
        return $this->getCategoryBatch($uuids);
    }
}
