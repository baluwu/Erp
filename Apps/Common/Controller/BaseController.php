<?php

namespace Erp\Common\Controller;

class BaseController extends \Phalcon\Mvc\Controller {

    /**
     * 返回JSON格式信息
     *
     * @param String $data 数据正文
     * @param integer $code 状态码
     * @param String $msg 消息体
     * @return void
     */
    public function echoJson($data, $code = 200, $msg = '') {
        ob_clean();

        header('Content-type: application/json');
        http_response_code($code);

        echo json_encode([
            'succ' => $code === 200,
            'code' => $code,    
            'data' => $data,
            'msg' => $msg
        ]);

        exit;
    }

    /**
     * 返回JSONP格式信息
     *
     * @param String $data 数据正文
     * @param integer $code 状态码
     * @param String $msg 消息体
     * @return void
     */
    public function echoJsonp($data, $code = 200, $msg = '') {
        if (!isset($_GET['callback'])) { 
            return $this->echoJson($data, $code, $msg);
        }

        ob_clean();

        header('Content-type: application/json');
        http_response_code($code);

        echo trim($_GET['callback']) . '(' . json_encode([
            'succ' => $code === 200,
            'code' => $code,    
            'data' => $data,
            'msg' => $msg
        ]) . ')';

        exit;
    }
}
