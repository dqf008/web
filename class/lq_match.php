<?php 
class lq_match{
	static public function getmatch_info($match_id, $point_column = 'Match_Name', $ball_sort = '')	{
		global $mydata1_db;
		$sql_col = 'show columns from mydata4_db.lq_match';
		$query_col = $mydata1_db->query($sql_col);
		$ok_col = false;
		while ($rs_col = $query_col->fetch())		{
			if (strtolower($rs_col['Field']) == strtolower($point_column))			{
				$ok_col = true;
				break;
			}
		}

		if (!$ok_col){
			exit('point_column error');
		}

		if ($ball_sort != '篮球滚球'){
			$params = array(':match_id' => $match_id);
			$sql = 'select match_name,match_master,match_time,match_date,Match_CoverDate,match_guest,Match_NowScore,match_showtype,match_type,match_rgg,match_dxgg,' . $point_column . '  from mydata4_db.lq_match where match_id=:match_id limit 1';
			$stmt = $mydata1_db->prepare($sql);
			//echo $sql;exit;
			$stmt->execute($params);
			$rs = $stmt->fetch();
			return $rs;
		}else{
			include_once '../cache/lqgq.php';
			
			for ($i = 0;$i < count($lqgq);$i++){
				if ($match_id == $lqgq[$i]['Match_ID']){
					break;
				}
			}

			$rs = array();
			$rs['match_name'] = $lqgq[$i]['Match_Name'];
			$rs['match_master'] = $lqgq[$i]['Match_Master'];
			$rs['match_time'] = $lqgq[$i]['Match_Time'];
			$rs['match_guest'] = $lqgq[$i]['Match_Guest'];
			$rs['Match_NowScore'] = $lqgq[$i]['Match_NowScore'];
			$rs['match_showtype'] = $lqgq[$i]['Match_ShowType'];
			$rs['match_type'] = $lqgq[$i]['Match_Type'];
			$rs['match_rgg'] = $lqgq[$i]['Match_RGG'];
			$rs['match_dxgg'] = $lqgq[$i]['Match_DxGG'];
			$rs[$point_column] = round($lqgq[$i][$point_column], 2);
			$params = array(':match_id' => $match_id);
			$sql = 'select Match_CoverDate from mydata4_db.lq_match where match_id=:match_id limit 1';
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