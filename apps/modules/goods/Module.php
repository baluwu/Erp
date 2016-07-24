<?php

namespace Erp\Goods;

class Module
{

	public function registerAutoloaders()
	{

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'Erp\Goods\Controllers' => './apps/modules/goods/controllers/',
            'Erp\Goods\Models' => './apps/modules/goods/models/'
        ));

		$loader->register();
	}

	/**
	 * Register the services here to make them module-specific
	 */
	public function registerServices($di)
	{

		//Registering a dispatcher
		$di->set('dispatcher', function() {
			$dispatcher = new \Phalcon\Mvc\Dispatcher();
			$dispatcher->setDefaultNamespace("Erp\Goods\Controllers\\");
			return $dispatcher;
		});

		//Set a different connection in each module
		$di->set('db', function() {
			return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
				"host" => "localhost",
				"username" => "root",
				"password" => "aaaaaa",
				"dbname" => "mysql"
			));
		});
	}
}
