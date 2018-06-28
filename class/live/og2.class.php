<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class OG2 {

	protected $client;
	protected $db;
	public function __construct(){ 
		$this->client = new RpcClient();
		$this->db = new DB();
	}

	function reg($uid){
		$user = $this->db->row('select username,isog2 from k_user where uid=:uid',['uid'=>$uid]);
		if($user['isog2'] == '1') return true;
		$arr = $this->client->liveregog($user['username']);
		echo 1;
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['username'],'pwd'=>$arr['password'],'uid'=>$uid];
			$this->db->query('update k_user set og2UserName=:name,og2Addtime=now(),isog2=1,og2PassWord=:pwd where isog2=0 and uid=:uid', $params);
			return true;
		}else{
			return ['err'=>$arr['msg']];
		}
	}

	function money($uid){
		$user = $this->db->row('select og2UserName,og2PassWord,isog2 from k_user where uid=:uid',['uid'=>$uid]);
		if($user['isog2'] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])){
		exit;
				return '0.00';
			}else{
				return $res;
			}
		}
		$arr = $this->client->livebalanceog($user['og2UserName'],$user['og2PassWord']);
		if(is_array($arr) && $arr['info']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set og2money=:money,og2Addtime=now() where isog2=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}else{
			return ['err'=>$arr['msg']];
		}
	}

}