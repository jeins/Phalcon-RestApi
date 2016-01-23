<?php


namespace Resapi\Config;


use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url;
use Phalcon\Db\Adapter\Pdo\Mysql as DatabaseConnection;
use Resapi\Route\RouteLoader;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;

require __DIR__ . '/AppLoader.php';

class AppService extends AppLoader
{
    private $di;

    public function __construct()
    {
        parent::__construct();

        $this->di = new FactoryDefault();
        $this->setRouteCollection();
        $this->di->setShared('url', $this->setUrl());
        $this->di->setShared('db', $this->setDB());
    }

    public function getDependencyInjection(){
        return $this->di;
    }

    private function setRouteCollection()
    {
        $this->di->set('collections', function () {
            return RouteLoader::callRouteCollections();
        });
    }

    private function setUrl()
    {
        $url = new Url();
        if(!$this->application->debug){
            $url->setBaseUri($this->application->production->baseUri);
            $url->setStaticBaseUri($this->application->production->staticBaseUri);
        } else {
            $url->setBaseUri($this->application->development->baseUri);
            $url->setStaticBaseUri($this->application->development->staticBaseUri);
        }
        return $url;
    }

    private function setDB()
    {
        $connection = new DatabaseConnection($this->database->toArray());
        $debug = $this->application->debug;
        if($debug){
            $eventsManager = new EventsManager();
            $logger = new FileLogger(__DIR__ . "/../Logs/db.log");

            //Listen all the database events
            $eventsManager->attach(
                'db',
                function($event, $connection) use($logger){
                    if($event->getType() == 'beforeQuery'){
                        $variables = $connection->getSQLVariables();
                        if ($variables) {
                            $logger->log($connection->getSQLStatement() . ' [' . join(',', $variables) . ']', \Phalcon\Logger::INFO);
                        } else {
                            $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
                        }
                    }
                }
            );
            $connection->setEventsManager($eventsManager);
        }

        return $connection;
    }
}