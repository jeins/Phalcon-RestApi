<?php

use Resapi\Controller\ProductsController;
use Resapi\Controller\UsersController;

/**
 * Add your routes here
 */
$productsController = new ProductsController(true);
$usersController = new UsersController();

$app->get(
	'/api/products', 
	[$productsController, "get"]
);

$app->get(
	'/api/users',
	[$usersController, "getAllAction"]
);


