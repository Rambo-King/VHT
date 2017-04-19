<?php
namespace app\common;

use app\models\Waybill;

class Helper{

    public static function BuildOrderSn(){
        $code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        return $code[intval(date('Y')) - 2017]
        .date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    public static function BuildBillNumber($fix = 'ECCS', $sort = 10){
        $row = Waybill::find()->select('max(waybill_id) as num')->asArray()->one();
        $sort = is_null($row['num']) ? 0 : intval($row['num']);
        $fri = substr($fix, 2, 8);
        $fri+= ($sort - 1);
        $len = strlen($fri);
        if($len<8){
            for($j=$len; $j<8; $j++){
                $fri = "0".$fri;
            }
        }
        $num3=substr($fri,0,1);
        $num4=substr($fri,1,1);
        $num5=substr($fri,2,1);
        $num6=substr($fri,3,1);
        $num7=substr($fri,4,1);
        $num8=substr($fri,5,1);
        $num9=substr($fri,6,1);
        $num0=substr($fri,7,1);
        $mid=8*$num3+6*$num4+4*$num5+2*$num6+3*$num7+5*$num8+9*$num9+7*$num0;
        $res=11-($mid%11);
        if($res==10){ $res=0; }
        if($res==11){ $res=5; }
        return "EC".$fri.$res."CS";
    }

}