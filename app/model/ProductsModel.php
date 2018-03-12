<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class ProductsModel
 * @package App\Model
 */
class ProductsModel extends Model
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

}
