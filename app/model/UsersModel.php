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
     * @var array
     */
    protected $fillable = ['uuid', 'first_name', 'last_name', 'email', 'password', 'is_auto_signup'];

    /**
     * @var array
     */
    protected $casts = [
        'uuid' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'is_auto_signup' => 'boolean',
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
}
