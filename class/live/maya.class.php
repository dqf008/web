<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class MAYA {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,ismaya from k_user where uid=:uid',['uid'=>$uid]);
		if($user['ismaya'] == '1') return true;
		$arr = $this->client->liveloginmaya($user['username']);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'id1'=>$arr['GameMemberID'],'id2'=>$arr['VenderMemberID'],'uid'=>$uid];
			$this->db->query('update k_user set mayaUserName=:name,mayaAddtime=now(),ismaya=1,mayaGameMemberID=:id1,mayaVenderMemberID=:id2 where ismaya=0 and uid=:uid', $params);
			return true;
		}
		return ['err'=>$arr['msg']];
	}

	function money($uid){
		$user = $this->db->row('select mayaUserName,mayaGameMemberID,ismaya from k_user where uid=:uid',['uid'=>$uid]);
		if($user['ismaya'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])) return '0.00';
			else return $res;
		}
		$arr = $this->client->livebalancemaya($user['mayaGameMemberID']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['balance']);
			$this->db->query('update k_user set mayamoney=:money,mayaAddtime=now() where ismaya=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}
		return ['err'=>$arr['msg']];
	}
}