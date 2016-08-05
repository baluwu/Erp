<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Shanghai');

define('DS', DIRECTORY_SEPARATOR);
define('EXT', '.php');
define('PHP_EOHL', '<BR />');
define('ROOT_PATH', __DIR__ . DS);
define('APP_PATH', __DIR__ . DS . 'Apps' . DS);
define('CONF_PATH', APP_PATH . 'Config' . DS);
define('COMMON_PATH', APP_PATH . 'Common' . DS);
define('LOG_PATH', __DIR__ . DS . 'Logs' . DS);
define('ENV', 'DEBUG');

define('MON_SQL', TRUE); /*是否监视SQL*/
define('MON_LOAD', TRUE); /*是否监视加载*/
define('MON_PROF', TRUE); /*是否开启xhprof性能报告*/

if (MON_PROF) {
    xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
}

function D() { var_dump(func_get_args()); exit; }
function L($msg, $pfx = 'Temp') { 
    error_log(
        date('H:i:s ') . strval($msg) . PHP_EOL, 
        3, 
        LOG_PATH . $pfx . '_' . date('Y-m-d') . '.log'
    );
} 

