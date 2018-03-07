<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class UsersModel
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
    protected $fillable = ['uuid', 'first_name', 'last_name', 'email', 'password'];

    /**
     * @var array
     */
    protected $casts = [
        'uuid' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
    ];

    /**
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * @param Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param \Memcache $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }
}