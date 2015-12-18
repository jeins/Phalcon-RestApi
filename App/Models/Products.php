<?php

namespace Resapi\Models;

use Phalcon\Mvc\Model;

class Products extends Model {
	
	public $id;

	public $name;

	public $price;

	public $description;

	public $created_at;

	public $modified_at;

	public function initialize() {
		$this->hashMany(
			'id',
			'Resapi\Models\Purchases',
			'products_id',
			[
				'alias'	=> 'sold',
				'reusable' => true
			]
		);
	}

	public function beforeCreate() {
	    $this->created_at = date('Y-m-d H:i:s');
	    $this->updated_at = date('Y-m-d H:i:s');
	}


    public function afterDelete() {
        $this->clearCache();
    }
}