<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class MW {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,ismw from k_user where uid=:uid',['uid'=>$uid]);
		if($user['ismw'] == '1') return true;
		$arr = $this->client->liveregmw('',$user['username']);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'pwd'=>$arr['password'],'uid'=>$uid];
			$this->db->query('update k_user set mwUserName=:name,mwAddtime=now(),ismw=1,mwPassWord=:pwd where ismw=0 and uid=:uid', $params);
			return true;
		}else{
			return ['err'=>$arr['msg']];
		}
	}

	function money($uid){
		$user = $this->db->row('select mwUserName,mwPassWord,ismw from k_user where uid=:uid',['uid'=>$uid]);
		if($user['ismw'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])){
				return '0.00';
			}else{
				return $res;
			}
		}
		$arr = $this->client->livebalancemw($user['mwUserName'],$user['mwPassWord']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set mwmoney=:money,mwAddtime=now() where ismw=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}else{
			return ['err'=>$arr['msg']];
		}
	}

}