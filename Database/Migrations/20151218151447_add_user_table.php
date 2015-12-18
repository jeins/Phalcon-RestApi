<?php

use Phinx\Migration\AbstractMigration;

class AddUserTable extends AbstractMigration
{
    public function change()
    {
        // create the table
        $table = $this->table('users');
        $table->addColumn('fullname', 'string')
              ->addColumn('email', 'string')
              ->addColumn('password', 'string')
              ->addColumn('created_at', 'datetime')
              ->addColumn('modified_at', 'datetime')
              ->addIndex(['email'], array('unique' => true))
              ->create();
    }
}