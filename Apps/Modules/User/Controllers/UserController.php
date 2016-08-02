<?php
namespace Erp\User\Controllers;

use Erp\User\Models as Meta;
use Erp\Common as Common;

class UserController extends \Phalcon\Mvc\Controller {
    public function addAction($user_id, $uname) {
        $r = (new Meta\User)->getList();

        foreach ($r as $v) {
           print_r($v);
        }
    }

    public function delAction() {
        (new Common\Database\Mysql)->connect();
    }
}
