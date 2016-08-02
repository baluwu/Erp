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
        ));
        
        if (ENV === 'DEBUG') {
            /*监听加载事件*/
            $eventsManager = new \Phalcon\Events\Manager();
            $time = null;
            $eventsManager->attach('loader', function($event, $loader) use ($time) {
                if ($event->getType() == 'beforeCheckPath') {
                    $time = time();
                    echo 'Loading ' . $loader->getCheckedPath() . PHP_EOHL;
                }
            });
            $loader->setEventsManager($eventsManager);
        }

		$loader->register();
    }
    
    /**
     * 监视sql
     */
    function monSql($di, $conn) {
        if (ENV !== 'DEBUG') return ;

        $eventsManager = new \Phalcon\Events\Manager();

        $profiler = $di->getProfiler();

        $eventsManager->attach('db', function($event, $connection) use ($profiler, $di) {
            if ($event->getType() == 'beforeQuery') {
                $profiler->startProfile($connection->getSQLStatement());
            }
            if ($event->getType() == 'afterQuery') {
                $profiler->stopProfile();

                $profiles = $di->get('profiler')->getProfiles();
                
                $profiles = $di->get('profiler')->getProfiles();
                foreach ($profiles as $profile) {
                    echo date('Y-m-d H:i:s'), ": <B>SQL语句: ", $profile->getSQLStatement(), "</B>", PHP_EOHL;
                    echo date('Y-m-d H:i:s'), ": 消耗时间: ", round($profile->getTotalElapsedSeconds() * 1000, 2), 'ms!', PHP_EOHL;
                }
            }
        });

        $conn->setEventsManager($eventsManager);
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
                'metaDataDir' => ROOT_PATH . DS . 'Sess' . DS
            ));

            return $metaData;
        };

        $di->setShared('session', function() {
            $session = new Phalcon\Session\Adapter\Files();
            $session->start();
            return $session;
        });

        $dbConfig = include(CONF_PATH . 'Database.php');

        if (ENV === 'DEBUG') {
            $di->set('profiler', function() {
                return new \Phalcon\Db\Profiler();
            }, true);
        }

		$di->set('system', function($event, $connection) use ($di, $dbConfig)  {
            $conn = new \Phalcon\Db\Adapter\Pdo\Mysql($dbConfig['system']);
            $this->monSql($di, $conn);
            return $conn;
        });
        
        $bid = 1;//$di['session']->get('bid');
        
        if ($bid) {
            $dbSfx = $bid % 10;
            $dbName = 'biz' . $dbSfx;

            if (isset($dbConfig[$dbName])) {
                $di->set('biz', function() use ($dbConfig, $dbName, $di) {
                    $conn = new \Phalcon\Db\Adapter\Pdo\Mysql($dbConfig[$dbName]);
                    $this->monSql($di, $conn);
                    return $conn;
                });
            }
        }
    }
}
