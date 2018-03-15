<?php


use Phinx\Migration\AbstractMigration;

class InitialMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $usersTable = $this->table('users')
            ->addColumn('uuid', 'integer', ['limit' => 36])
            ->addColumn('first_name', 'string', ['limit' => 80, 'default' => null])
            ->addColumn('last_name', 'string', ['limit' => 80, 'default' => null])
            ->addColumn('email', 'string', ['limit' => 120])
            ->addColumn('password', 'string', ['limit' => 120, 'default' => null])
            ->addColumn('is_auto_signup', 'boolean', ['default' => 0])
            ->addColumn('created_at', 'datetime')
            ->addColumn('modified_at', 'datetime')
            ->addIndex('email', ['unique' => true, 'name' => 'iux_users_email'])
            ->create();

        $categoriesTable = $this->table('categories')
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('slug', 'string', ['limit' => 100])
            ->addColumn('created_at', 'datetime')
            ->addColumn('modified_at', 'datetime')
            ->addIndex('slug', ['unique' => true, 'name' => 'iux_category_slug'])
            ->create();

        $productTable = $this->table('products')
            ->addColumn('uuid', 'uuid')
            ->addColumn('title', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('thumb_image', 'string', ['default' => null])
            ->addColumn('main_image', 'string')
            ->addColumn('demo_url', 'string')
            ->addColumn('description', 'text')
            ->addColumn('price', 'decimal')
            ->addColumn('sales', 'integer', ['limit' => 5])
            ->addColumn('rating', 'decimal')
            ->addColumn('total_viewed', 'integer', ['limit' => 6])
            ->addColumn('total_downloaded', 'integer', ['limit' => 5, 'default' => 0])
            ->addColumn('download_path', 'string')
            ->addColumn('version', 'string', ['default' => '6'])
            ->addColumn('tags', 'string')
            ->addColumn('layout', 'char', ['default' => 'Responsive'])
            ->addColumn('product_type', 'char', ['default' => 'paid'])
            ->addColumn('key_features', 'string', ['default' => null])
            ->addColumn('browsers_compatible', 'string',  ['default' => null])
            ->addColumn('created_at', 'datetime')
            ->addColumn('modified_at', 'datetime')
            ->addColumn('is_featured', 'boolean', ['default' => 0])
            ->addIndex('slug', ['unique' =>  true, 'name' => 'idx_product_slug'])
            ->create();

        $productCategoriesTable = $this->table('products_categories')
            ->addColumn('product_id', 'integer')
            ->addColumn('category_id', 'integer')
            ->addIndex(['product_id', 'category_id'])
            ->addIndex('product_id')
            ->addIndex('category_id')
            ->addForeignKey(['product_id'], 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addForeignKey(['category_id'], 'categories', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
