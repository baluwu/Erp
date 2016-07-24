<?php

namespace Erp\User;

class Module
{

	public function registerAutoloaders()
	{

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'Erp\User\Controllers' => './apps/modules/user/controllers/',
            'Erp\User\Models' => './apps/modules/user/models/',
            'Erp\Common' => './apps/common/',
            'Erp\Libs' => './apps/libs/',
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
			$dispatcher->setDefaultNamespace("Erp\User\Controllers\\");
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
