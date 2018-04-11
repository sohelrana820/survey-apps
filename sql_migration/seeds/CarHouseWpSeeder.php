<?php


use Phinx\Seed\AbstractSeed;

class CarHouseWpSeeder extends AbstractSeed
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
    Car House is a modern and full featured automotive car dealer wordpress theme to acquire your all auto dealer business needs.
    This theme is suitable for for any agency, agent, car, car dealer, car listing, vehicle listing, car dealership, car tread, etc.
    Our Car Classified Ads theme comes with effective vehicle search functionality that makes it
    Perfect for buyers to look after various Cars or Vehicle Models available. This theme is available with theme option, several page templates, fonts, custom widgets,
    shortcodes and much more for your all classifieds business requirement
    <br/>
    <h4>Core Features:</h4>
    <hr/>
    <ul>
        <li>100% <strong>Responsive Layout</strong></li>
        <li>Vehicle Listings – easy to add, edit, and remove as your inventory changes</li>
        <li>Manage Teams – easy to add, edit, and remove as your team members</li>
        <li>Manage Services – easy to add, edit, and remove as your services</li>
        <li>Manage FAQs – easy to add, edit, and remove as your faqs</li>
        <li>Manage Testimonials – easy to add, edit, and remove as your testimonials</li>
        <li>Filterable Inventory – listings are completely filterable & sortable</li>
        <li>Custom Taxonomies – easily customize to suit your website</li>
        <li>Different Layout on all specific page</li>
        <li>7 Template Pages</li>
        <li>7+ Inner Pages</li>
        <li>Redux Framework</li>
        <li>Modern and Clean Design</li>
        <li>Working Contact form</li>
        <li>Using <strong>Twitter Bootstrap</strong> (version 3.3.6)</li>
        <li>Easy to Customize</li>
        <li>Fast Performance</li>
        <li>Google Map</li>
        <li>Fast Performance</li>
        <li>Cross Browser Optimization</li>
        <li>Well Documented</li>
    </ul>
    <br/>

    <h4>Browser Compatibility</h4>
    <hr/>
    Works and looks good on all major browsers, tablets and phones

    <h4>Google Fonts:</h4>
    <hr/>
    Auto Dealer is using google fonts (Open Sans:400,300,600,700,800), (PT Sans Narrow:400,700)

    <h4>Important Note:</h4>
    <hr/>
    <p><strong>All images are available only DEMO are not it download package.</strong></p>
EOF;

        $products = [
            [
                'uuid'    => 'ae6366cc-d14b-4e6f-8d43-bfd330eb6142',
                'title'    => 'Car House - WordPress Car Dealer Theme',
                'slug'    => 'car-house-wordpress-car-dealer-theme',
                'category_id' => 2,
                'user_id' => null,
                'thumb_image' => 'attachments/ae6366cc-d14b-4e6f-8d43-bfd330eb6142/thumb.jpg',
                'main_image' => 'attachments/ae6366cc-d14b-4e6f-8d43-bfd330eb6142/main.jpg',
                'demo_url' => 'http://wp.themevessel.com/car-house',
                'description' => $description,
                'price' => 19.00,
                'sales' => 12,
                'rating' => 4.5,
                'total_viewed' => 100,
                'download_path' => 'car-house-wordpress-car-dealer-theme.zip',
                'version' => '1.0.1',
                'tags' => 'car, car dealer, auto, automobile, auto dealer, car shop, car listing theme, car dealer wordpress, cab dealer, vehicles, car dealership, automotive wordpress theme, vehicle search, car wordpress',
                'layout' => 'Responsive',
                'product_type' => 'paid',
                'key_features' => 'Responsive Layout,  Documentation, Bootstrap 3.x, Retina Ready',
                'browsers_compatible' => ' IE10, IE11, Edge, Chrome Firefox, Safari, Opera',
                'is_featured' => 1,
                'status' => 1,
                'meta_title' => 'Car House - WordPress Car Dealer Theme | ThemeVessel',
                'meta_description' => 'Buy Car Car House is a modern and full featured automotive car dealer wordpress theme to acquire your all auto dealer business needs.',
                'meta_image' => 'attachments/ae6366cc-d14b-4e6f-8d43-bfd330eb6142/main.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $productsTable = $this->table('products');
        $productsTable->insert($products)
            ->save();
    }
}
