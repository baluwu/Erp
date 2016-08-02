<?php

namespace Erp\Common\Model;

class BizModel extends BaseModel {
    public function initialize() {
        if ($this->di['biz']) {
            $this->setConnectionService('biz');
        }
    }
}
