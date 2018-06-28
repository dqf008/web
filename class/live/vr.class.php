<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class VR {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,isvr from k_user where uid=:uid',['uid'=>$uid]);
		if($user['isvr'] == '1') return true;
		$arr = $this->client->liveregvr('',$user['username']);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'pwd'=>$arr['password'],'uid'=>$uid];
			$this->db->query('update k_user set vrUserName=:name,vrAddtime=now(),isvr=1,vrPassWord=:pwd where isvr=0 and uid=:uid', $params);
			return true;
		}
		return ['err'=>$arr['msg']];
	}

	function money($uid){
		$user = $this->db->row('select vrUserName,vrPassWord,isvr from k_user where uid=:uid',['uid'=>$uid]);
		if($user['isvr'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])) return '0.00';
			else return $res;
		}
		$arr = $this->client->livebalancevr($user['vrUserName'],$user['vrPassWord']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set vrmoney=:money,vrAddtime=now() where isvr=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}
		return ['err'=>$arr['msg']];
	}

}