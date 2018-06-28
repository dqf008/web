<?php 
header('Content-type: text/json;charset=utf-8');
include_once '../include/config.php';
website_close();
website_deny();
include_once '../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../common/logintu.php';
include_once '../include/newpage.php';
include_once '../class/user.php';
include_once '../common/function.php';
$uid = $_SESSION['uid'];
$loginid = $_SESSION['user_login_id'];
renovate($uid, $loginid);

//未结算 单式
$params = array(':uid' => $uid);
$sql = 'select * from k_bet  where status=0 and uid=:uid  order by bid desc limit 10';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$i = 0;
$unsettled = $json['unsettled'];

while($rows = $stmt->fetch()){

	$ttt = "";
  	$rb = "";
  	$is = 'N';
	$tname = array("上半","下半","上半场","下半场","第1节","第2节","第3节","第4节","第一盘","第二盘","第三盘","第四盘","第五盘","让局","第一局","第二局","第三局","第四局","第五局","第六局","第七局","分数","局数");
	foreach($tname as $value){
	    if(strpos($rows["ball_sort"],$value)!== false || strpos($rows['master_guest'],$value)!== false){
	      $rows['bet_info'] = str_replace(' - ('.$value.')','',$rows['bet_info'] );
	      $rows['master_guest'] = str_replace(' - ('.$value.')','',$rows['master_guest'] );
	      $is = 'Y';
	      if($value == "上半" || $value == "下半"){
	        $value .= "场"; 
	      }
	      $ttt = " - ".$value;
	      
	    }
	}
  
    if(strpos($rows["ball_sort"],"滚球")!== false){
   	 	$rb = "(滚球) ";
    }

	$betinfo = explode('-',$rows['bet_info']);
	$g= explode('vs.',strtolower($rows['master_guest']));
	$unsettled[$i]['ticket_detail'][0]['home'] = $g[0];//主队
	$unsettled[$i]['ticket_detail'][0]['away'] = $g[1];//客队
	$unsettled[$i]['betstate'] = 'nomal';
	$unsettled[$i]['id'] = $rows["number"];//注单编号
	$unsettled[$i]['bet_time'] = $rows["bet_time"];//投注时间
	$unsettled[$i]['ticket_detail'][0]['game_time'] = $rows["match_endtime"];//开赛时间
	$unsettled[$i]['ticket_detail'][0]['league'] = $rows['match_name'];//联盟名称

	//过关中的
	/*
	$unsettled[$i]['ticket_detail'][$k]['wtype_detail'] = str_replace('单','单 / ',str_replace('大','大 / ',$betinfo[0]));
	$unsettled[$i]['ticket_detail'][$k]['vs_detail'] = '';
	$unsettled[$i]['ticket_detail'][$k]['resultdetail'] = 'X';
	$unsettled[$i]['ticket_detail'][$k]['betdetail'] = '';
	*/


	/*-------------------------------------------------------------------------------------------*/
	if(strpos($betinfo[0],'让球')!== false){
		$betinfo[0] = '让球';
		if(strpos($betinfo[1],'主让')!== false){
			$unsettled[$i]['ticket_detail'][0]['ratio_H'] = str_replace('主让','',$betinfo[1]);
			$unsettled[$i]['ticket_detail'][0]['ratio_A'] = '';
		}else{
			$unsettled[$i]['ticket_detail'][0]['ratio_H'] = '';
			$unsettled[$i]['ticket_detail'][0]['ratio_A'] = str_replace('客让','',$betinfo[1]);
		}

		$s = explode('@',$betinfo[2]);
		
		$unsettled[$i]['ticket_detail'][0]['betratio'] ='';
		$unsettled[$i]['ticket_detail'][0]['choose'] = $s[0];
		$unsettled[$i]['ticket_detail'][0]['ioratio'] = $s[1];
	}elseif(strpos($betinfo[0],'让盘')!== false){
		$betinfo[0] = '让盘';
		if(strpos($betinfo[1],'主让')!== false){
			$unsettled[$i]['ticket_detail'][0]['ratio_H'] = str_replace('主让','',$betinfo[1]);
			$unsettled[$i]['ticket_detail'][0]['ratio_A'] = '';
		}else{
			$unsettled[$i]['ticket_detail'][0]['ratio_H'] = '';
			$unsettled[$i]['ticket_detail'][0]['ratio_A'] = str_replace('客让','',$betinfo[1]);
		}

		$s = explode('@',$betinfo[2]);
		
		$unsettled[$i]['ticket_detail'][0]['betratio'] ='';
		$unsettled[$i]['ticket_detail'][0]['choose'] = $s[0];
		$unsettled[$i]['ticket_detail'][0]['ioratio'] = $s[1];
	}elseif(strpos($betinfo[0],'让分')!== false){
		if($is=='Y'){
			$betinfo[0] = '让分';
		}else{
			$betinfo[0] = '让局';
		}
		
		if(strpos($betinfo[1],'主让')!== false){
			$unsettled[$i]['ticket_detail'][0]['ratio_H'] = str_replace('主让','',$betinfo[1]);
			$unsettled[$i]['ticket_detail'][0]['ratio_A'] = '';
		}else{
			$unsettled[$i]['ticket_detail'][0]['ratio_H'] = '';
			$unsettled[$i]['ticket_detail'][0]['ratio_A'] = str_replace('客让','',$betinfo[1]);
		}

		$s = explode('@',$betinfo[2]);
		
		$unsettled[$i]['ticket_detail'][0]['betratio'] ='';
		$unsettled[$i]['ticket_detail'][0]['choose'] = $s[0];
		$unsettled[$i]['ticket_detail'][0]['ioratio'] = $s[1];
	}elseif(strpos($betinfo[0],'球队得分')!== false || strpos($betinfo[0],'球员局数')!== false || strpos($betinfo[0],'球员得分')!== false){
		//篮球的球队得分,网球的球员局数,羽毛球球员得分
		$unsettled[$i]['ticket_detail'][0]['ratio_H'] = '';
		$unsettled[$i]['ticket_detail'][0]['ratio_A'] ='';
		$betinfo[0] = $betinfo[0].'-'.$betinfo[1];

		$s = explode('@',$betinfo[2]);

		if(strpos($s[0],'O')!== false){
			$unsettled[$i]['ticket_detail'][0]['betratio'] = str_replace('O','',$s[0]);
			$unsettled[$i]['ticket_detail'][0]['choose'] = '大';
		}else{
			$unsettled[$i]['ticket_detail'][0]['betratio'] = str_replace('U','',$s[0]);
			$unsettled[$i]['ticket_detail'][0]['choose'] = '小';
		}
		
		$unsettled[$i]['ticket_detail'][0]['ioratio'] = $s[1];

	}else{
		$unsettled[$i]['ticket_detail'][0]['ratio_H'] = '';
		$unsettled[$i]['ticket_detail'][0]['ratio_A'] ='';
	
		$s = explode('@',$betinfo[1]);
		if(strpos($betinfo[0],'大小')!==false || strpos($betinfo[0],'大 / 小')!==false){
			if(strpos($s[0],'O')!== false){
				$unsettled[$i]['ticket_detail'][0]['betratio'] = str_replace('O','',$s[0]);
				$unsettled[$i]['ticket_detail'][0]['choose'] = '大';
			}else{
				$unsettled[$i]['ticket_detail'][0]['betratio'] = str_replace('U','',$s[0]);
				$unsettled[$i]['ticket_detail'][0]['choose'] = '小';
			}
		}elseif(strpos($betinfo[0],'波胆')!==false){
			$unsettled[$i]['ticket_detail'][0]['betratio'] ='';
			if(strpos($s[0],'UP')!==false){
				$unsettled[$i]['ticket_detail'][0]['choose'] = '其他比分';
			}else{
				$unsettled[$i]['ticket_detail'][0]['choose'] = $s[0];
			}
			
		}elseif(strpos($betinfo[0],'半全场')!==false){
			$unsettled[$i]['ticket_detail'][0]['betratio'] ='';
			$unsettled[$i]['ticket_detail'][0]['choose'] = str_replace('客',$g[1],str_replace('主',$g[0],$s[0]));
			
		}elseif(strpos($betinfo[0],'入球数')!==false){
			$unsettled[$i]['ticket_detail'][0]['betratio'] ='';
			if(strpos($s[0],'UP')!==false){
				$unsettled[$i]['ticket_detail'][0]['choose'] = str_replace('UP','或以上',$s[0]);
			}else{
				$unsettled[$i]['ticket_detail'][0]['choose'] = $s[0];
			}
			
		}else{
			$unsettled[$i]['ticket_detail'][0]['betratio'] ='';
			$unsettled[$i]['ticket_detail'][0]['choose'] = $s[0];
		}
		$unsettled[$i]['ticket_detail'][0]['ioratio'] = $s[1];
	}

	$unsettled[$i]['ticket_detail'][0]['score'] = $rows['match_nowscore'];//下注时候比分
	$unsettled[$i]['result'] = '';
	$unsettled[$i]['ticket_detail'][0]['org_score'] = '';
	$unsettled[$i]['ticket_detail'][0]['ms'] = '';
	$unsettled[$i]['ticket_detail'][0]['betdetail'] = '';

  	
	$unsettled[$i]['wtype'] = $rb.$betinfo[0].$ttt;;//类型
	$unsettled[$i]['stake'] = number_format($rows['bet_money'],2);//下注金额
	$unsettled[$i]['gold'] = number_format($rows['bet_win'],2);//可赢金额
	$unsettled[$i]['currency'] = 'RMB';
	$unsettled[$i]['vs'] = '';
	
	$unsettled[$i]['betinfo'] = '';
	$i++;
}
$json['unsettled'] = $unsettled;
echo json_encode($json);
?>