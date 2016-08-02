<?php

namespace Erp\Common\Model;

class SystemModel extends BaseModel {
    public function initialize() {
        $this->setConnectionService('system');
    }
}
