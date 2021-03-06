<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class PT2 {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,ispt2 from k_user where uid=:uid',['uid'=>$uid]);
		if($user['ispt2'] == '1') return true;
		$arr = $this->client->liveregpt($user['username']);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'pwd'=>$arr['password'],'uid'=>$uid];
			$this->db->query('update k_user set pt2UserName=:name,pt2Addtime=now(),ispt2=1,pt2PassWord=:pwd where ispt2=0 and uid=:uid', $params);
			return true;
		}
		return ['err'=>$arr['msg']];
	}

	function money($uid){
		$user = $this->db->row('select pt2UserName,pt2PassWord,ispt2 from k_user where uid=:uid',['uid'=>$uid]);
		if($user['ispt2'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])) return '0.00';
			else return $res;
		}
		$arr = $this->client->livebalancept($user['pt2UserName'],$user['pt2PassWord']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set pt2money=:money,pt2Addtime=now() where ispt2=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}
		return ['err'=>$arr['msg']];
	}
}