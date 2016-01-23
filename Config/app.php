<?php


namespace Resapi\Config;

use Phalcon\Mvc\Micro;
use Resapi\Common\JSONResponse;
use Resapi\Common\HTTPException;

require __DIR__ . '/AppService.php';

class App extends Micro
{
    public function __construct()
    {
        $appService = new AppService();

        $di = $appService->getDependencyInjection();

        $this->setDI($di);

        foreach($di->get('collections') as $collection){
            $this->mount($collection);
        }
        $this->setRestRequest();
        $this->setDefaultResponseAsJSON();
        $this->setNotFoundResponse();
    }

    private function setRestRequest(){
        $this->get('/', function(){
            $routes = $this->getRouter()->getRoutes();
            $routeDefinitions = [
                'GET'   => [],
                'POST'  => [],
                'PUT'   => [],
                'DELETE'=> []
            ];

            foreach($routes as $route){
                $method = $route->getHttpMethods();
                $routeDefinitions[$method][] = $route->getPattern();
            }
            return $routeDefinitions;
        });
    }

    private function setDefaultResponseAsJSON(){
        $this->after(function() {
            /// Results returned from the route's controller.  All Controllers should return an array
            $records = $this->getReturnedValue();
            $response = new JSONResponse();
            $response->useEnvelope(true) //this is default behavior
            ->convertSnakeCase(true) //this is also default behavior
            ->send($records);
        });
    }

    private function setNotFoundResponse(){
        $this->notFound(function() {
            throw new HTTPException(
                'Not found', 404,
                [
                    'dev' => 'That route was not found on the server.',
                    'internalCode' => 'NF1000',
                    'more' => 'Check route for mispellings.'
                ]
            );
        });
    }
}