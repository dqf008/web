<?php
!defined('IN_LOT')&&die('Access Denied');
if(isset($LOT['input']['lotteryId'])){
    if(in_array($LOT['input']['lotteryId'], array_keys($LOT['game']))){
        $LOT['output']['Obj'] = array(); //主要输出内容
        $LOT['odds'] = include(IN_LOT.'include/odds/'.$LOT['input']['lotteryId'].'.php');
        include(IN_LOT.'include/ajax/info_'.$LOT['input']['lotteryId'].'.php');
    }
}
if(!empty($LOT['output'])){
    /* 按照需求输入额外内容 */
    $LOT['output']['Obj']['Balance'] = '0.00'; //会员余额
    $LOT['output']['ExtendObj'] = array(); //扩展输出内容
    $LOT['output']['ExtendObj']['IsLogin'] = false; //是否登陆
    $LOT['output']['OK'] = false;
    $LOT['output']['PageCount'] = 0;
    $LOT['output']['ErrorCode'] = 0; //888代表维护
    if($LOT['user']['login']){
        $LOT['output']['Obj']['Balance'] = sprintf('%.2f', $LOT['user']['money']);
        $LOT['output']['ExtendObj']['IsLogin'] = true;
        $LOT['output']['OK'] = true;
    }
}