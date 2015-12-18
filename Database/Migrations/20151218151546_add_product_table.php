<?php

use Phinx\Migration\AbstractMigration;

class AddProductTable extends AbstractMigration
{
    public function change()
    {
        // create the table
        $table = $this->table('products');
        $table->addColumn('name', 'string')
              ->addColumn('price', 'string')
              ->addColumn('description', 'string')
              ->addColumn('created_at', 'datetime')
              ->addColumn('modified_at', 'datetime')
              ->addIndex(['name'], array('unique' => true))
              ->create();
    }
}