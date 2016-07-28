<?php

namespace Erp\Common\Controller;

class ControllerBase extends Palcon\Mvc\Controller {

    /**
     * 发货JSON格式信息
     *
     * @param String $data 数据正文
     * @param String $code 状态码
     * @param String $msg 消息体
     * @return void
     */
    public function echoJson($data, $code = 200, $msg = '') {
        ob_clean();

        header('Content-type: application/json');

        echo json_encode([
            'succ' => $code === 200,
            'code' => $code,    
            'data' => $data,
            'msg' => $msg
        ]);

        exit;
    }
}
