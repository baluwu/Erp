<?php

namespace Erp\Order;

class Module
{
	public function registerAutoloaders()
	{
		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'Erp\Order\Controllers' => './Apps/Modules/Order/Controllers/',
            'Erp\Order\Models' => './Apps/Modules/Order/Models/',
            'Erp\Common' => './Apps/Common/',
            'Erp\Libs' => './Apps/Libs/',
        ))->register();

        if (MON_LOAD) {
            \Erp\Common\Monitor\LoadMonitor::start($loader);
        }
    }
    
    /**
     * 监视sql
     */
    function monSql($di, $conn) {
    } 

	/**
	 * Register the services here to make them module-specific
	 */
	public function registerServices($di)
	{
		$di->set('dispatcher', function() {
			$dispatcher = new \Phalcon\Mvc\Dispatcher();
			$dispatcher->setDefaultNamespace("Erp\Order\Controllers\\");
			return $dispatcher;
        });

        $di['modelsMetadata'] = function() {
            $metaData = new \Phalcon\Mvc\Model\MetaData\Files(array(
                'metaDataDir' => ROOT_PATH . DS . 'Metadata' . DS
            ));

            return $metaData;
        };

        $di->setShared('session', function() {
            $session = new Phalcon\Session\Adapter\Files();
            $session->start();
            return $session;
        });

        $dbConfig = include(CONF_PATH . 'Database.php');

        if (MON_SQL) {
            \Erp\Common\Monitor\DBMonitor::init($di);
        }

		$di->set('system', function($event, $connection) use ($di, $dbConfig)  {
            $conn = new \Phalcon\Db\Adapter\Pdo\Mysql($dbConfig['system']);
            if (MON_SQL) \Erp\Common\Monitor\DBMonitor::start($di, $conn);
            return $conn;
        });
        
        $bid = 1;//$di['session']->get('bid');
        
        if ($bid) {
            $dbSfx = $bid % 10;
            $dbName = 'biz' . $dbSfx;

            if (isset($dbConfig[$dbName])) {
                $di->set('biz', function() use ($dbConfig, $dbName, $di) {
                    $conn = new \Phalcon\Db\Adapter\Pdo\Mysql($dbConfig[$dbName]);
                    if (MON_SQL) \Erp\Common\Monitor\DBMonitor::start($di, $conn);
                    return $conn;
                });
            }
        }
    }
}
