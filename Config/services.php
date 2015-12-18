<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Di\FactoryDefault;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Db\Adapter\Pdo\Mysql as DatabaseConnection;
use Phalcon\Events\Manager as EventsManager;

$di = new FactoryDefault();

/**
 * Router
 */
$di->set('collections', function () {
    #return include APP_PATH . "/Config/routes.php";
    return include(APP_PATH . '/App/Routes/RouteLoader.php');
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () use ($config) {
    $url = new UrlResolver();
    if (!$config->application->debug) {
        $url->setBaseUri($config->application->production->baseUri);
        $url->setStaticBaseUri($config->application->production->staticBaseUri);
    } else {
        $url->setBaseUri($config->application->development->baseUri);
        $url->setStaticBaseUri($config->application->development->staticBaseUri);
    }
    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($config) {
    $connection = new DatabaseConnection($config->database->toArray());
    $debug = $config->application->debug;
    if ($debug) {
        $eventsManager = new EventsManager();
        $logger = new FileLogger(APP_PATH . "/Logs/db.log");
        //Listen all the database events
        $eventsManager->attach(
            'db',
            function ($event, $connection) use ($logger) {
                /** @var Phalcon\Events\Event $event */
                if ($event->getType() == 'beforeQuery') {
                    /** @var DatabaseConnection $connection */
                    $variables = $connection->getSQLVariables();
                    if ($variables) {
                        $logger->log($connection->getSQLStatement() . ' [' . join(',', $variables) . ']', \Phalcon\Logger::INFO);
                    } else {
                        $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
                    }
                }
            }
        );
        //Assign the eventsManager to the db adapter instance
        $connection->setEventsManager($eventsManager);
    }
    return $connection;
});