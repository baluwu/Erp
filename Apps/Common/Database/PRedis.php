<?php

namespace Erp\Common\Database;

class PRedis {
    function __construct($addr, $port = 6379, $pwd = '', $timeout = 0, $db = 1) {
        $this->link = new Redis();
        $this->link->connect($addr, $port, $timeout);
        $this->link->auth($pwd);
        $this->link->select($db);
    }

    function __destruct() {
        $this->link->close();
    }

    function get_link() {
        return $this->link;
    }

    function select($db) {
        $this->link->select($db);
    }

    function set($key, $val, $ttl = 0) {
        if ($ttl == 0) {
            $this->link->set($key, $val);
        }
        else {
            $this->link->setex($key, $ttl, $val);
        }
    }

    function get($key) {
        return $this->link->get($key);
    }

    /**
     * @params $key string or array
     */
    function del($key) {
        return $this->link->delete($key);
    }
}
