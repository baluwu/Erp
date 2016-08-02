<?php

define('DS', DIRECTORY_SEPARATOR);
define('EXT', '.php');
define('PHP_EOHL', '<BR />');
define('ROOT_PATH', __DIR__);
define('CONF_PATH', __DIR__ . DS . 'Apps' . DS . 'Config' . DS);
define('COMMON_PATH', __DIR__ . DS . 'Apps' . DS . 'Common' . DS);
define('LOG_PATH', __DIR__ . DS . 'Logs' . DS);
define('ENV', 'DEBUG');

date_default_timezone_set('Asia/Shanghai');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ('DEBUG' === ENV) {
    function D() { var_dump(func_get_args()); exit; }
}

