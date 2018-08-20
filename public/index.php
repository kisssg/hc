<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;

error_reporting ( E_ALL );

define ( 'BASE_PATH', dirname ( __DIR__ ) );
define ( 'APP_PATH', BASE_PATH . '/app' );

try {
	
	/**
	 * The FactoryDefault Dependency Injector automatically registers
	 * the services that provide a full stack framework.
	 */
	$di = new FactoryDefault ();
	
	$di->set ( 'dispatcher', function () {
		// Create an events manager
		$eventsManager = new EventsManager ();
		
		// Listen for events produced in the dispatcher using the SecurityPlugin
		$eventsManager->attach ( 'dispatch:beforeExecuteRoute', new SecurityPlugin () );
		
		// Handle exceptions and not-found exceptions using NotFoundPlugin
		$eventsManager->attach ( 'dispatch:beforeException', new NotFoundPlugin () );
		
		$dispatcher = new Dispatcher ();
		
		// Assign the events manager to the dispatcher
		$dispatcher->setEventsManager ( $eventsManager );
		
		return $dispatcher;
	} );
	
	/**
	 * Handle routes
	 */
	include APP_PATH . '/config/router.php';
	
	/**
	 * Read services
	 */
	include APP_PATH . '/config/services.php';
	
	/**
	 * Get config service for use in inline setup below
	 */
	$config = $di->getConfig ();
	
	/**
	 * Include Autoloader
	 */
	include APP_PATH . '/config/loader.php';
	
	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application ( $di );
	
	echo str_replace ( [ 
			"\n",
			"\r",
			"\t" 
	], '', $application->handle ()->getContent () );
} catch ( \Exception $e ) {
	echo $e->getMessage () . '<br>';
	echo '<pre>' . $e->getTraceAsString () . '</pre>';
}
