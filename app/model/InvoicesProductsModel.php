<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class InvoicesProductsModel
 *
 * @package App\Model
 */
class InvoicesProductsModel extends Model
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
    protected $table = 'invoices_products';

    /**
     * @var array
     */
    protected $fillable = ['uuid'];

    /**
     * @var array
     */
    protected $casts = [
        'uuid' => 'string',
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
}
