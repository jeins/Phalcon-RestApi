<?php

namespace Resapi\Models;

use Phalcon\Mvc\Model;

class Purchases extends Model {
	
	public $id;

	public $users_id;

	public $products_id;

	public $amount;

	public $total_price;

	public $created_at;

	public $modified_at;

	public function initialize() {
		$this->belongsTo(
            'users_id',
            'Resapi\Models\Users',
            'id',
            [
                'alias'    => 'user',
                'reusable' => true
            ]
        );

        $this->belongsTo(
            'products_id',
            'Resapi\Models\Products',
            'id',
            [
                'alias'    => 'product',
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