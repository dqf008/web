<?php 
class bet_match{
	static public function getmatch_info($match_id, $point_column = 'Match_Name', $ball_sort = ''){
		global $mydata1_db;
		$sql_col = 'show columns from mydata4_db.bet_match';
		$query_col = $mydata1_db->query($sql_col);
		$ok_col = false;
		while ($rs_col = $query_col->fetch()){
			if (strtolower($rs_col['Field']) == strtolower($point_column)){
				$ok_col = true;
				break;
			}
		}
		
		if (!$ok_col){
			exit('point_column error');
		}
		$point = array('match_bho', 'match_bao', 'match_bdpl', 'match_bxpl');
		if ($ball_sort != '足球滚球'){
			$params = array(':match_id' => $match_id);
			if (in_array(strtolower($point_column), $point)){
				$sql = 'select match_name,match_master,match_guest,match_date,match_time,match_type,Match_CoverDate,Match_NowScore,Match_Hr_ShowType as match_showtype,Match_BRpk as match_rgg,Match_Bdxpk as match_dxgg,Match_HRedCard,Match_GRedCard,' . $point_column . ' from mydata4_db.bet_match where match_id=:match_id limit 1';
			}else{
				$sql = 'select match_name,match_master,match_guest,match_date,match_time,match_type,Match_CoverDate,Match_NowScore,match_showtype,match_rgg,match_dxgg,Match_HRedCard,Match_GRedCard,' . $point_column . ' from mydata4_db.bet_match where match_id=:match_id limit 1';
			}
			//echo $match_id;exit;
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			$rs = $stmt->fetch();
			return $rs;
		}else{
			include_once '../../../cache/zqgq.php';
			
			for ($i = 0;$i < count($zqgq);$i++){
				if ($match_id == $zqgq[$i]['Match_ID']){
					break;
				}
			}
			$rs = array();
			$rs['match_name'] = $zqgq[$i]['Match_Name'];
			$rs['match_master'] = $zqgq[$i]['Match_Master'];
			$rs['match_guest'] = $zqgq[$i]['Match_Guest'];
			$rs['match_date'] = $zqgq[$i]['Match_Date'];
			$rs['match_time'] = ($zqgq[$i]['Match_Time'] == '45.5' ? '中场' : $zqgq[$i]['Match_Time']);
			$rs['match_type'] = $zqgq[$i]['Match_Type'];
			$rs['Match_NowScore'] = $zqgq[$i]['Match_score_h'].':'.$zqgq[$i]['Match_score_c'];
			$rs['Match_HRedCard'] = $zqgq[$i]['Match_HRedCard'];
			$rs['Match_GRedCard'] = $zqgq[$i]['Match_GRedCard'];
			if (in_array(strtolower($point_column), $point)){
				$rs['match_showtype'] = $zqgq[$i]['Match_Hr_ShowType'];
				$rs['match_rgg'] = $zqgq[$i]['Match_BRpk'];
				$rs['match_dxgg'] = $zqgq[$i]['Match_Bdxpk'];
				$rs[$point_column] = $zqgq[$i][$point_column];
			}else{
				$rs['match_showtype'] = $zqgq[$i]['Match_ShowType'];
				$rs['match_rgg'] = $zqgq[$i]['Match_RGG'];
				$rs['match_dxgg'] = $zqgq[$i]['Match_DxGG'];
				$rs[$point_column] = $zqgq[$i][$point_column];
			}
			$params = array(':match_id' => $match_id);
			$sql = 'select Match_CoverDate from mydata4_db.bet_match where match_id=:match_id limit 1';
			$stmt = $mydata1_db->prepare($sql);
			$stmt->execute($params);
			if ($row = $stmt->fetch()){
				$rs['Match_CoverDate'] = $row['Match_CoverDate'];
			}
			return $rs;
		}
	}
}
?>