<?php

function userdata(){
    $uid = 1;//$_SESSION['uid'];
    $this->load->database();
    $query = $this->db->query('select * from k_user where uid='.$uid . '  LIMIT 1');
    $row = $query->row();
    var_dump($row);
}