<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class BG {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,isbg from k_user where uid=:uid',['uid'=>$uid]);
		if($user['isbg'] == '1') return true;
		$arr = $this->client->liveregbg($user['username']);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'pwd'=>$arr['password'],'uid'=>$uid];
			$this->db->query('update k_user set bgUserName=:name,bgAddtime=now(),isbg=1,bgPassWord=:pwd where isbg=0 and uid=:uid', $params);
			return true;
		}
		return ['err'=>$arr['msg']];
	}

	function money($uid){
		$user = $this->db->row('select bgUserName,bgPassWord,isbg from k_user where uid=:uid',['uid'=>$uid]);
		if($user['isbg'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])) return '0.00';
			else return $res;
		}
		$arr = $this->client->livebalancebg($user['bgUserName'],$user['bgPassWord']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set bgmoney=:money,bgAddtime=now() where isbg=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}
		return ['err'=>$arr['msg']];
	}

}