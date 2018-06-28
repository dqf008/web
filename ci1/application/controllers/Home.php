<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (!empty($_SESSION['uid']) && $_SESSION['uid'] != '') {
            $uid = $_SESSION['uid'];
            $this->load->database();
            $query = $this->db->query('select * from k_user where uid = ?  LIMIT 1', array($uid));
            $user = $query->row_array();
            $this->load->vars('user', $user);
        }
        $notice = $this->notice();
        $this->load->vars('notice', $notice);
        $this->load->vars('act', $this->uri->segment(1));
        $this->load->vars('timestamp', time() * 1000);
    }

    public function index()
    {
        $this->load->database();
        $query = $this->db->query('select * from webinfo where code="main-tc" LIMIT 1');
        $main_tc = $query->row_array();
        if (empty($main_tc) === false) {
            $tmp = unserialize($main_tc['title']);
            if (isset($tmp) && !empty($tmp) && $tmp[0] > 0) {
                $tc['title'] = $tmp[1];
                $tc['content'] = $main_tc['content'];
                $tc['time'] = $tmp[0] * 1000;
                $this->load->vars('main_tc', $tc);
            }
        }
        $this->load->view('head', ['banner'=>'']);
        $this->load->view('home');
        $this->load->view('bottom');
    }

    public function live()
    {
        $this->load->view('head',['banner'=>'/static/public/images/live_banner.jpg']);
        $this->load->view('live');
        $this->load->view('bottom');
    }

    public function game($t = 'XIN')
    {
        $this->load->view('head',['banner'=>'/static/public/images/welcome.jpg']);
        $this->load->view('game', ['platform' => $t]);
        $this->load->view('bottom');
    }

    public function ssc($t = 'cqssc')
    {
        $list = ['cqssc', 'gdkl10', 'pk10', 'kl8', 'shssl', '3d', 'pl3', 'xyft', 'qxc', 'marksix', 'jssc', 'jsssc', 'jslh'];
        if (in_array($t, $list) === false) $t = 'cqssc';
        $this->load->view('head',['banner'=>'/static/public/images/lottery_banner.jpg']);
        $this->load->view('ssc', ['type' => $t]);
        $this->load->view('bottom');
    }

    public function reg()
    {
        if (!empty($_SESSION['uid']) && $_SESSION['uid'] != '') {
            header('Location:/ci/home');
            exit;
        }
        $this->load->view('head',['banner'=>'/static/public/images/welcome.jpg']);
        $this->load->view('reg');
        $this->load->view('bottom');
    }

    public function hot()
    {
        $this->load->database();
        $query = $this->db->query('select * from webinfo where code="promotions" order by id desc');
        $result = $query->result_array();

        $hotSort = $hotList = array();
        foreach ($result as $v) {
            $v['content'] = unserialize($v['content']);
            $hotList[$v['id']] = array(
                'image' => stripcslashes($v['content'][0]),
                'content' => stripcslashes($v['content'][1]),
            );
            $sortKey = intval($v['content'][2]);
            !isset($hotSort[$sortKey]) && $hotSort[$sortKey] = array();
            $hotSort[$sortKey][] = $v['id'];
        }
        krsort($hotSort);
        $this->load->view('head',['banner'=>'/static/public/images/welcome.jpg']);
        $this->load->view('hot', ['hotList' => $hotList, 'hotSort' => $hotSort]);
        $this->load->view('bottom');
    }

    public function wap()
    {
        $this->load->view('head',['banner'=>'/static/public/images/welcome.jpg']);
        $this->load->view('wap');
        $this->load->view('bottom');
    }

    public function sport($t = 'hg')
    {
        $i = 1;
        if (!empty($_SESSION['uid']) && $_SESSION['uid'] != '') $i = 0;
        $ipm = ['cj/live/index.php?type=IPM', 'http://sports.agin7223.com'];
        $sb = ['cj/live/index.php?type=SHABA', 'http://mkt.igame007.cc/?WebSkinType=2&lang=zh'];
        $url = '';
        switch ($t) {
            case 'ipm':
                $url = $ipm[$i];
                break;
            case 'sb':
                $url = $sb[$i];
                break;
        }
        $this->load->view('head',['banner'=>'/static/public/images/sport_banner.jpg']);
        $this->load->view('sport', ['url' => $url]);
        $this->load->view('bottom');
    }

    public function about($t)
    {
        $list = ['1' => 'about-us', '2' => 'about-contact', '3' => 'about-help', '4' => 'about-deposit', '5' => 'about-withdraw', '6' => 'about-partner'];
        if (array_key_exists($t, $list) === false) {
            die();
        }

        $this->load->database();
        $query = $this->db->query('select * from webinfo where code=? limit 1', [$list[$t]]);
        $info = $query->row_array();
        //var_dump($info);
        $this->load->view('head',['banner'=>'/static/public/images/welcome.jpg']);
        $this->load->view('about', ['info' => $info, 't' => $t]);
        $this->load->view('bottom');
    }

    function notice()
    {
        $this->load->database();
        $query = $this->db->query('select * from k_notice where end_time>now() and is_show=1 and web_ID is null order by `sort` desc,nid desc limit 0,5');
        $list = $query->result_array();
        $msg = array();
        foreach ($list as $v) $msg[] = $v['msg'];
        $msg = implode('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $msg);
        return $msg;
    }
}
