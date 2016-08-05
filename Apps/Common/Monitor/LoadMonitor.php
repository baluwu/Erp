<?php

namespace Erp\Common\Monitor;

class LoadMonitor {
    static public function init($di) {}

    static public function start($loader) {

        /*监听加载事件*/
        $eventsManager = new \Phalcon\Events\Manager();
        
        $eventsManager->attach('loader', function($event, $loader) {
            if ($event->getType() == 'beforeCheckPath') {
                L('Loading ' . $loader->getCheckedPath(), 'MonLoad');
            }
        });

        $loader->setEventsManager($eventsManager);
    }
}
