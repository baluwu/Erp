<?php

namespace Erp\User\Models;

use Erp\Common\Model\SystemModel as BaseModel;

class User extends BaseModel {
    public function getSource() { return 'user'; }
    public function getList() {
        return User::find([
            'age>=30',
            'columns' => '*',
            'limit' => '0,100'   
        ])->toArray();
    }
}
