<?php

namespace Erp\Common\Queue;

/**
 * @file Mq.php
 * @author W.G
 * @description: 
 *  利用redis的zset来实现message queue,
 *  即实现一个键值唯一的,根据权重排序的队列
 * @date 2015-08-07
 */

class RedisMQ {
    public $mq;

    function __construct($addr, $port = 6379, $pwd = '', $db = 0, $timeout = 0) {
        $this->mq = new Redis();
        $this->mq->connect($addr, $port, $timeout);
        $this->mq->auth($pwd);
        $this->mq->select($db);
    }

    function __destruct() {
        $this->mq->close();
    }

    function _select_new_db($db) {
        if ($db != 0) {
            $this->mq->select($db);
        }
    }

    function _select_old_db($db) {
        if ($db != 0) {
            $this->mq->select(0);
        }
    }

    function size($name, $db = 0) {
        $this->_select_new_db($db);
        $r = $this->mq->zSize($name);
        $this->_select_old_db($db);

        return $r;
    }

    /**
     * 推送一个消息, 如果消息已经存在，则权重+1
     *
     * @param {String} $name 队列名称
     * @param {Fixed, String or Array} $val, 消息内容
     * @param {Integer} $weight 权值
     * @param {Integer} $db 数据仓库
     */
    function push($name, $val, $weight = 100, $db = 0) {
        $r = '';

        $this->_select_new_db($db);

        if (is_array($val)) {
            $fn_params[] = $name;

            foreach($val as $v) {
                $fn_params[] = $weight;
                $fn_params[] = $v;
            }

            $r = call_user_func_array(array($this->mq, 'zAdd'), $fn_params);       
        }
        else {
            $r = $this->mq->zAdd($name, $weight, $val);
        }
        
        $this->_select_old_db($db);

        return $r;
    }

    /**
     * 消息出队列
     *
     * @param {string} $name 队列名称
     * @param $db 
     */
    function pop($name, $db = 0) {
        $this->_select_new_db($db);

        $r = $this->mq->zRevRangeByScore(
            $name, 
            '+inf', 
            '-inf', 
            array(
                'withscores' => false, 
                'limit' => array(0, 1)
            )
        );

        if (is_array($r) && isset($r[0])) {
            $this->mq->zRem($name, $r[0]);
        }

        $this->_select_old_db($db);

        return $r[0];
    }

    /**
     * 获取满足条件的消息
     *
     * @param {String} $name 队列名称
     * @param {Integer} $db
     * @param {Integer} $maxv 最大值
     * @param {Integer} $minv 最小值
     * @param {Boolean} $with_weight 是否返回权值
     * @param {Integer} $offset 
     * @param {Integer} $page_size
     */
    function get(
        $name, 
        $db = 0,
        $maxv = '+inf', 
        $minv = '-inf', 
        $with_weight = false, 
        $offset = 0, 
        $page_size = 10) {
        
        $this->_select_new_db($db);
        
        $r = $this->mq->zRevRangeByScore(
            $name, 
            $maxv, 
            $minv, 
            array(
                'withscores' => $with_weight, 
                'limit' => array($offset, $page_size)
            )
        );

        $this->_select_old_db($db);

        return $r;
    }
    
    /**
     * 清空消息队列
     *
     * @param {String} 消息队列
     */
    function clear($name, $db = 0) {
        $this->_select_new_db($db);
        $r = $this->mq->zRemRangeByScore($name, '-inf', '+inf');
        $this->_select_old_db($db);

        return $r;
    }
}
