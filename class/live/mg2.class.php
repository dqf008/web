<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class MG2 {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,ismg2 from k_user where uid=:uid',['uid'=>$uid]);
		if($user['ismg2'] == '1') return true;
		$arr = $this->client->liveregmg2($user['username']);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'pwd'=>$arr['password'],'uid'=>$uid];
			$this->db->query('update k_user set mg2UserName=:name,mg2Addtime=now(),ismg2=1,mg2PassWord=:pwd where ismg2=0 and uid=:uid', $params);
			return true;
		}
		return ['err'=>$arr['msg']];
	}

	function money($uid){
		$user = $this->db->row('select mg2UserName,mg2PassWord,ismg2 from k_user where uid=:uid',['uid'=>$uid]);
		if($user['ismg2'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])) return '0.00';
			else return $res;
		}
		$arr = $this->client->livebalancemg2($user['mg2UserName'],$user['mg2PassWord']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set mg2money=:money,mg2Addtime=now() where ismg2=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}
		return ['err'=>$arr['msg']];
	}

}