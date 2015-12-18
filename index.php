<?php

use Phalcon\Mvc\Micro;
use Resapi\Common\Response\JSONResponse;
use Resapi\Common\Exception\HTTPException;

error_reporting(E_ALL);

define('APP_PATH', realpath('.'));

#try {

    /**
     * Read the configuration
     */
    $config = require APP_PATH . "/Config/config.php";

    /**
     * Include Autoloader
     */
    require APP_PATH . '/Config/loader.php';

    /**
     * Include Services
     */
    require APP_PATH . '/Config/services.php';

    /**
     * Include composer autoloader
     */
    require APP_PATH . "/vendor/autoload.php";

    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro();
    $app->setDI($di);
    
    /**
     * Mount all of the collections, which makes the routes active.
     */
    foreach($di->get('collections') as $collection){
        $app->mount($collection);
    }

    /**
     * The base route return the list of defined routes for the application.
     * This is not strictly REST compliant, but it helps to base API documentation off of.
     * By calling this, you can quickly see a list of all routes and their methods.
     */
    $app->get('/', function() use ($app){
        $routes = $app->getRouter()->getRoutes();
        $routeDefinitions = array('GET'=>array(), 'POST'=>array(), 'PUT'=>array(), 'PATCH'=>array(), 'DELETE'=>array(), 'HEAD'=>array(), 'OPTIONS'=>array());
        foreach($routes as $route){
            $method = $route->getHttpMethods();
            $routeDefinitions[$method][] = $route->getPattern();
        }
        return $routeDefinitions;
    });

    /**
     * Respond by default as JSON
     */
    $app->after(function () use ($app) {
        /// Results returned from the route's controller.  All Controllers should return an array
        $records = $app->getReturnedValue();
        $response = new JSONResponse();
        $response->useEnvelope(true) //this is default behavior
                 ->convertSnakeCase(true) //this is also default behavior
                 ->send($records);
    });

    $app->notFound(function () use ($app) {
        throw new HTTPException(
            'Not Found.',
            404,
            [
                'dev' => 'That route was not found on the server.',
                'internalCode' => 'NF1000',
                'more' => 'Check route for mispellings.'
            ]
        );
    });

    /**
     * Include Application
     */
    #require APP_PATH . '/Config/routes.php';

    /**
     * Handle the request
     */
    $app->handle();

#} catch (\Exception $e) {
#      echo $e->getMessage() . '<br>';
#      echo '<pre>' . $e->getTraceAsString() . '</pre>';
#}
