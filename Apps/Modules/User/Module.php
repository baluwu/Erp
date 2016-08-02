<?php

namespace Erp\User;

class Module
{

	public function registerAutoloaders()
	{

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'Erp\User\Controllers' => './Apps/Modules/User/Controllers/',
            'Erp\User\Models' => './Apps/Modules/User/Models/',
            'Erp\Common' => './Apps/Common/',
            'Erp\Libs' => './Apps/Libs/',
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

        $di->setShared('session', function() {
            $session = new Phalcon\Session\Adapter\Files();
            $session->start();
            return $session;
        });

        $dbConfig = include(CONF_PATH . 'Database.php');

		//Set a different connection in each module
		$di->set('system', function() use ($dbConfig)  {
			return new \Phalcon\Db\Adapter\Pdo\Mysql($dbConfig['system']);
        });
        
        $bid = 1;//$di['session']->get('bid');
        
        if ($bid) {
            $dbSfx = $bid % 10;
            if (isset($dbConfig[$dbSfx])) {
                $di->set('biz', function() use ($dbConfig, $dbSfx) {
                    return new \Phalcon\Db\Adapter\Pdo\Mysql($dbConfig['biz' . $dbSfx]);
                });
            }
        }
	}
}
