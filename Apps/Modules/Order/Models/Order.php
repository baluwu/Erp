<?php

namespace Erp\Order\Models;

use Erp\Common\Model\BizModel as BaseModel;

class Order extends BaseModel {
    public function getSource() { return 'order_10'; }
    public function getList() {
        return Order::find([
            'order_id>0',
            'columns' => '*',
            'limit' => [ 'number' => 2, 'offset' => 0 ]
        ])->toArray();
    }
}
