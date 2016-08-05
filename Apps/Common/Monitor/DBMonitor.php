<?php

namespace Erp\Common\Monitor;

class DBMonitor {
    static public function init($di) {
        $di->set('profiler', function() {
            return new \Phalcon\Db\Profiler();
        }, true);
    }

    static public function start($di, $conn) {

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
                    L('SQL: ' . $profile->getSQLStatement(), 'MonSql');
                    L('Use: ' . round($profile->getTotalElapsedSeconds() * 1000, 2) . 'MS!', 'MonSql');
                }
            }
        });

        $conn->setEventsManager($eventsManager);
    }
}
