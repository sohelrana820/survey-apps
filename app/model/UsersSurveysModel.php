<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class UsersSurveysModel
 *
 * @package App\Model
 */
class UsersSurveysModel extends Model
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
    protected $table = 'users_surveys';

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
    public function user()
    {
        return $this->belongsTo(UsersModel::class, 'user_id');
    }

    /**
     * @param $answers
     * @param $userId
     * @param $surveyId
     * @return bool
     */
    public function makeSurveyComplete($userId, $surveyId)
    {
        try {
            /**
             * Delete all previous answer if the user has already complete this survey.
             */
            $alreadyCompleted = $this->where('user_id', $userId)->where('survey_id', $surveyId)->first();
            if($alreadyCompleted){
                return true;
            }

            $data['user_id'] = $userId;
            $data['survey_id'] = $surveyId;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $stored = $this->insert($data);
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
     * @param $userId
     * @param $surveyId
     * @return bool
     */
    public function isUserCompleteSurvey($userId, $surveyId)
    {
        try {
            /**
             * Delete all previous answer if the user has already complete this survey.
             */
            $completed = $this->where('user_id', $userId)->where('survey_id', $surveyId)->first();
            if($completed){
                return true;
            }

        } catch (\Exception $exception)
        {

        }

        return false;
    }

    /**
     * @param array $queryParams
     * @param array $options
     * @return array
     */
    public function searchUsers($queryParams = [], $options = [])
    {
        $page = 1;
        $perPage = 8;
        $orderBy = 'id';
        $sortBy = 'ASC';

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
            $usersObj = $this;
            $usersObj = $usersObj->orderBy($orderBy, $sortBy)->paginate(
                $perPage,
                ['*'],
                'survey',
                $page
            );
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return [
            'users' => $usersObj,
            'searchedParams' => $queryParams,
            'pagination' => [
                'total' => $usersObj->total(),
                'page' => $page,
                'totalPage' => $usersObj->lastPage(),
                'perPage' => $usersObj->perPage(),
                'currentPage' => $usersObj->currentPage(),
                'pageName' => $usersObj->getPageName(),
                'paginationSuffix' => http_build_query($paginationSuffix),
                'paginationSuffixRaw' => $paginationSuffix,
            ]
        ];
    }
}
