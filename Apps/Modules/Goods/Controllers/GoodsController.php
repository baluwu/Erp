<?php
namespace Erp\Goods\Controllers;

use Erp\Goods\Models as Meta;

class GoodsController extends \Phalcon\Mvc\Controller {
    public function addAction() {
        $r = Meta\Goods::find();

        foreach ($r as $v) {
           echo $v->User . '-' .  $v->Host . '-' . $v->Password . '-' . $v->Select_priv . '<BR />';
        }
    }
}
