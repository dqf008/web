<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class KG {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,iskg from k_user where uid=:uid',['uid'=>$uid]);
		if($user['iskg'] == '1') return true;
		$arr = $this->client->liveregkg($user['username']);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'pwd'=>$arr['password'],'uid'=>$uid];
			$this->db->query('update k_user set kgUserName=:name,kgAddtime=now(),iskg=1,kgPassWord=:pwd where iskg=0 and uid=:uid', $params);
			return true;
		}
		return ['err'=>$arr['msg']];
	}

	function money($uid){
		$user = $this->db->row('select kgUserName,kgPassWord,iskg from k_user where uid=:uid',['uid'=>$uid]);
		if($user['iskg'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])) return '0.00';
			else return $res;
		}
		$arr = $this->client->livebalancekg($user['kgUserName'],$user['kgPassWord']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set kgmoney=:money,kgAddtime=now() where iskg=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}
		return ['err'=>$arr['msg']];
	}

}