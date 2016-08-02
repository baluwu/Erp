<?php

namespace Erp\Goods\Models;

class Goods extends \Phalcon\Mvc\Model {
    public $Host;
    public $User;
    public $Password;
    public $Select_priv;
    function getSource() {
        return 'user';
    }
}
