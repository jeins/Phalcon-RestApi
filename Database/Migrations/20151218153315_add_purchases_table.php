<?php

use Phinx\Migration\AbstractMigration;

class AddPurchasesTable extends AbstractMigration
{
    public function change()
    {
        // create the table
        $table = $this->table('purchases');
        $table->addColumn('users_id', 'integer')
              ->addForeignKey('users_id', 'users', 'id')
              ->addColumn('products_id', 'integer')
              ->addForeignKey('products_id', 'products', 'id')
              ->addColumn('amount', 'integer')
              ->addColumn('total_price', 'integer')
              ->addColumn('created_at', 'datetime')
              ->addColumn('modified_at', 'datetime')
              ->create();
    }
}