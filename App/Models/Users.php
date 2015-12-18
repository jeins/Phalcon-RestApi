<?php

namespace Resapi\Models;

use Phalcon\Mvc\Model;

class Users extends Model {

	public $id;

	public $fullname;

	public $email;

	public $password;

    public $tempPassword;

	public $created_at;

	public $modified_at;

	public function initialize() {
		$this->hashMany(
			'id',
			'Resapi\Models\Purchases',
			'users_id',
			[
				'alias'	=> 'purchases',
				'reusable' => true
			]
		);
	}

	public function beforeCreate() {
	    $this->created_at = date('Y-m-d H:i:s');
	    $this->updated_at = date('Y-m-d H:i:s');
	    $this->password = $this->getDI()->getSecurity()->hash($this->tempPassword);
	}


    public function afterDelete() {
        $this->clearCache();
    }
}