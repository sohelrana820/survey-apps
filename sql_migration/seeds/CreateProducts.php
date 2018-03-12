<?php


use Phinx\Seed\AbstractSeed;

class CreateProducts extends AbstractSeed
{

    public function run()
    {
        $products = [
            [
                'uuid'    => 'ae6366cc-d14b-4e6f-8d43-bfd330eb6141',
                'title'    => 'Car Zone - Car Dealer HTML Template',
                'slug'    => 'car-zone-car-dealer-html-template',
                'thumb_image' => '',
                'main_image' => 'attachment/ae6366cc-d14b-4e6f-8d43-bfd330eb6141/main.jpg',
                'demo_url' => 'http://demo.themevessel.com/car-shop',
                'description' => 'Some methods in this library have requirements due to integer size restrictions on 32-bit and 64-bit builds of PHP. A 64-bit build of PHP and the Moontoast\Math library are recommended. However, this library is designed to work on 32-bit builds of PHP without Moontoast\Math, with some degraded functionality. Please check the API documentation for more information.',
                'price' => 12.20,
                'sells' => 5,
                'rating' => 4.5,
                'total_viewed' => 100,
                'download_path' => 'templates/download_items/car-zone-car-dealer-html-template.zip',
                'tags' => 'bootstrap, bootstrap 4, car dealer, automotive, auto car, car',
                'layout' => 'Responsive',
                'product_type' => 'paid',
                'key_features' => 'Responsive Layout,  Documentation, Bootstrap 3.x, Retina Ready',
                'browsers_compatible' => ' IE10, IE11, Edge, Chrome Firefox, Safari, Opera',
                'created_at' => '2018-01-30 16:30:45',
                'modified_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid'    => 'ee6366cc-d14b-4e6f-8d43-bfd3304b6121',
                'title'    => 'Auto Car - Car Dealer HTML Template',
                'slug'    => 'auto-car-estate-html-template',
                'thumb_image' => '',
                'main_image' => 'attachment/ee6366cc-d14b-4e6f-8d43-bfd3304b6121/main.jpg',
                'demo_url' => 'http://demo.themevessel.com/car-shop',
                'description' => 'Some methods in this library have requirements due to integer size restrictions on 32-bit and 64-bit builds of PHP. A 64-bit build of PHP and the Moontoast\Math library are recommended. However, this library is designed to work on 32-bit builds of PHP without Moontoast\Math, with some degraded functionality. Please check the API documentation for more information.',
                'price' => 15.00,
                'sells' => 25,
                'rating' => 3.5,
                'total_viewed' => 1200,
                'download_path' => 'templates/download_items/auto-car-estate-html-template.zip',
                'tags' => 'bootstrap, bootstrap 4, car dealer, automotive, auto car, car',
                'layout' => 'Responsive',
                'product_type' => 'paid',
                'key_features' => 'Responsive Layout,  Documentation, Bootstrap 3.x, Retina Ready',
                'browsers_compatible' => ' IE10, IE11, Edge, Chrome Firefox, Safari, Opera',
                'created_at' => '2018-01-30 16:30:45',
                'modified_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid'    => 'ae6366cc-d14b-4e6f-8d43-bfd3304b6141',
                'title'    => 'Realty - Real Estate HTML Template',
                'slug'    => 'realty-real-estate-html-template',
                'thumb_image' => '',
                'main_image' => 'attachment/ae6366cc-d14b-4e6f-8d43-bfd3304b6141/main.jpg',
                'demo_url' => 'http://demo.themevessel.com/car-shop',
                'description' => 'Some methods in this library have requirements due to integer size restrictions on 32-bit and 64-bit builds of PHP. A 64-bit build of PHP and the Moontoast\Math library are recommended. However, this library is designed to work on 32-bit builds of PHP without Moontoast\Math, with some degraded functionality. Please check the API documentation for more information.',
                'price' => 17.10,
                'sells' => 5,
                'rating' => 4.1,
                'total_viewed' => 1100,
                'download_path' => 'templates/download_items/realty-real-estate-html-template.zip',
                'tags' => 'bootstrap, bootstrap 4, real estate, properties, real estate agency',
                'layout' => 'Responsive',
                'product_type' => 'paid',
                'key_features' => 'Responsive Layout,  Documentation, Bootstrap 3.x, Retina Ready',
                'browsers_compatible' => ' IE10, IE11, Edge, Chrome Firefox, Safari, Opera',
                'created_at' => '2018-01-30 16:30:45',
                'modified_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid'    => 'ae6366cc-d14b-4e6f-8d43-bfd3304b6121',
                'title'    => 'The Nest - Real Estate HTML Template',
                'slug'    => 'the-nest-estate-html-template',
                'thumb_image' => '',
                'main_image' => 'attachment/ae6366cc-d14b-4e6f-8d43-bfd3304b6121/main.jpg',
                'demo_url' => 'http://demo.themevessel.com/car-shop',
                'description' => 'Some methods in this library have requirements due to integer size restrictions on 32-bit and 64-bit builds of PHP. A 64-bit build of PHP and the Moontoast\Math library are recommended. However, this library is designed to work on 32-bit builds of PHP without Moontoast\Math, with some degraded functionality. Please check the API documentation for more information.',
                'price' => 22.00,
                'sells' => 50,
                'rating' => 4.5,
                'total_viewed' => 100,
                'download_path' => 'templates/download_items/the-nest-estate-html-template.zip',
                'tags' => 'bootstrap, bootstrap 4, real estate, properties, real estate agency',
                'layout' => 'Responsive',
                'product_type' => 'paid',
                'key_features' => 'Responsive Layout,  Documentation, Bootstrap 3.x, Retina Ready',
                'browsers_compatible' => ' IE10, IE11, Edge, Chrome Firefox, Safari, Opera',
                'created_at' => '2018-01-30 16:30:45',
                'modified_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid'    => 'ae6366c1-d14b-4e6f-8d43-bfd3304b6121',
                'title'    => 'Hotel Alpha - Hotel HTML Responsive Template',
                'slug'    => 'hotel-alpha-hotel-responsive-template',
                'thumb_image' => '',
                'main_image' => 'attachment/ae6366c1-d14b-4e6f-8d43-bfd3304b6121/main.jpg',
                'demo_url' => 'http://demo.themevessel.com/car-shop',
                'description' => 'Some methods in this library have requirements due to integer size restrictions on 32-bit and 64-bit builds of PHP. A 64-bit build of PHP and the Moontoast\Math library are recommended. However, this library is designed to work on 32-bit builds of PHP without Moontoast\Math, with some degraded functionality. Please check the API documentation for more information.',
                'price' => 32.00,
                'sells' => 5,
                'rating' => 4.5,
                'total_viewed' => 100,
                'download_path' => 'templates/download_items/hotel-alpha-hotel-responsive-template.zip',
                'tags' => 'bootstrap, bootstrap 4, hotel, hotel listing',
                'layout' => 'Responsive',
                'product_type' => 'paid',
                'key_features' => 'Responsive Layout,  Documentation, Bootstrap 3.x, Retina Ready',
                'browsers_compatible' => ' IE10, IE11, Edge, Chrome Firefox, Safari, Opera',
                'created_at' => '2018-01-30 16:30:45',
                'modified_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $posts = $this->table('products');
        $posts->insert($products)
            ->save();
    }
}
