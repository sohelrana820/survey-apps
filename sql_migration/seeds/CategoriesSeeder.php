<?php


use Phinx\Seed\AbstractSeed;

class CategoriesSeeder extends AbstractSeed
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
        $categories = [
            [
                'name'    => 'Website Template',
                'slug'    => 'website-template',
                'status' => 1,
                'created_at' => '2018-01-30 16:30:45',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'    => 'WordPress Theme',
                'slug'    => 'wordpress-theme',
                'status' => 1,
                'created_at' => '2018-01-30 16:30:45',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'    => 'UI Kits',
                'slug'    => 'ui-kits',
                'status' => 1,
                'created_at' => '2018-01-30 16:30:45',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'    => 'Graphics',
                'slug'    => 'graphics',
                'status' => 1,
                'created_at' => '2018-01-30 16:30:45',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $categoriesTable = $this->table('categories');
        $categoriesTable->insert($categories)
            ->save();
    }
}
