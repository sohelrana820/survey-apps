<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class QuestionsModel
 *
 * @package App\Model
 */
class QuestionsModel extends Model
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
    protected $table = 'questions';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function answers()
    {
        return $this->belongsTo(AnswersModel::class, 'question_id');
    }

    /**
     * @param array $queryParams
     * @param array $options
     * @return array
     */
    public function searchProducts($queryParams = [], $options = [])
    {
        $page = 1;
        $perPage = 8;
        $orderBy = 'id';
        $sortBy = 'DESC';

        if (array_key_exists('page', $queryParams)) {
            $page = intval($queryParams['page']);
        }

        if (array_key_exists('perPage', $queryParams)) {
            $perPage = intval($queryParams['perPage']);
        }

        if (array_key_exists('order', $queryParams)) {
            $orderBy = $queryParams['order'];
        }

        if (array_key_exists('sort', $queryParams)) {
            $sortBy = $queryParams['sort'];
        }

        $paginationSuffix = $queryParams;
        if (array_key_exists('page', $paginationSuffix)) {
            unset($paginationSuffix['page']);
        }

        $products = [];
        try {
            $productsObj = $this;
            $productsObj = $productsObj->select('products.uuid');

            // Search by product's title
            if (array_key_exists('title', $queryParams)) {
                $productsObj = $productsObj->where('title', 'LIKE', '%' .$queryParams['title']. '%');
            }

            // Search by featured
            if (array_key_exists('featured', $queryParams)) {
                $productsObj = $productsObj->where('is_featured', 1);
            }

            // Search by recent
            if (array_key_exists('recent', $queryParams)) {
                $orderBy = 'id';
            }

            // Search by popular
            if (array_key_exists('popular', $queryParams)) {
                $productsObj = $productsObj->where('sales', '>', 0);
                $orderBy = 'total_viewed';
            }

            // Search by product's tag
            if (array_key_exists('tag', $queryParams)) {
                $productsObj = $productsObj->where('tags', 'LIKE', '%' .$queryParams['tag']. '%');
            }

            // Search by product's category
            if (array_key_exists('cat', $queryParams)) {
                $catModel = new CategoriesModel();
                $catModel->setCache($this->cache);
                $catModel->setLogger($this->logger);
                $category = $catModel->getCategory($queryParams['cat']);
                $productsObj = $productsObj->where('category_id', $category['id']);
            }
            $productsObj = $productsObj->orderBy($orderBy, $sortBy)->paginate(
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
                'page' => $page,
                'totalPage' => $productsObj->lastPage(),
                'perPage' => $productsObj->perPage(),
                'currentPage' => $productsObj->currentPage(),
                'pageName' => $productsObj->getPageName(),
                'paginationSuffix' => http_build_query($paginationSuffix),
                'paginationSuffixRaw' => $paginationSuffix,
            ]
        ];
    }

    /**
     * @return array
     */
    public function getAllQuestions()
    {
        try {
            $questions = $this->get();
            return $questions->toArray();
        } catch (\Exception $exception)
        {

        }

        return [];
    }
}
