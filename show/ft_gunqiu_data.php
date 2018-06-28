<?php 
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-type: text/json;charset=utf-8');
include_once '../include/config.php';
website_close();
website_deny();
include_once '../cache/zqgq.php';
include_once '../include/pd_user_json.php';

if (3 < (time() - $lasttime)){
	if ($count == 0){
		$json['dh'] = 0;
		$json['fy']['p_page'] = '0';
 		echo $callback."(".json_encode($json).");";
		exit;
	}else{
		include_once '../include/function_cj.php';
		if (zqgq_cj()){
			include '../cache/zqgq.php';
		}else{
			$json['dh'] = 0;
			$json['fy']['p_page'] = '0';
 			echo $callback."(".json_encode($json).");";
			exit;
		}
	}
}

$ids = trim($_GET['ids']);

//联盟排序
/*if($_GET['sort'] == "C"){
	$esc = " match_name,Match_CoverDate,iPage,Match_Master,Match_ID,iSn";
}else{
	$esc = " Match_CoverDate,iPage,match_name,Match_Master,Match_ID,iSn";
}*/



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

//选择联盟
if (isset($zqgq) && !empty($zqgq)){
	$zqcount = count($zqgq);
	for ($i = 0;$i < $zqcount;$i++){
		$rows[] = $zqgq[$i];
		$match_names[] = $zqgq[$i]['Match_Name'];

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
	$json['ids'] = "";
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
				$json['db'][$i]['Match_ID'] = $rows[$b]['Match_ID'];
				$json['db'][$i]['Match_Master'] = $rows[$b]['Match_Master'];
				$json['db'][$i]['Match_Guest'] = $rows[$b]['Match_Guest'];
				$json['db'][$i]['Match_Name'] = $rows[$b]['Match_Name'];
				$json['db'][$i]['Match_CoverDate'] = $rows[$b]['Match_CoverDate'];
				$da = explode('<br>',$rows[$b]['Match_Date']);
				$json['db'][$i]['Match_Date'] = $da[0];
				$json['db'][$i]['Match_retimeset'] = $rows[$b]['Match_retimeset'];
				$json['db'][$i]['Match_Time'] = $rows[$b]['Match_Time'];
				$json['db'][$i]['Match_lastestscore_h'] = $rows[$b]['Match_lastestscore_h'];
				$json['db'][$i]['Match_lastestscore_c'] = $rows[$b]['Match_lastestscore_c'];
				$json['db'][$i]['Match_Ho'] = NOnull($rows[$b]['Match_Ho']);
				$json['db'][$i]['Match_DxDpl'] = NOnull($rows[$b]['Match_DxDpl']);
				$json['db'][$i]['Match_BHo'] = NOnull($rows[$b]['Match_BHo']);
				$json['db'][$i]['Match_Bdpl'] = NOnull($rows[$b]['Match_Bdpl']);
				$json['db'][$i]['Match_Ao'] = NOnull($rows[$b]['Match_Ao']);
				$json['db'][$i]['Match_DxXpl'] = NOnull($rows[$b]['Match_DxXpl']);
				$json['db'][$i]['Match_DsDpl'] = NOnull($rows[$b]['Match_DsDpl']);
				$json['db'][$i]['Match_DsSpl'] = NOnull($rows[$b]['Match_DsSpl']);
				$json['db'][$i]['Match_BAo'] = NOnull($rows[$b]['Match_BAo']);
				$json['db'][$i]['Match_Bxpl'] = NOnull($rows[$b]['Match_Bxpl']);
				$json['db'][$i]['Match_RGG'] = $rows[$b]['Match_RGG'];
				$json['db'][$i]['Match_BRpk'] = $rows[$b]['Match_BRpk'];
				$json['db'][$i]['Match_ShowType'] = $rows[$b]['Match_ShowType'];
				$json['db'][$i]['Match_Hr_ShowType'] = $rows[$b]['Match_Hr_ShowType'];
				$json['db'][$i]['Match_DxGG'] = 'O' . $rows[$b]['Match_DxGG'];
				$json['db'][$i]['Match_Bdxpk'] = 'O' . $rows[$b]['Match_Bdxpk'];
				$json['db'][$i]['Match_DxGG1'] = 'U' . $rows[$b]['Match_DxGG'];
				$json['db'][$i]['Match_Bdxpk2'] = 'U' . $rows[$b]['Match_Bdxpk'];
				$json['db'][$i]['Match_redcard_h'] = NOkong($rows[$b]['Match_redcard_h']);
				$json['db'][$i]['Match_redcard_c'] = NOkong($rows[$b]['Match_redcard_c']);
				$json['db'][$i]['Match_score_h'] = NOkong($rows[$b]['Match_score_h']);
				$json['db'][$i]['Match_score_c'] = NOkong($rows[$b]['Match_score_c']);
				$json['db'][$i]['Match_BzM'] = NOkong($rows[$b]['Match_BzM']);
				$json['db'][$i]['Match_BzG'] = NOkong($rows[$b]['Match_BzG']);
				$json['db'][$i]['Match_BzH'] = NOkong($rows[$b]['Match_BzH']);
				$json['db'][$i]['Match_Bmdy'] = NOkong($rows[$b]['Match_Bmdy']);
				$json['db'][$i]['Match_Bgdy'] = NOkong($rows[$b]['Match_Bgdy']);
				$json['db'][$i]['Match_Bhdy'] = NOkong($rows[$b]['Match_Bhdy']);
				$idds .= $rows[$b]['Match_ID'].',';
				$i++;
			}
		}else{
			$json['db'][$i]['Match_ID'] = $rows[$b]['Match_ID'];
			$json['db'][$i]['Match_Master'] = $rows[$b]['Match_Master'];
			$json['db'][$i]['Match_Guest'] = $rows[$b]['Match_Guest'];
			$json['db'][$i]['Match_Name'] = $rows[$b]['Match_Name'];
			$json['db'][$i]['Match_CoverDate'] = $rows[$b]['Match_CoverDate'];
			$da = explode('<br>',$rows[$b]['Match_Date']);
			$json['db'][$i]['Match_Date'] = $da[0];
			$json['db'][$i]['Match_retimeset'] = $rows[$b]['Match_retimeset'];
			$json['db'][$i]['Match_Time'] = $rows[$b]['Match_Time'];
			$json['db'][$i]['Match_lastestscore_h'] = $rows[$b]['Match_lastestscore_h'];
			$json['db'][$i]['Match_lastestscore_c'] = $rows[$b]['Match_lastestscore_c'];
			$json['db'][$i]['Match_Ho'] = NOnull($rows[$b]['Match_Ho']);
			$json['db'][$i]['Match_DxDpl'] = NOnull($rows[$b]['Match_DxDpl']);
			$json['db'][$i]['Match_BHo'] = NOnull($rows[$b]['Match_BHo']);
			$json['db'][$i]['Match_Bdpl'] = NOnull($rows[$b]['Match_Bdpl']);
			$json['db'][$i]['Match_Ao'] = NOnull($rows[$b]['Match_Ao']);
			$json['db'][$i]['Match_DxXpl'] = NOnull($rows[$b]['Match_DxXpl']);
			$json['db'][$i]['Match_DsDpl'] = NOnull($rows[$b]['Match_DsDpl']);
			$json['db'][$i]['Match_DsSpl'] = NOnull($rows[$b]['Match_DsSpl']);
			$json['db'][$i]['Match_BAo'] = NOnull($rows[$b]['Match_BAo']);
			$json['db'][$i]['Match_Bxpl'] = NOnull($rows[$b]['Match_Bxpl']);
			$json['db'][$i]['Match_RGG'] = $rows[$b]['Match_RGG'];
			$json['db'][$i]['Match_BRpk'] = $rows[$b]['Match_BRpk'];
			$json['db'][$i]['Match_ShowType'] = $rows[$b]['Match_ShowType'];
			$json['db'][$i]['Match_Hr_ShowType'] = $rows[$b]['Match_Hr_ShowType'];
			$json['db'][$i]['Match_DxGG'] = 'O' . $rows[$b]['Match_DxGG'];
			$json['db'][$i]['Match_Bdxpk'] = 'O' . $rows[$b]['Match_Bdxpk'];
			$json['db'][$i]['Match_DxGG1'] = 'U' . $rows[$b]['Match_DxGG'];
			$json['db'][$i]['Match_Bdxpk2'] = 'U' . $rows[$b]['Match_Bdxpk'];
			$json['db'][$i]['Match_redcard_h'] = NOkong($rows[$b]['Match_redcard_h']);
			$json['db'][$i]['Match_redcard_c'] = NOkong($rows[$b]['Match_redcard_c']);
			$json['db'][$i]['Match_score_h'] = NOkong($rows[$b]['Match_score_h']);
			$json['db'][$i]['Match_score_c'] = NOkong($rows[$b]['Match_score_c']);
			$json['db'][$i]['Match_BzM'] = NOkong($rows[$b]['Match_BzM']);
			$json['db'][$i]['Match_BzG'] = NOkong($rows[$b]['Match_BzG']);
			$json['db'][$i]['Match_BzH'] = NOkong($rows[$b]['Match_BzH']);
			$json['db'][$i]['Match_Bmdy'] = NOkong($rows[$b]['Match_Bmdy']);
			$json['db'][$i]['Match_Bgdy'] = NOkong($rows[$b]['Match_Bgdy']);
			$json['db'][$i]['Match_Bhdy'] = NOkong($rows[$b]['Match_Bhdy']);
			$idds .= $rows[$b]['Match_ID'].',';
			$i++;
		}
		
		
	}

	$json['ids'] = rtrim($idds, ',');
}


echo $callback."(".json_encode($json).");"; 


function NOnull($str){
	return 0 < $str ? sprintf('%.2f', $str) : 0;
}

function NOkong($str2){
	return $str2 != '' ? $str2 : 0;
}
?>