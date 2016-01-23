<?php

use Phalcon\Mvc\Micro\Collection;

return call_user_func(function(){
	$productsCollection = new Collection();
	$productsCollection
		// VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
		->setPrefix('/v1')
		// Must be a string in order to support lazy loading
		->setHandler('\Resapi\Controllers\ProductsController')
		->setLazy(true);

	$productsCollection->get('/', 'get');
	return $productsCollection;
});

