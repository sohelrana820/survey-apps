<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsCategoriesModel
 *
 * @package App\Model
 */
class ProductsCategoriesModel extends Model
{

    /**
     * @var string
     */
    protected $table = 'products_categories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(CategoriesModel::class, 'category_id');
    }
}
