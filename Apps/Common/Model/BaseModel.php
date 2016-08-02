<?php

namespace Erp\Common\Model;

use Phalcon\Mvc\Model\Query;

class BaseModel extends \Phalcon\Mvc\Model {
    public function sysQuery($sql, array $param) {
        $this->setConnectionService('system');

        $query = new Query($sql, $this->di);
        return $query->execute($sql, $param)->toArray();
    }

    public function bizQuery($sql, array $param) {
        $this->setConnectionService('biz');

        $query = new Query($sql, $this->di);
        return $query->execute($sql, $param)->toArray();
    }
}
