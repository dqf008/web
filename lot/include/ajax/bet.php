<?php
!defined('IN_LOT')&&die('Access Denied');
if(isset($LOT['input']['lotteryId'])){
    if(in_array($LOT['input']['lotteryId'], array_keys($LOT['game']))){
    	$session_name = 'bet_time_'.$LOT['input']['lotteryId'];
    	if(!empty($_SESSION[$session_name])){
			$diff = time() - $_SESSION[$session_name];
    		if($diff < 5){
    			die(json_encode(['result'=>0,'msg'=>'投注过于频繁，请稍后再试！']));
    		}
    	}
    	$_SESSION[$session_name] = time();
        $LOT['odds'] = include(IN_LOT.'include/odds/'.$LOT['input']['lotteryId'].'.php');
        include(IN_LOT.'include/ajax/bet_'.$LOT['input']['lotteryId'].'.php');
    }
}
