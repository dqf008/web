<?php 
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-type: text/json;charset=utf-8');
include_once '../include/config.php';
website_close();
website_deny();
include_once '../cache/lqgq.php';
include_once '../include/pd_user_json.php';

if (3 < (time() - $lasttime)){
	if ($count == 0){
		$json['dh'] = 0;
		$json['fy']['p_page'] = '0';
 		echo $callback."(".json_encode($json).");";
 		exit();
	}else{
		include_once '../include/function_cj.php';
		if (lqgq_cj()){
			include '../cache/lqgq.php';
		}else{
			$json['dh'] = 0;
			$json['fy']['p_page'] = '0';
 			echo $callback."(".json_encode($json).");";
 			exit();
		}
	}
}

$ids = trim($_GET['ids']);

$bk = 400;
$this_page = 0;
if (0 < intval($_GET['CurrPage'])){
	$this_page = $_GET['CurrPage'];
}
$this_page++;
$start = ($this_page - 1) * $bk;
$end = ($this_page * $bk) - 1;
$match_names = array();
$info_array = array();



if (isset($lqgq) && !empty($lqgq)){
	$zqcount = count($lqgq);
	
	for ($i = 0;$i < $zqcount;$i++){
		$rows[] = $lqgq[$i];
		$match_names[] = $lqgq[$i]['Match_Name'];
	}
}

$match_name_array = array_values(array_unique($match_names));

$wap = $_GET['wap'];
if($wap == 'wap' and !empty($_GET['leaguename'])){ //手机端选择
    $nums_arr = count($rows);
    for ($i = 0;$i < $nums_arr;$i++){
        if ($rows[$i]['Match_Name']==$_GET['leaguename']){
            $info1[] = $rows[$i];
        }
    }
    $rows = $info1;
}else{
    $leaguename = rtrim(urldecode($_GET['leaguename']),',');

    $leaguenames = "";
    if ($leaguename != ''){
        $match_name = explode(',', $leaguename);
        $nums_arr = count($rows);
        
        for ($i = 0;$i < $nums_arr;$i++){
            if (in_array($rows[$i]['Match_Name'], $match_name)){
                $info1[] = $rows[$i];
            }
        }
        $rows = $info1;
    } 
}



$count_num = count($rows);
if ($count_num == '0'){
	$json['dh'] = 0;
	$json['fy']['p_page'] = 0;
}else{
	$json['fy']['p_page'] = ceil($count_num / $bk);
	$json['fy']['page'] = $this_page - 1;
	$i = 0;
	$lsm = '';
	foreach ($match_name_array as $t){
		$lsm .= urlencode($t) . '|';
		$i++;
	}
	$json['lsm'] = rtrim($lsm, '|');
	$json['dh'] = ceil($i / 3) * 30;
	if (($count_num - 1) < $end){
		$end = $count_num - 1;
	}
	$i = 0;
	
	$idds = "";
	for ($b = $start;$b <= $end;$b++){
		if($ids != ''){
			$idss = explode(',',$ids);

			if(in_array($rows[$b]['Match_ID'],$idss)){
                if($web_site['lqgq4']!=1||(substr_count($rows[$b]['Match_Master'], '第4节')<1&&strtoupper($rows[$b]['Match_NowSession'])!='Q4')){//禁止第4节
                    $json['db'][$i]['Match_ID'] = $rows[$b]['Match_ID'];
                    $json['db'][$i]['Match_Master'] = $rows[$b]['Match_Master'];
                    $json['db'][$i]['Match_Guest'] = $rows[$b]['Match_Guest'];
                    $json['db'][$i]['Match_MasterID'] = $rows[$b]['Match_MasterID'];
                    $json['db'][$i]['Match_GuestID'] = $rows[$b]['Match_GuestID'];

                    $json['db'][$i]['Match_Name'] = $rows[$b]['Match_Name'];
                    $json['db'][$i]['Match_Time'] = $rows[$b]['Match_Time'];
                    $json['db'][$i]['Match_IsMaster'] = $rows[$b]['Match_IsMaster'];
                    $dates = explode('<br>',$rows[$b]['Match_Date']);
                    $json['db'][$i]['Match_Date'] = $dates[0];
                    //独赢
                    $json['db'][$i]['Match_BzM'] = $rows[$b]['Match_BzM'];
                    $json['db'][$i]['Match_BzG'] = $rows[$b]['Match_BzG'];

                    //让分
                    $json['db'][$i]['Match_RGG'] = $rows[$b]['Match_RGG'];
                    $json['db'][$i]['Match_ShowType'] = $rows[$b]['Match_ShowType'];
                    $json['db'][$i]['Match_Ho'] = $rows[$b]['Match_Ho'];
                    $json['db'][$i]['Match_Ao'] = $rows[$b]['Match_Ao'];

                    //大小
                    $json['db'][$i]['Match_DxGG1'] = 'O' . $rows[$b]['Match_DxGG'];
                    $json['db'][$i]['Match_DxDpl'] = $rows[$b]['Match_DxDpl'];
                    $json['db'][$i]['Match_DxGG2'] = 'U' . $rows[$b]['Match_DxGG'];
                    $json['db'][$i]['Match_DxXpl'] = $rows[$b]['Match_DxXpl'];

                    //单双
                    $json['db'][$i]['Match_DsDpl'] = $rows[$b]['Match_DsDpl'];
                    $json['db'][$i]['Match_DsSpl'] = $rows[$b]['Match_DsSpl'];

                    //球队得分
                    $json['db'][$i]['Match_DFzDX1'] = 'O' . $rows[$b]['Match_DFzDX1'];
                    $json['db'][$i]['Match_DFzDpl'] = $rows[$b]['Match_DFzDpl'];
                    $json['db'][$i]['Match_DFzDX2'] = 'U' . $rows[$b]['Match_DFzDX2'];
                    $json['db'][$i]['Match_DFzXpl'] = $rows[$b]['Match_DFzXpl'];

                    $json['db'][$i]['Match_DFkDX1'] = 'O' . $rows[$b]['Match_DFkDX1'];
                    $json['db'][$i]['Match_DFkDpl'] = $rows[$b]['Match_DFkDpl'];
                    $json['db'][$i]['Match_DFkDX2'] = 'U' . $rows[$b]['Match_DFkDX2'];
                    $json['db'][$i]['Match_DFkXpl'] = $rows[$b]['Match_DFkXpl'];

                    //比分
                    $json['db'][$i]['Match_NowSession'] = $rows[$b]['Match_NowSession'];
                    $json['db'][$i]['Match_ScoreH'] = $rows[$b]['Match_ScoreH'];
                    $json['db'][$i]['Match_ScoreC'] = $rows[$b]['Match_ScoreC'];
                    $json['db'][$i]['Match_LastTime'] = $rows[$b]['Match_LastTime'];
                    $json['db'][$i]['Match_LastGoal'] = $rows[$b]['Match_LastGoal'];

                    $idds .= $rows[$b]['Match_ID'].',';
                    $i++;
                }
			}
		}else{
            if($web_site['lqgq4']!=1||(substr_count($rows[$b]['Match_Master'], '第4节')<1&&strtoupper($rows[$b]['Match_NowSession'])!='Q4')){//禁止第4节
                $json['db'][$i]['Match_ID'] = $rows[$b]['Match_ID'];
                $json['db'][$i]['Match_Master'] = $rows[$b]['Match_Master'];
                $json['db'][$i]['Match_Guest'] = $rows[$b]['Match_Guest'];
                $json['db'][$i]['Match_MasterID'] = $rows[$b]['Match_MasterID'];
                $json['db'][$i]['Match_GuestID'] = $rows[$b]['Match_GuestID'];

                $json['db'][$i]['Match_IsMaster'] = $rows[$b]['Match_IsMaster'];
                $json['db'][$i]['Match_Name'] = $rows[$b]['Match_Name'];
                $json['db'][$i]['Match_Time'] = $rows[$b]['Match_Time'];
                $dates = explode('<br>',$rows[$b]['Match_Date']);
                $json['db'][$i]['Match_Date'] = $dates[0];
                //独赢
                $json['db'][$i]['Match_BzM'] = $rows[$b]['Match_BzM'];
                $json['db'][$i]['Match_BzG'] = $rows[$b]['Match_BzG'];

                //让分
                $json['db'][$i]['Match_RGG'] = $rows[$b]['Match_RGG'];
                $json['db'][$i]['Match_ShowType'] = $rows[$b]['Match_ShowType'];
                $json['db'][$i]['Match_Ho'] = $rows[$b]['Match_Ho'];
                $json['db'][$i]['Match_Ao'] = $rows[$b]['Match_Ao'];

                //大小
                $json['db'][$i]['Match_DxGG1'] = 'O' . $rows[$b]['Match_DxGG'];
                $json['db'][$i]['Match_DxDpl'] = $rows[$b]['Match_DxDpl'];
                $json['db'][$i]['Match_DxGG2'] = 'U' . $rows[$b]['Match_DxGG'];
                $json['db'][$i]['Match_DxXpl'] = $rows[$b]['Match_DxXpl'];

                //单双
                $json['db'][$i]['Match_DsDpl'] = $rows[$b]['Match_DsDpl'];
                $json['db'][$i]['Match_DsSpl'] = $rows[$b]['Match_DsSpl'];

                //球队得分
                $json['db'][$i]['Match_DFzDX1'] = 'O' . $rows[$b]['Match_DFzDX1'];
                $json['db'][$i]['Match_DFzDpl'] = $rows[$b]['Match_DFzDpl'];
                $json['db'][$i]['Match_DFzDX2'] = 'U' . $rows[$b]['Match_DFzDX2'];
                $json['db'][$i]['Match_DFzXpl'] = $rows[$b]['Match_DFzXpl'];

                $json['db'][$i]['Match_DFkDX1'] = 'O' . $rows[$b]['Match_DFkDX1'];
                $json['db'][$i]['Match_DFkDpl'] = $rows[$b]['Match_DFkDpl'];
                $json['db'][$i]['Match_DFkDX2'] = 'U' . $rows[$b]['Match_DFkDX2'];
                $json['db'][$i]['Match_DFkXpl'] = $rows[$b]['Match_DFkXpl'];

                //比分
                $json['db'][$i]['Match_NowSession'] = $rows[$b]['Match_NowSession'];
                $json['db'][$i]['Match_ScoreH'] = $rows[$b]['Match_ScoreH'];
                $json['db'][$i]['Match_ScoreC'] = $rows[$b]['Match_ScoreC'];
                $json['db'][$i]['Match_LastTime'] = $rows[$b]['Match_LastTime'];
                $json['db'][$i]['Match_LastGoal'] = $rows[$b]['Match_LastGoal'];

                $idds .= $rows[$b]['Match_ID'].',';
                $i++;
            }
		}


	}

	$json['ids'] = rtrim($idds, ',');
}

echo $callback."(".json_encode($json).");";