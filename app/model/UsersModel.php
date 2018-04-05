<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use Rhumsaa\Uuid\Uuid;

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
        'uuid' => 'string',
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
    public function products()
    {
        return $this->hasMany(ProductsModel::class, 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(OrdersModel::class, 'users_id');
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
     * @param $data
     * @return array|bool|null|string
     */
    public function addUser($data)
    {
        if (!array_key_exists('uuid', $data) || !$data['uuid']) {
            $data['uuid'] = Uuid::uuid4()->toString();
        }

        try {
            $created = $this->create($data);
            if ($created) {
                $created = $created->toArray();
                $user = $this->getDetails($created['uuid']);
                $this->logger ? $this->logger->info('New User Created', ['user_details' => $user]) : null;
                unset($created, $data);
                return $user;
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error('Failed to Create User', ['data' => $data]) : null;
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return false;
    }

    /**
     * @param $email
     * @return array|bool|null|string
     */
    public function getUserByEmail($email)
    {
        try {
            $user = $this->select('uuid')->where('email', $email)->first();
            if ($user) {
                $user = $user->toArray();
                return array_key_exists('uuid', $user) ? $this->getDetails($user['uuid']) : false;
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
        $cacheKey = sprintf('user_uuid_%s', $uuid);
        $details = $this->cache ? $this->cache->get($cacheKey) : null;

        if ($forceCacheGenerate === false && $details) {
            $this->logger ? $this->logger->info('User Returned From Cache', ['user_uuid' => $uuid]) : null;
            return $details;
        }

        try {
            $details = $this->where('uuid', $uuid)->first();
            if ($details) {
                $this->logger ? $this->logger->info('User Returned From DB', ['user_uuid' => $uuid]) : null;
                $this->cache ? $this->cache->set($cacheKey, $details->toArray(), self::CACHE_VALIDITY_1WEEK) : null;
                return $details->toArray();
            }
        } catch (\Exception $exception) {
            $this->logger ? $this->logger->error($exception->getMessage()) : null;
            $this->logger ? $this->logger->debug($exception->getTraceAsString()) : null;
        }

        return null;
    }
}
