<?php


namespace Resapi\Config;

use Phalcon\Config;
use Phalcon\Config\Adapter\Yaml;

class AppConfig extends Config
{
    private $yaml;

    public function __construct()
    {
        $this->yaml = new Yaml(__DIR__ . '/../phinx.yml');
        parent::__construct(array_merge($this->setupDB(), $this->setupApplication()));
    }

    /**
     * @return array
     */
    private function setupDB()
    {
        return [
            'database' => [
                'adapter'    => $this->yaml->environments->development->adapter,
                'host'       => $this->yaml->environments->development->host,
                'username'   => $this->yaml->environments->development->user,
                'password'   => $this->yaml->environments->development->pass,
                'dbname'     => $this->yaml->environments->development->name,
                'charset'    => $this->yaml->environments->development->charset,
            ]
        ];
    }

    /**
     * @return array
     */
    private function setupApplication()
    {
        return [
            'application' => [
                'controllersDir' => __DIR__ . '/../App/Controllers/',
                'modelsDir'      => __DIR__ . '/../App/Models/',
                'configDir'      => __DIR__ . '/../App/Config',
                'routeDir'       => __DIR__ . '/../App/Routes',
                'commonDir'      => __DIR__ . '/../Common/',
                'librariesDir'   => __DIR__ . '/../Libraries/',
                'logsDir'        => __DIR__ . '/../Logs/',
                'migrationsDir'  => __DIR__ . '/../Database/migrations/',
                'development'    => [
                    'staticBaseUri' => $this->yaml->appUri->development->staticBaseUri,
                    'baseUri'       => $this->yaml->appUri->development->baseUri
                ],
                'production' => [
                    'staticBaseUri' => $this->yaml->appUri->production->staticBaseUri,
                    'baseUri'       => $this->yaml->appUri->production->baseUri
                ],
                'debug' => true
            ]
        ];
    }
}