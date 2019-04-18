<?php
use Phalcon\Loader;

$loader = new Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs ( [ 
		$config->application->controllersDir,
		$config->application->modelsDir,
		$config->application->pluginsDir, 
		$config->application->libraryDir,

] )->register ();

// Use composer autoloader to load vendor classes
require_once APP_PATH . '/vendor/autoload.php';
