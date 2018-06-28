<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->database();
		$query = $this->db->query('select * from k_notice where end_time>now() and is_show=1 and web_ID is null order by `sort` desc,nid desc limit 0,5');
		$list = $query->result_array();
		$msg = array();
		foreach($list as $v){
			$msg[] = $v['msg'];
		}
		$msg = implode('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $msg);
		return $msg;
		/*
		$msg = array();
		$k_notice = $is_ty?'k_notice_ty':'k_notice';
		$sql = 'select msg from '.$k_notice.' where end_time>now() and is_show=1 and web_ID is null order by `sort` desc,nid desc limit 0,5';
		$query = $mydata1_db->query($sql);
		while ($rs = $query->fetch())
		{
			$msg[] = $rs['msg'];
		}
		$line&&$msg = implode($line, $msg);
		return $msg;*/
	}

	public function test(){
	    echo 'test';
    }
}
