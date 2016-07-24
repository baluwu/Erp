<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;

include './defines.php';

$di = new FactoryDefault();

$di->set('router', function(){

	$router = new Router();

	$router->setDefaultModule("user");

	$router->add('/:module/:controller/:action/:params', array(
		'module' => 1,
		'controller' => 2,
        'action' => 3,
        'params' => 4
	));

    return $router;
});

$di->set('view', function() {
    $view = new View();
    #$view->setViewsDir('../apps/common/views/');
    return $view;
});

$application = new Application($di);

$application->registerModules(array(
	'user' => array(
		'className' => 'Erp\User\Module',
		'path' => './apps/modules/user/Module.php'
	),
	'goods' => array(
		'className' => 'Erp\Goods\Module',
		'path' => './apps/modules/goods/Module.php'
	)
));

echo $application->handle()->getContent();
