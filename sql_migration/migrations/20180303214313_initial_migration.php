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
            ->addColumn('uuid', 'string', ['limit' => 36])
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
            ->addColumn('uuid', 'string')
            ->addColumn('title', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('category_id', 'integer')
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
            ->addForeignKey(['category_id'], 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->create();

        $orderTable = $this->table('orders')
            ->addColumn('order_id', 'integer', ['limit' => 8])
            ->addColumn('uuid', 'string')
            ->addColumn('user_id', 'integer')
            ->addColumn('amount', 'decimal')
            ->addColumn('created_at', 'datetime')
            ->addColumn('modified_at', 'datetime')
            ->addIndex('order_id', ['unique' => true, 'name' => 'iux_order_id'])
            ->addIndex('user_id', ['name' => 'iux_invoice_user_id'])
            ->addForeignKey(['user_id'], 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();

        $invoiceTable = $this->table('invoices')
            ->addColumn('uuid', 'string')
            ->addColumn('order_id', 'integer', ['limit' => 8])
            ->addColumn('user_id', 'integer')
            ->addColumn('subtotal', 'decimal')
            ->addColumn('vat', 'decimal')
            ->addColumn('tax', 'decimal')
            ->addColumn('discount', 'decimal')
            ->addColumn('total', 'decimal')
            ->addColumn('status', 'char', ['default' => 'unpaid'])
            ->addColumn('created_at', 'datetime')
            ->addColumn('modified_at', 'datetime')
            ->addIndex('order_id', ['name' => 'iux_invoice_order_id'])
            ->addIndex('user_id', ['name' => 'iux_invoice_user_id'])
            ->addForeignKey(['user_id'], 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addForeignKey(['order_id'], 'orders', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();

        $invoiceProductsTable = $this->table('invoice_products')
            ->addColumn('invoice_id', 'integer')
            ->addColumn('product_id', 'integer')
            ->addColumn('name', 'string')
            ->addColumn('unit_price', 'decimal')
            ->addColumn('quantity', 'integer')
            ->addColumn('subtotal', 'decimal')
            ->addColumn('created_at', 'datetime')
            ->addColumn('modified_at', 'datetime')
            ->addIndex('invoice_id', ['name' => 'iux_products_invoice_id'])
            ->addIndex('product_id', ['name' => 'iux_products_product_id'])
            ->addForeignKey(['invoice_id'], 'invoices', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addForeignKey(['product_id'], 'products', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->create();

        $downloadLinksTable = $this->table('download_links')
            ->addColumn('invoice_products', 'integer')
            ->addColumn('product_id', 'integer')
            ->addColumn('link', 'string')
            ->addColumn('download_completed', 'boolean', ['default' => 0])
            ->addColumn('expired_at', 'datetime')
            ->addColumn('created_at', 'datetime')
            ->addColumn('modified_at', 'datetime')
            ->addIndex('invoice_products', ['name' => 'iux_download_invoice_products_id'])
            ->addIndex('product_id', ['name' => 'iux_download_products_id'])
            ->addForeignKey(['invoice_products'], 'invoice_products', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addForeignKey(['product_id'], 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
