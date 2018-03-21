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
            ->addColumn('uuid', 'string')
            ->addColumn('first_name', 'string', ['default' => null, 'null' => true])
            ->addColumn('last_name', 'string', ['default' => null, 'null' => true])
            ->addColumn('email', 'string')
            ->addColumn('password', 'string', ['default' => null, 'null' => true])
            ->addColumn('is_auto_signup', 'boolean', ['default' => 0, 'comment' => 'is_auto_signup: 0 = No, 1 = Yes'])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex('email', ['unique' => true, 'name' => 'iux_users_email'])
            ->create();

        $categoriesTable = $this->table('categories')
            ->addColumn('name', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('status', 'boolean', ['default' => 0, 'comment' => 'status: 0 = Inactive, 1 = Active'])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex('slug', ['unique' => true, 'name' => 'iux_category_slug'])
            ->create();

        $productTable = $this->table('products')
            ->addColumn('uuid', 'string')
            ->addColumn('user_id', 'integer', ['default' => null, 'null' => true])
            ->addColumn('title', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('category_id', 'integer')
            ->addColumn('thumb_image', 'string', ['default' => null, 'null' => true])
            ->addColumn('main_image', 'string')
            ->addColumn('demo_url', 'string')
            ->addColumn('description', 'text')
            ->addColumn('price', 'float')
            ->addColumn('sales', 'integer')
            ->addColumn('rating', 'float')
            ->addColumn('total_viewed', 'integer')
            ->addColumn('total_downloaded', 'integer', ['default' => 0])
            ->addColumn('download_path', 'string')
            ->addColumn('version', 'string', ['default' => '1.0.0'])
            ->addColumn('tags', 'string')
            ->addColumn('layout', 'char', ['default' => 'Responsive'])
            ->addColumn('product_type', 'char', ['default' => 'paid'])
            ->addColumn('key_features', 'string', ['default' => null])
            ->addColumn('browsers_compatible', 'string',  ['default' => null])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addColumn('is_featured', 'boolean', ['default' => 0])
            ->addIndex('slug', ['unique' =>  true, 'name' => 'idx_product_slug'])
            ->addForeignKey(['user_id'], 'users', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->addForeignKey(['category_id'], 'categories', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->create();

        $orderTable = $this->table('orders')
            ->addColumn('uuid', 'string')
            ->addColumn('user_id', 'integer')
            ->addColumn('fraud_check_status', 'string', ['default' => null, 'null' => true])
            ->addColumn('fraud_check_result', 'text', ['default' => null, 'null' => true])
            ->addColumn('ip_address', 'string', ['default' => null, 'null' => true, 'limit' => 40])
            ->addColumn('promo_code', 'string', ['default' => null, 'null' => true, 'limit' => 30])
            ->addColumn('amount', 'float', ['null' => false, 'default' => 0.00])
            ->addColumn('notes', 'text', ['default' => null, 'null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex('user_id', ['name' => 'iux_invoice_user_id'])
            ->addForeignKey(['user_id'], 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();

        $invoiceTable = $this->table('invoices')
            ->addColumn('uuid', 'string')
            ->addColumn('order_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('subtotal', 'float', ['default' => 0.00])
            ->addColumn('vat', 'float', ['default' => 0.00])
            ->addColumn('tax', 'float', ['default' => 0.00])
            ->addColumn('discount', 'float', ['default' => 0.00])
            ->addColumn('total', 'float', ['default' => 0.00])
            ->addColumn('invoice_date', 'datetime')
            ->addColumn('due_date', 'datetime')
            ->addColumn('status', 'enum', ['values' => ['paid', 'unpaid', 'invalid'], 'default' => 'unpaid'])
            ->addColumn('orderID', 'string', ['default' => null, 'null' => true])
            ->addColumn('payerID', 'string', ['default' => null, 'null' => true])
            ->addColumn('paymentID', 'string', ['default' => null, 'null' => true])
            ->addColumn('paymentToken', 'string', ['default' => null, 'null' => true])
            ->addColumn('payment_create_time', 'string', ['default' => null, 'null' => true])
            ->addColumn('full_response', 'text', ['default' => null, 'null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex('order_id', ['name' => 'iux_invoice_order_id'])
            ->addIndex('user_id', ['name' => 'iux_invoice_user_id'])
            ->addForeignKey(['user_id'], 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addForeignKey(['order_id'], 'orders', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();

        $invoiceProductsTable = $this->table('invoices_products')
            ->addColumn('uuid', 'string')
            ->addColumn('invoice_id', 'integer')
            ->addColumn('product_id', 'integer')
            ->addColumn('name', 'string')
            ->addColumn('file_path', 'string')
            ->addColumn('unit_price', 'float', ['default' => 0.00])
            ->addColumn('quantity', 'integer')
            ->addColumn('subtotal', 'float', ['default' => 0.00])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex('invoice_id', ['name' => 'iux_products_invoice_id'])
            ->addIndex('product_id', ['name' => 'iux_products_product_id'])
            ->addForeignKey(['invoice_id'], 'invoices', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addForeignKey(['product_id'], 'products', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->create();

        $downloadLinksTable = $this->table('download_links')
            ->addColumn('invoices_products_id', 'integer')
            ->addColumn('product_id', 'integer')
            ->addColumn('link', 'string')
            ->addColumn('token', 'string')
            ->addColumn('download_name', 'string')
            ->addColumn('download_completed', 'boolean', ['default' => 0])
            ->addColumn('expired_at', 'datetime')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->addIndex('invoices_products_id', ['name' => 'iux_download_invoices_products_id'])
            ->addIndex('product_id', ['name' => 'iux_download_products_id'])
            ->addForeignKey(['invoices_products_id'], 'invoices_products', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addForeignKey(['product_id'], 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
