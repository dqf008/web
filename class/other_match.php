<?php 
class other_match{
	static public function getmatch_info($match_id, $point_column = 'match_name'){
		global $mydata1_db;
		$sql_col = 'show columns from mydata4_db.other_match';
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

		$params = array(':match_id' => $match_id);
		$sql = 'select match_name,match_master,match_time,match_date,match_showtype, Match_CoverDate,match_guest,match_type,match_rgg,match_dxgg,' . $point_column . ' from mydata4_db.other_match where match_id=:match_id limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$rs = $stmt->fetch();
		return $rs;
	}
}
?>