<?php

use Phalcon\Config;
use Phalcon\Config\Adapter\Yaml;

defined('APP_PATH') || define('APP_PATH', realpath('.'));

$yaml = new Yaml(APP_PATH . "/phinx.yml");
$setup = [
    'database' => [
        'adapter'    => $yaml->environments->development->adapter,
        'host'       => $yaml->environments->development->host,
        'username'   => $yaml->environments->development->user,
        'password'   => $yaml->environments->development->pass,
        'dbname'     => $yaml->environments->development->name,
        'charset'    => $yaml->environments->development->charset,
    ],

    'application' => [
        'controllersDir' => APP_PATH . '/App/Controllers/',
        'modelsDir'      => APP_PATH . '/App/Models/',
        'commonDir'      => APP_PATH . '/Common/',
        'librariesDir'   => APP_PATH . '/Libraries/',
        'logsDir'        => APP_PATH . '/Logs/',
        'migrationsDir'  => APP_PATH . '/Database/migrations/',
        'development'    => [
            'staticBaseUri' => $yaml->appUri->development->staticBaseUri,
            'baseUri'       => $yaml->appUri->development->baseUri
        ],
        'production' => [
            'staticBaseUri' => $yaml->appUri->production->staticBaseUri,
            'baseUri'       => $yaml->appUri->production->baseUri
        ],
        'debug' => true
    ]
];

return new Config($setup);