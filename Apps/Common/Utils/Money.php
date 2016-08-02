<?php

namespace Erp\Common\Utils;

class Money {
    public static function toYuan($num)
    {
        return number_format(round(num / 100, 2, PHP_ROUND_HALF_EVEN), 2, '.', '');
    }

    public static function rmDot($num)
    {
        return intval(number_format(round($num * 100, 0, PHP_ROUND_HALF_EVEN), 0, '.', ''));
    }

    public function addZero($num)
    {
        return number_format($num, 2, '.', '');
    }

    public function rmDecimalAndAddZero($num)
    {
        return number_format(intval(round($num / 100, 2, PHP_ROUND_HALF_EVEN)), 2, '.', '');
    }
}
