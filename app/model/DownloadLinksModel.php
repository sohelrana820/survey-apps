<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

/**
 * Class DownloadLinksModel
 *
 * @package App\Model
 */
class DownloadLinksModel extends Model
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var string
     */
    protected $table = 'download_links';

    /**
     * @var array
     */
    protected $fillable = ['invoices_products_id', 'product_id', 'link', 'download_completed', 'expired_at', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'invoices_products_id' => 'integer',
        'product_id' => 'integer',
        'link' => 'string',
        'download_completed' => 'string',
        'expired_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoiceProduct()
    {
        return $this->belongsTo(InvoicesProductsModel::class, 'invoices_products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'product_id');
    }
}
