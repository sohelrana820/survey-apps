<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Monolog\Logger;

/**
 * Class QuestionsModel
 *
 * @package App\Model
 */
class AnswersModel extends Model
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
    protected $table = 'answers';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(QuestionsModel::class, 'question_id');
    }

    /**
     * @param $productUuid
     * @param bool        $forceCacheGenerate
     * @return array|null|string
     */
    public function getProduct($productUuid, $forceCacheGenerate = false)
    {
        $cacheKey = sprintf('product_uuid_%s', $productUuid);
        $details = $this->cache ? $this->cache->get($cacheKey) : null;

        if ($forceCacheGenerate === false && $details) {
            $this->logger ? $this->logger->info('Product Returned From Cache', ['product_uuid' => $productUuid]) : null;
            return $this->mappingProductDetails($details);
        }

        try {
            $details = $this->where('uuid', $productUuid)->first();
            if ($details) {
                $this->logger ? $this->logger->info('Product Returned From DB', ['product_uuid' => $productUuid]) : null;
                $this->cache ? $this->cache->set($cacheKey, $details->toArray(), self::CACHE_VALIDITY_1WEEK) : null;
                return $this->mappingProductDetails($details->toArray());
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return null;
    }

    /**
     * @param $slug
     * @param bool $forceCacheGenerate
     * @return array|null|string
     */
    public function getProductBySlug($slug, $forceCacheGenerate = false)
    {
        $uuid = $this->getProductUuidBySlug($slug, $forceCacheGenerate);
        return $this->getProduct($uuid, $forceCacheGenerate);
    }

    /**
     * @param $productUuid
     * @param $field
     * @return bool
     */
    public function singleFieldIncrement($productUuid, $field)
    {
        try {
            $updated = $this->where('uuid', $productUuid)->increment($field);
            if ($updated > 0) {
                $this->logger ? $this->logger->info('Product Product Field', ['product_uuid' => $productUuid, 'field' => $field]) : null;
                $this->getProduct($productUuid, true);
                return true;
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return false;
    }

    /**
     * @param $details
     * @return mixed
     */
    private function mappingProductDetails($details)
    {
        $categoryModel = new CategoriesModel();
        $categoryModel->setCache($this->cache);
        $categoryModel->setLogger($this->logger);
        $details['category'] = $categoryModel->getCategoryById($details['category_id']);
        $details['tags'] = explode(',', $details['tags']);
        $details['key_features'] = explode(',', $details['key_features']);
        $details['browsers_compatible'] = explode(',', $details['browsers_compatible']);
        return $details;
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
        if ($products && sizeof($products) === sizeof($productUuids)) {
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
     * @param $answers
     * @param $userId
     * @param $surveyId
     * @return bool
     */
    public function manageSurveyAnswer($answers, $userId, $surveyId)
    {
        try {
            /**
             * Delete all previous answer if the user has already complete this survey.
             */
            $previousAnswers = $this->where('user_id', $userId)->where('survey_id', $surveyId)->delete();

            $stored = $this->insert($answers);
            if($stored)
            {
                return true;
            }
        } catch (\Exception $exception)
        {

        }

        return false;
    }

    /**
     * @param $answers
     * @param $userId
     * @param $surveyId
     * @return bool
     */
    public function getAnswers($userId, $surveyId)
    {
        try {
            /**
             * Delete all previous answer if the user has already complete this survey.
             */
            $answers = $this->where('user_id', $userId)->where('survey_id', $surveyId)->get();
            if($answers){
                return $answers;
            }

        } catch (\Exception $exception)
        {

        }

        return [];
    }

    /**
     * @param array $queryParams
     * @param array $options
     * @return array
     */
    public function searchAnswers($queryParams = [], $options = [])
    {
        $page = 1;
        $perPage = 100;
        $orderBy = 'score';
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

        try {
            $answerObj = AnswersModel::with('question')
                ->selectRaw(
                    'question_id, 
                SUM(total_score) as score, 
                SUM(impact_group_size) as impact_group_size_score, 
                SUM(occurrence_frequency) as occurrence_frequency_score,
                SUM(experience_impact) as experience_impact_score,
                SUM(business_impact) as business_impact_score,
                SUM(financial_feasibility) as financial_feasibility_score,
                SUM(technical_feasibility) as technical_feasibility_score,
                COUNT(user_id) as rated_by'
                )
                ->groupBy('question_id')->orderBy($orderBy, $sortBy)->paginate(
                    $perPage,
                    ['*'],
                    'survey/questions',
                    $page
                );
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return [
            'answers' => $answerObj,
            'searchedParams' => $queryParams,
            'pagination' => [
                'total' => $answerObj->total(),
                'page' => $page,
                'totalPage' => $answerObj->lastPage(),
                'perPage' => $answerObj->perPage(),
                'currentPage' => $answerObj->currentPage(),
                'pageName' => $answerObj->getPageName(),
                'paginationSuffix' => http_build_query($paginationSuffix),
                'paginationSuffixRaw' => $paginationSuffix,
            ]
        ];
    }
}
