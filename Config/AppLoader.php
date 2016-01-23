<?php


namespace Resapi\Config;

use Phalcon\Loader;

require __DIR__ . '/AppConfig.php';

class AppLoader extends AppConfig
{
    private $loader;

    public function __construct()
    {
        parent::__construct();

        $this->loader = new Loader();
        $this->loader->registerNamespaces(
            [
                'Resapi\Models'        => $this->application->modelsDir,
                'Resapi\Controllers'   => $this->application->controllersDir,
                'Resapi\Config'        => $this->application->configDir,
                'Resapi\Route'         => $this->application->routeDir,
                'Resapi\Common'		   => $this->application->commonDir,
                'Resapi\Libs'          => $this->application->librariesDir
            ]
        );
        $this->loader->register();
    }

    public function getLoader(){
        return $this->loader;
    }
}