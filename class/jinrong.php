<?php 
class jinrong{
	static public function getmatch_info($tid)	{
		global $mydata1_db;
		$params = array(':tid' => $tid);
		$sql = 'select tt.team_name,tg.Match_CoverDate,tg.match_date,tg.x_title,tt.point,tg.match_name from mydata4_db.t_guanjun_team tt,t_guanjun tg where tt.xid=tg.x_id and tt.tid=:tid limit 1';
		$stmt = $mydata1_db->prepare($sql);
		$stmt->execute($params);
		$rs = $stmt->fetch();
		return $rs;
	}
}
?>