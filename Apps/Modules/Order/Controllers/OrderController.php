<?php
namespace Erp\Order\Controllers;

use Erp\Order\Models as Meta;
use Erp\Common as Common;

class OrderController extends Common\Controller\BaseController {
    public function getListAction($user_id, $uname) {
        $r = (new Meta\Order)->getList();

        foreach ($r as $v) {
           print_r($v);
        }
    }
}
