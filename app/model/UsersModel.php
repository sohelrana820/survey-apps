<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class UsersModel
 *
 * @package App\Model
 */
class UsersModel extends Model
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
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'first_name', 'last_name', 'email', 'password', 'is_auto_signup', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'is_auto_signup' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @var array
     */
    //protected $hidden = ['password'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(AnswersModel::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function survey()
    {
        return $this->hasMany(UsersSurveysModel::class, 'user_id');
    }

    /**
     * JobsModel constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param $email
     * @return array|bool|null|string
     */
    public function getUserByEmail($email)
    {
        try {
            $user = $this->where('email', $email)->first();
            if ($user) {
                return $user->toArray();
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->info('Failed to Retrieve User', ['email' => $email]) : null;
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
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
        $perPage = 10;
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

            // Search by user's title
            if (array_key_exists('term', $queryParams)) {
                $term = $queryParams['term'];
            }

            $usersObj = $usersObj->orderBy($orderBy, $sortBy)->paginate(
                $perPage,
                ['*'],
                'survey/users',
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
