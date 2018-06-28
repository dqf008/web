<?php

include_once __DIR__ . '/../RpcClient.class.php';
include_once __DIR__ . '/../Db.class.php';

class AG {

	protected $client;
	protected $db;
	protected $sql;
	protected $type;
	protected $list = [
		'AGIN' => ['name'=>'agUserName', 'pwd'=>'agPassWord', 'money'=>'agmoney', 'is'=>'isag', 'time'=>'agAddtime'],
		'AG' => ['name'=>'agqUserName', 'pwd'=>'agqPassWord', 'money'=>'agqmoney', 'is'=>'isagq', 'time'=>'agqAddtime'],
		'BBIN' => ['name'=>'bbinUserName', 'pwd'=>'bbinPassWord', 'money'=>'bbmoney', 'is'=>'isbbin', 'time'=>'bbinAddtime'],
		'OG' => ['name'=>'ogUserName', 'pwd'=>'ogPassWord', 'money'=>'ogmoney', 'is'=>'isog', 'time'=>'ogAddtime'],
		'SHABA' => ['name'=>'shabaUserName', 'pwd'=>'shabaPassWord', 'money'=>'shabamoney', 'is'=>'isshaba', 'time'=>'shabaAddtime'],
		'PT' => ['name'=>'ptUserName', 'pwd'=>'ptPassWord', 'money'=>'ptmoney', 'is'=>'ispt', 'time'=>'ptAddtime'],
	];
	public function __construct($type){ 
		$this->client = new RpcClient();
		$this->db = new DB();
		$this->type = $type;
		$this->sql = $this->list[$type];
	}

	function reg($uid){
		$name = $this->sql['name'];
		$pwd = $this->sql['pwd'];
		$time = $this->sql['time'];
		$is = $this->sql['is'];
		$user = $this->db->row('select username,'.$this->sql['is'].' from k_user where uid=:uid',['uid'=>$uid]);
		if($user[$is] == '1') return true;
		$arr = $this->client->livereg($user['username'],$this->type);
		if(is_array($arr) && $arr['info']=='ok'){
			$params = ['name'=>$arr['msg'][0],'pwd'=>$arr['msg'][1],'uid'=>$uid];
			$this->db->query('update k_user set '.$name.'=:name,'.$time.'=now(),'.$is.'=1,'.$pwd.'=:pwd where '.$is.'=0 and uid=:uid', $params);
			echo 'update k_user set '.$name.'=:name,'.$time.'=now(),'.$is.'=1,'.$pwd.'=:pwd where '.$is.'=0 and uid=:uid';
			print_r($params);
			return true;
		}else{
			return ['err'=>$arr['msg']];
		}
	}

	function money($uid){
		$user = $this->db->row('select '.$this->sql['name'].','.$this->sql['pwd'].','.$this->sql['is'].' from k_user where uid=:uid',['uid'=>$uid]);
		if($user[$this->sql['is']] == '0'){
			$res = $this->reg($uid);
			if(empty($res['err'])){
				return '0.00';
			}else{
				return $res;
			}
		}
		$arr = $this->client->livebalance($user[$this->sql['name']],$user[$this->sql['pwd']],$this->type);
		if(is_array($arr) && $arr['result']=='ok'){
			$money = sprintf("%.2f",$arr['money']);
			$this->db->query('update k_user set '.$this->sql['money'].'=:money,'.$this->sql['time'].'=now() where '.$this->sql['is'].'=1 and uid=:uid', ['uid'=>$uid, 'money'=>$money]);
			return $money;
		}			
		return ['err'=>$arr['msg']];

	}

}