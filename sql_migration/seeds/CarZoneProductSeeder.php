<?php


use Phinx\Seed\AbstractSeed;

class CarZoneProductSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $description = <<<EOF
    Car Zone is a premium HTML5 template for car dealer related websites which is built with the
    twitter bootstrap (version: 3.3.6). This template is suitable for any agency, agent, car,
    car dealer, car listing, vehicle listing, car dealership, car tread, etc The whole template
    is made with excellent responsiveness.It provides Four different layouts of HOME page.
    It also contains 38 individual HTML files with 100% responsive & W3C HTML validate coding.
    All HTML & CSS codes are commented properly so it’s easily customizable.
    <br/>
<h4>Core Features:</h4>
    <hr/>
    <ul>
        <li>100% Responsive Layout</li>
        <li>38 HTML file</li>
        <li>4 Different HOME page</li>
        <li>3 Single Property page</li>
        <li>12 Available Color Schema</li>
        <li>Carousel Slider</li>
        <li>Simple Dropdown Navigation</li>
        <li>List / Grid / Map view on home listing</li>
        <li>Google Fonts used</li>
        <li>WOW animation used</li>
        <li>Font Awesome Icons & FlatIcon used</li>
        <li>Using Twitter Bootstrap (version 3.3.6)</li>
        <li>Easy to Customize.</li>
        <li>Properly commented in HTML & CSS codes.</li>
    </ul>

    <br/>
    <h4>Browser Compatibility</h4>
    <hr/>
    Works and looks good on all major browsers, tablets and phones

    <h4>Google Fonts:</h4>
    <hr/>
    Auto Dealer is using google fonts (Open Sans:400,300,600,700,800), (Playfair Display:400,700) & (Roboto:100,300,400,400,500,700)

    <h4>Important Note:</h4>
    <hr/>
    <p><strong>All images are available only DEMO are not it download package.</strong></p>
EOF;

        $products = [
            [
                'uuid'    => 'ae6366cc-d14b-4e6f-8d43-bfd330eb6141',
                'title'    => 'Car Zone - Car Dealer HTML Template',
                'slug'    => 'car-zone-car-dealer-html-template',
                'category_id' => 1,
                'user_id' => null,
                'thumb_image' => 'attachments/ae6366cc-d14b-4e6f-8d43-bfd330eb6141/thumb.jpg',
                'main_image' => 'attachments/ae6366cc-d14b-4e6f-8d43-bfd330eb6141/main.jpg',
                'demo_url' => 'https://template.themevessel.com/car-zone/index.html',
                'description' => $description,
                'price' => 2.00,
                'sales' => 5,
                'rating' => 4.5,
                'total_viewed' => 100,
                'download_path' => 'templates/download_items/car-zone-car-dealer-html-template.zip',
                'version' => '1.0.1',
                'tags' => 'car dealer, car, car dealer, Responsive, HTML template, car dealer template, car house, car listing, car selling, car template, motor template',
                'layout' => 'Responsive',
                'product_type' => 'paid',
                'key_features' => 'Responsive Layout,  Documentation, Bootstrap 3.x, Retina Ready',
                'browsers_compatible' => ' IE10, IE11, Edge, Chrome Firefox, Safari, Opera',
                'is_featured' => 0,
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
