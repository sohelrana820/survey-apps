<?php

use Phinx\Seed\AbstractSeed;

/**
 * Class CarZoneProduct
 */
class CarZoneProduct extends AbstractSeed
{
    public function run()
    {
        parent::run();
        $products = [
            [
                'uuid'    => 'ae6366cc-d14b-4e6f-8d43-bfd330eb6141',
                'title'    => 'Car Zone - Car Dealer HTML Template',
                'slug'    => 'car-zone-car-dealer-html-template',
                'category_id' => 1,
                'user_id' => null,
                'thumb_image' => 'attachments/ae6366cc-d14b-4e6f-8d43-bfd330eb6141/thumb.jpg',
                'main_image' => 'attachments/ae6366cc-d14b-4e6f-8d43-bfd330eb6141/main.jpg',
                'demo_url' => 'http://demo.themevessel.com/car-shop',
                'description' => 'Some methods in this library have requirements due to integer size restrictions on 32-bit and 64-bit builds of PHP. A 64-bit build of PHP and the Moontoast\Math library are recommended. However, this library is designed to work on 32-bit builds of PHP without Moontoast\Math, with some degraded functionality. Please check the API documentation for more information.',
                'price' => 2.20,
                'sales' => 5,
                'rating' => 4.5,
                'total_viewed' => 100,
                'download_path' => 'templates/download_items/car-zone-car-dealer-html-template.zip',
                'version' => '1.0.1',
                'tags' => 'bootstrap, bootstrap 4, car dealer, automotive, auto car, car',
                'layout' => 'Responsive',
                'product_type' => 'paid',
                'key_features' => 'Responsive Layout,  Documentation, Bootstrap 3.x, Retina Ready',
                'browsers_compatible' => ' IE10, IE11, Edge, Chrome Firefox, Safari, Opera',
                'is_featured' => 1,
                'status' => 1,
                'meta_title' => 'Car House - Car Dealer Template | ThemeVessel',
                'meta_description' => 'Buy Car Zone is a premium HTML5 template for car dealer related websites which is built with the twitter bootstrap. This template is suitable for car dealer ...',
                'meta_image' => 'attachments/ae6366cc-d14b-4e6f-8d43-bfd330eb6141/main.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $productsTable = $this->table('products');
        $productsTable->insert($products)
            ->save();
    }
}