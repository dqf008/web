<?php

class CQ9 {

	protected $_db;
	protected $_client;
	protected $_webid;

	public function __construct($conf = array()){
		if($conf){
			$this->_db = $conf['db'];
			$this->_client = $conf['client'];
			$this->_webid = $conf['webid'];
		}
	}

	public function player($account){
		$this->_client($this->_webid, $account);
	}

	public function deposit(){

	}
}