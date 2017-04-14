<?php
namespace app\common;

class Helper{

    public static function BuildOrderSn(){
        $code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        return $code[intval(date('Y')) - 2017]
        .date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

}