<?php

use Phalcon\Loader;

$modelsDir      = $config->application->modelsDir;
$controllersDir = $config->application->controllersDir;
$libraryDir     = $config->application->librariesDir;
$commonDir 		= $config->application->commonDir;


$loader = new Loader();
/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(
    [
        'Resapi\Models'        => $modelsDir,
        'Resapi\Controllers'   => $controllersDir,
        'Resapi\Common'		   => $commonDir,
        'Resapi\Libs'          => $libraryDir
    ]
);
$loader->register();