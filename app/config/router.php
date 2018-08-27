<?php
/*
 * Define custom routes. File gets included in the router service definition.
 */

$router = $di->getRouter();

$router->add('/vrdScoring',[
		'controller'=>'journals',
		'action'=>'search'
]);
$router->add('/vrdScores',[
	'controller'=>'journals',
		'action'=>'vrdScores'
]);
$router->handle();
