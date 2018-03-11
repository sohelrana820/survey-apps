<?php


use Phinx\Seed\AbstractSeed;

class CreateProducts extends AbstractSeed
{

    public function run()
    {
        $products = [
            [
                'uuid'    => 'Sample Product',
                'title'    => 'Sample Product',
                'slug'    => 'Sample Product',
                'thumb_image' => '',
                'main_image' => '',
                'description' => '',
                'price' => 5,
                'sells' => 5,
                'rating' => 5,
                'total_viewed' => 5,
                'total_downloaded' => 5,
                'download_url' => 5,
                'tags' => 5,
                'created_at' => '2018-01-30 16:30:45',
                'modified_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $posts = $this->table('products');
        $posts->insert($products)
            ->save();
    }
}
