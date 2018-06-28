<?php 
function double_format($double_num){
	return 0 < $double_num ? sprintf('%.2f', $double_num) : $double_num < 0 ? sprintf('%.2f', $double_num) : 0;
}

function cutString($title, $length = 38, $bool = 0){
	$tmpstr = '';
	if (strlen($title) <= $length){
		return $title;
	}else{
		
		for ($i = 0;$i < $length;$i++){
			if (160 < ord(substr($title, $i, 1))){
				$tmpstr .= substr($title, $i, 2);
				$i++;
			}else{
				$tmpstr .= substr($title, $i, 1);
			}
		}
		
		if ($bool){
			return $tmpstr . '..';
		}else{
			return $tmpstr;
		}
	}
}
function htmlEncode($string){
	$string = trim(strip_tags($string));
	return $string;
}

function message($value, $url = '')
{
	header('Content-type: text/html;charset=utf-8');
	$js = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html xmlns="http://www.w3.org/1999/xhtml"> <head> <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> <title>message</title> </head> <body>';
	$js .= '<script type="text/javascript" language="javascript">';
	$js .= 'alert("' . $value . '");';
	if ($url)
	{
		$js .= 'window.location.href="' . $url . '";';
	}
	else
	{
		$js .= 'window.history.go(-1);';
	}
	$js .= '</script>';
	$js .= '</body></html>';
    echo $js;
	exit();
}

function write_bet_info($ball_sort, $column, $master_guest, $bet_point, $match_showtype, $match_rgg, $match_dxgg, $match_nowscore, $tid = 0){
	$dm = explode('VS.', $master_guest);
	$qcrq = array('Match_Ho', 'Match_Ao');
	$qcdx = array('Match_DxDpl', 'Match_DxXpl');
	$ds = array('Match_DsDpl', 'Match_DsSpl');
	$info = '';
	if (strrpos($ball_sort, '足球') === 0){
		$bcrq = array('Match_BHo', 'Match_BAo');
		$bcdx = array('Match_Bdpl', 'Match_Bxpl');
		$qcdy = array('Match_BzM', 'Match_BzG', 'Match_BzH');
		$bcdy = array('Match_Bmdy', 'Match_Bgdy', 'Match_Bhdy');
		$sbbdz = array('Match_Hr_Bd10', 'Match_Hr_Bd20', 'Match_Hr_Bd21', 'Match_Hr_Bd30', 'Match_Hr_Bd31', 'Match_Hr_Bd32', 'Match_Hr_Bd40', 'Match_Hr_Bd41', 'Match_Hr_Bd42', 'Match_Hr_Bd43');
		$sbbdk = array('Match_Hr_Bdg10', 'Match_Hr_Bdg20', 'Match_Hr_Bdg21', 'Match_Hr_Bdg30', 'Match_Hr_Bdg31', 'Match_Hr_Bdg32', 'Match_Hr_Bdg40', 'Match_Hr_Bdg41', 'Match_Hr_Bdg42', 'Match_Hr_Bdg43');
		$sbbdp = array('Match_Hr_Bd00', 'Match_Hr_Bd11', 'Match_Hr_Bd22', 'Match_Hr_Bd33', 'Match_Hr_Bd44', 'Match_Hr_Bdup5');
		$bdz = array('Match_Bd10', 'Match_Bd20', 'Match_Bd21', 'Match_Bd30', 'Match_Bd31', 'Match_Bd32', 'Match_Bd40', 'Match_Bd41', 'Match_Bd42', 'Match_Bd43');
		$bdk = array('Match_Bdg10', 'Match_Bdg20', 'Match_Bdg21', 'Match_Bdg30', 'Match_Bdg31', 'Match_Bdg32', 'Match_Bdg40', 'Match_Bdg41', 'Match_Bdg42', 'Match_Bdg43');
		$bdp = array('Match_Bd00', 'Match_Bd11', 'Match_Bd22', 'Match_Bd33', 'Match_Bd44', 'Match_Bdup5');
		$rqs = array('Match_Total01Pl', 'Match_Total23Pl', 'Match_Total46Pl', 'Match_Total7upPl');
		$sbrqs = array('Match_Total0Pl', 'Match_Total1Pl', 'Match_Total2Pl', 'Match_Total3upPl');
		$bqc = array('Match_BqMM', 'Match_BqMH', 'Match_BqMG', 'Match_BqHM', 'Match_BqHH', 'Match_BqHG', 'Match_BqGM', 'Match_BqGH', 'Match_BqGG');
		if (in_array($column, $qcrq) || in_array($column, $bcrq)){

			$info .= '让球-';
			
			if ($match_showtype == 'H'){
				$info .= '主让' . $match_rgg . '-';
			}else{
				$info .= '客让' . $match_rgg . '-';
			}
			
			if (($column == 'Match_Ho') || ($column == 'Match_BHo')){
				$info .= $dm[0];
			}else{
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdx) || in_array($column, $bcdx)){
			$info .= '大小-';
			if (in_array($column, $qcdx)){
				if ($column == 'Match_DxDpl')
				{
					$info .= 'O';
				}
				else
				{
					$info .= 'U';
				}
			}else{
				
				if ($column == 'Match_Bdpl'){
					$info .= 'O';
				}else{
					$info .= 'U';
				}
			}
			$info .= $match_dxgg;
		}else if (in_array($column, $qcdy) || in_array($column, $bcdy)){
			$info .= '独赢-';
			
			if (($column == 'Match_BzM') || ($column == 'Match_Bmdy')){
				$info .= $dm[0];
			}else if (($column == 'Match_BzG') || ($column == 'Match_Bgdy')){
				$info .= $dm[1];
			}else{
				$info .= '和局';
			}
		}else if (in_array($column, $ds)){
			$info .= '单双-';
			if ($column == 'Match_DsDpl'){
				$info .= '单';
			}else{
				$info .= '双';
			}
		}else if (in_array($column, $sbbdz) || in_array($column, $sbbdk) || in_array($column, $sbbdp) || in_array($column, $bdz) || in_array($column, $bdk) || in_array($column, $bdp)){
			if (in_array($column, $sbbdz) || in_array($column, $sbbdk) || in_array($column, $sbbdp)){
				$info .= '波胆-';
			}else{
				$info .= '波胆-';
			}
			
			if (strrpos($column, 'up5')){
				$info .= 'UP5';
			}elseif (strrpos($column, 'up3')){
				$info .= 'UP3';
			}else{
				$z = substr($column, -2, 1);
				$k = substr($column, -1, 1);
				if (in_array($column, $sbbdz) || in_array($column, $bdz)){
					$info .= $z . ':' . $k;
				}else{
					$info .= $k . ':' . $z;
				}
			}
		}else if (in_array($column, $rqs)){//入球数
			$info .= '入球数-';
			if (strrpos($column, '7up')){
				$info .= '7UP';
			}else{
				$info .= substr($column, -4, 1) . '~' . substr($column, -3, 1);
			}
		}else if (in_array($column, $sbrqs)){//上半场入球数
			$info .= '入球数-';
			if (strrpos($column, '3up')){
				$info .= '3UP';
			}else{
				$info .= substr($column, -3, 1);
			}
		}else if (in_array($column, $bqc)){
			$info .= '半全场-';
			$n1 = '' . substr($column, -2, 1);
			$n2 = '' . substr($column, -1, 1);
			$n1 = ($n1 === 'H' ? '和' : ($n1 === 'M' ? '主' : '客'));
			$n2 = ($n2 === 'H' ? '和' : ($n2 === 'M' ? '主' : '客'));
			$info .= $n1 . '/' . $n2;
		}
		
		$info .= '@' . $bet_point;
	}else if (strrpos($ball_sort, '篮球') === 0){
		$qddfdx = array('Match_DFkDpl','Match_DFkXpl','Match_DFzDpl','Match_DFzXpl');//球队得分:大小
		$qcdy = array('Match_BzM', 'Match_BzG');//独赢

		if (in_array($column, $qcrq)){//让球
			$info .= '让球-';
			
			if ($match_showtype == 'H'){
				$info .= '主让' . $match_rgg . '-';
			}else{
				$info .= '客让' . $match_rgg . '-';
			}
			
			if ($column == 'Match_Ho'){
				$info .= $dm[0];
			}else{
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdy)){//独赢
			
			$info .= '独赢-';

			if ($column == 'Match_BzM'){
				$info .= $dm[0];
			}else if ($column == 'Match_BzG'){
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdx)){//大小
			$info .= '总分:大小-';
			if ($column == 'Match_DxDpl'){
				$info .= 'O' . $match_dxgg;
			}else{
				$info .= 'U' . $match_dxgg;
			}
		}else if (in_array($column, $ds)){//单双
			$info .= '总分:单双-';
			if ($column == 'Match_DsDpl'){
				$info .= '单';
			}else{
				$info .= '双';
			}
		}else if (in_array($column, $qddfdx )){//球队得分:大小
			$info .= '球队得分:';
			switch ($column) {
				case 'Match_DFzDpl'://主队得分 大
					$info .= $dm[0].'-大 / 小-';
					$info .= 'O' . $match_dxgg;
					break;
				case 'Match_DFzXpl'://主队得分 小
					$info .= $dm[0].'-大 / 小-';
					$info .= 'U' . $match_dxgg;
					break;
				case 'Match_DFkDpl'://客队得分 大
					$info .= $dm[1].'-大 / 小-';
					$info .= 'O' . $match_dxgg;
					break;
				case 'Match_DFkXpl'://客队得分 小
					$info .= $dm[1].'-大 / 小-';
					$info .= 'U' . $match_dxgg;
					break;
			}
		}
		$info .= '@' . $bet_point;
	}else if(strrpos($ball_sort, '网球') === 0){//网球
		$qddfdx = array('Match_DFkDpl','Match_DFkXpl','Match_DFzDpl','Match_DFzXpl');//球队得分:大小
		$qcdy = array('Match_BzM', 'Match_BzG');//独赢

		if (in_array($column, $qcrq)){//让球
			$info .= '让盘-';
			
			if ($match_showtype == 'H'){
				$info .= '主让' . $match_rgg . '-';
			}else{
				$info .= '客让' . $match_rgg . '-';
			}
			
			if ($column == 'Match_Ho'){
				$info .= $dm[0];
			}else{
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdy)){//独赢
			
			$info .= '独赢-';

			if ($column == 'Match_BzM'){
				$info .= $dm[0];
			}else if ($column == 'Match_BzG'){
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdx)){//大小
			$info .= '总局数:大 / 小-';
			if ($column == 'Match_DxDpl'){
				$info .= 'O' . $match_dxgg;
			}else{
				$info .= 'U' . $match_dxgg;
			}
		}else if (in_array($column, $ds)){//单双
			$info .= '总局数:单双-';
			if ($column == 'Match_DsDpl'){
				$info .= '单';
			}else{
				$info .= '双';
			}
		}else if (in_array($column, $qddfdx )){//球队得分:大小
			$info .= '球员局数:';
			switch ($column) {
				case 'Match_DFzDpl'://主队得分 大
					$info .= '主队局数-大 / 小-';
					$info .= 'O' . $match_dxgg;
					break;
				case 'Match_DFzXpl'://主队得分 小
					$info .= '主队局数-大 / 小-';
					$info .= 'U' . $match_dxgg;
					break;
				case 'Match_DFkDpl'://客队得分 大
					$info .= '客队局数-大 / 小-';
					$info .= 'O' . $match_dxgg;
					break;
				case 'Match_DFkXpl'://客队得分 小
					$info .= '客队局数-大 / 小-';
					$info .= 'U' . $match_dxgg;
					break;
			}
		}
		$info .= '@' . $bet_point;

	}else if(strrpos($ball_sort, '羽毛球') === 0){//网球
		$qddfdx = array('Match_DFkDpl','Match_DFkXpl','Match_DFzDpl','Match_DFzXpl');//球队得分:大小
		$qcdy = array('Match_BzM', 'Match_BzG');//独赢

		if (in_array($column, $qcrq)){//让球
			$info .= '让盘-';
			
			if ($match_showtype == 'H'){
				$info .= '主让' . $match_rgg . '-';
			}else{
				$info .= '客让' . $match_rgg . '-';
			}
			
			if ($column == 'Match_Ho'){
				$info .= $dm[0];
			}else{
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdy)){//独赢
			
			$info .= '独赢-';

			if ($column == 'Match_BzM'){
				$info .= $dm[0];
			}else if ($column == 'Match_BzG'){
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdx)){//大小
			$info .= '总局数:大 / 小-';
			if ($column == 'Match_DxDpl'){
				$info .= 'O' . $match_dxgg;
			}else{
				$info .= 'U' . $match_dxgg;
			}
		}else if (in_array($column, $ds)){//单双
			$info .= '总局数:单双-';
			if ($column == 'Match_DsDpl'){
				$info .= '单';
			}else{
				$info .= '双';
			}
		}else if (in_array($column, $qddfdx )){//球队得分:大小
			$info .= '球员得分:';
			switch ($column) {
				case 'Match_DFzDpl'://主队得分 大
					$info .= $dm[0].'-大 / 小-';
					$info .= 'O' . $match_dxgg;
					break;
				case 'Match_DFzXpl'://主队得分 小
					$info .= $dm[0].'-大 / 小-';
					$info .= 'U' . $match_dxgg;
					break;
				case 'Match_DFkDpl'://客队得分 大
					$info .= $dm[1].'-大 / 小-';
					$info .= 'O' . $match_dxgg;
					break;
				case 'Match_DFkXpl'://客队得分 小
					$info .= $dm[1].'-大 / 小-';
					$info .= 'U' . $match_dxgg;
					break;
			}
		}
		$info .= '@' . $bet_point;

	}elseif((strrpos($ball_sort, '排球') === 0)){//排球
		$qddfdx = array('Match_DFkDpl','Match_DFkXpl','Match_DFzDpl','Match_DFzXpl');//球队得分:大小
		$qcdy = array('Match_BzM', 'Match_BzG');//独赢

		if (in_array($column, $qcrq)){//让球
			$info .= '让分-';
			
			if ($match_showtype == 'H'){
				$info .= '主让' . $match_rgg . '-';
			}else{
				$info .= '客让' . $match_rgg . '-';
			}
			
			if ($column == 'Match_Ho'){
				$info .= $dm[0];
			}else{
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdy)){//独赢
			
			$info .= '独赢-';

			if ($column == 'Match_BzM'){
				$info .= $dm[0];
			}else if ($column == 'Match_BzG'){
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdx)){//大小
			$info .= '总分:大小-';
			if ($column == 'Match_DxDpl'){
				$info .= 'O' . $match_dxgg;
			}else{
				$info .= 'U' . $match_dxgg;
			}
		}else if (in_array($column, $ds)){//单双
			$info .= '总分:单双-';
			if ($column == 'Match_DsDpl'){
				$info .= '单';
			}else{
				$info .= '双';
			}
		}else if (in_array($column, $qddfdx )){//球队得分:大小
			$info .= '球队得分:';
			switch ($column) {
				case 'Match_DFzDpl'://主队得分 大
					$info .= $dm[0].'-大 / 小-';
					$info .= 'O' . $match_dxgg;
					break;
				case 'Match_DFzXpl'://主队得分 小
					$info .= $dm[0].'-大 / 小-';
					$info .= 'U' . $match_dxgg;
					break;
				case 'Match_DFkDpl'://客队得分 大
					$info .= $dm[1].'-大 / 小-';
					$info .= 'O' . $match_dxgg;
					break;
				case 'Match_DFkXpl'://客队得分 小
					$info .= $dm[1].'-大 / 小-';
					$info .= 'U' . $match_dxgg;
					break;
			}
		}
		$info .= '@' . $bet_point;

	}else if((strrpos($ball_sort, '斯诺克') === 0)){
		$qcdy = array('Match_BzM', 'Match_BzG', 'Match_BzH');
		if (in_array($column, $qcrq)){
			$info .= '让球-';
			if ($match_showtype == 'H'){
				$info .= '主让' . $match_rgg . '-';
			}else{
				$info .= '客让' . $match_rgg . '-';
			}
			
			if ($column == 'Match_Ho'){
				$info .= $dm[0];
			}else{
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdx)){
			$info .= '大小-';
			if ($column == 'Match_DxDpl')
			{
				$info .= 'O' . $match_dxgg;
			}
			else
			{
				$info .= 'U' . $match_dxgg;
			}
		}else if (in_array($column, $ds)){
			$info .= '单双-';
			if ($column == 'Match_DsDpl')
			{
				$info .= '单';
			}
			else
			{
				$info .= '双';
			}
		}else if (in_array($column, $qcdy)){
			$info .= '独赢-';
			if ($column == 'Match_BzM')
			{
				$info .= $dm[0];
			}
			else if ($column == 'Match_BzG')
			{
				$info .= $dm[1];
			}
		}
		$info .= '@' . $bet_point;
	}else if((strrpos($ball_sort, '棒球') === 0)){
		$qcdy = array('Match_BzM', 'Match_BzG', 'Match_BzH');
		if (in_array($column, $qcrq)){
			$info .= '让球-';
			if ($match_showtype == 'H'){
				$info .= '主让' . $match_rgg . '-';
			}else{
				$info .= '客让' . $match_rgg . '-';
			}
			
			if ($column == 'Match_Ho'){
				$info .= $dm[0];
			}else{
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdx)){
			$info .= '大小-';
			if ($column == 'Match_DxDpl')
			{
				$info .= 'O' . $match_dxgg;
			}
			else
			{
				$info .= 'U' . $match_dxgg;
			}
		}else if (in_array($column, $ds)){
			$info .= '单双-';
			if ($column == 'Match_DsDpl')
			{
				$info .= '单';
			}
			else
			{
				$info .= '双';
			}
		}else if (in_array($column, $qcdy)){
			$info .= '独赢-';
			if ($column == 'Match_BzM')
			{
				$info .= $dm[0];
			}
			else if ($column == 'Match_BzG')
			{
				$info .= $dm[1];
			}
		}
		$info .= '@' . $bet_point;
	}else if((strrpos($ball_sort, '其他') === 0)){
		$qcdy = array('Match_BzM', 'Match_BzG', 'Match_BzH');
		if (in_array($column, $qcrq)){
			$info .= '让球-';
			if ($match_showtype == 'H'){
				$info .= '主让' . $match_rgg . '-';
			}else{
				$info .= '客让' . $match_rgg . '-';
			}
			
			if ($column == 'Match_Ho'){
				$info .= $dm[0];
			}else{
				$info .= $dm[1];
			}
		}else if (in_array($column, $qcdx)){
			$info .= '大小-';
			if ($column == 'Match_DxDpl')
			{
				$info .= 'O' . $match_dxgg;
			}
			else
			{
				$info .= 'U' . $match_dxgg;
			}
		}else if (in_array($column, $ds)){
			$info .= '单双-';
			if ($column == 'Match_DsDpl')
			{
				$info .= '单';
			}
			else
			{
				$info .= '双';
			}
		}else if (in_array($column, $qcdy)){
			$info .= '独赢-';
			if ($column == 'Match_BzM')
			{
				$info .= $dm[0];
			}
			else if ($column == 'Match_BzG')
			{
				$info .= $dm[1];
			}
		}
		$info .= '@' . $bet_point;
	}else if ((strrpos($ball_sort, '金融') === 0) || (strrpos($ball_sort, '冠军') === 0)){
		global $mydata1_db;
		$params = array(':tid' => $tid);
		$sql = 'SELECT team_name FROM mydata4_db.t_guanjun_team where tid=:tid limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$row = $stmt->fetch();
		if (strrpos($ball_sort, '金融') === 0){
			$row['team_name'] = strtolower(str_replace(' ', '', $row['team_name']));
		}
		$info = $row['team_name'] . '@' . $bet_point;
	}
	return $info;
}

//比分交换
function strrevScore($score){
	$s = explode(':',$score);
	return $s[1].':'.$s[0];
}
?>