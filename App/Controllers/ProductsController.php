<?php

namespace Resapi\Controllers;

use Resapi\Models\Products;

class ProductsController extends RESTController
{
	public function get()
	{
		$data = Products::find()->toArray();
		return $this->respond($data);
	}
}