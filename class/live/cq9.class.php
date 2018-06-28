<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class CQ9 {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,iscq9 from k_user where uid=:uid',['uid'=>$uid]);
		if($user['iscq9'] == '1') return true;
		$arr = $this->client->liveregcq9($user['username']);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'pwd'=>$arr['password'],'uid'=>$uid];
			$this->db->query('update k_user set cq9UserName=:name,cq9Addtime=now(),iscq9=1,cq9PassWord=:pwd where iscq9=0 and uid=:uid', $params);
			return true;
		}else{
			return ['err'=>$arr['msg']];
		}
	}

	function money($uid){
		$user = $this->db->row('select cq9UserName,cq9PassWord,iscq9 from k_user where uid=:uid',['uid'=>$uid]);
		if($user['iscq9'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])){
				return '0.00';
			}else{
				return $res;
			}
		}
		$arr = $this->client->livebalancecq9($user['cq9UserName'],$user['cq9PassWord']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set cq9money=:money,cq9Addtime=now() where iscq9=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}else{
			return ['err'=>$arr['msg']];
		}
	}

}