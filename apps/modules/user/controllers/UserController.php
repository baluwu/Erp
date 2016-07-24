<?php
namespace Erp\User\Controllers;

use Erp\User\Models as Meta;
use Erp\Common as Common;

class UserController extends \Phalcon\Mvc\Controller {
    public function addAction($user_id, $uname) {
        $r = Meta\User::find();

        foreach ($r as $v) {
           echo $v->User . '-' .  $v->Host . '-' . $v->Password . '-' . $v->Select_priv . '<BR />';
        }
    }

    public function delAction() {
        (new Common\Database\Mysql)->connect();
    }
}
