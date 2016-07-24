<?php

define(ROOT_PATH, __DIR__);
define(CONF_PATH, __DIR__ . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR);
define(LOG_PATH, __DIR__ . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR);
define(ENV, 'DEBUG');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ('DEBUG' === ENV) {
    function D() { var_dump(func_get_args()); exit; }
    function L($s) { error_log(date('Y-m-d H:i:s') . ' ' . $s, 3, LOG_PATH . 'log.log'); }
}
