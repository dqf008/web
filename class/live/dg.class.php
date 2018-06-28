<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class DG {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,isdg from k_user where uid=:uid',['uid'=>$uid]);
		if($user['isdg'] == '1') return true;
		$arr = $this->client->liveregdg($user['username']);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'pwd'=>$arr['password'],'uid'=>$uid];
			$this->db->query('update k_user set dgUserName=:name,dgAddtime=now(),isdg=1,dgPassWord=:pwd where isdg=0 and uid=:uid', $params);
			return true;
		}
		return ['err'=>$arr['msg']];
	}

	function money($uid){
		$user = $this->db->row('select dgUserName,dgPassWord,isdg from k_user where uid=:uid',['uid'=>$uid]);
		if($user['isdg'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])) return '0.00';
			else return $res;
		}
		$arr = $this->client->livebalancedg($user['dgUserName'],$user['dgPassWord']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set dgmoney=:money,dgAddtime=now() where isdg=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}
		return ['err'=>$arr['msg']];
	}

}