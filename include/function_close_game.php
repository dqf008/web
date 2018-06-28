<?php
header('Content-Type:text/html; charset=utf-8');
/**
 * 获取此游戏是否关闭
 * @param $id
 * @return bool
 */
function game_is_close($type,$gametype=''){
    if(empty($type)){
        return false;
    }
    $game_arr = get_game_data();
    if($type == "AGIN" && $gametype == 6){
        $type = '捕鱼王Ⅱ';
    }
    if($type == "BBIN" && $gametype == 1){
        $type = 'BBIN旗舰厅';
    }
    if($type == "BBIN" && $gametype == 4){
       $type = 'BBIN电子';
    }
    /*if($type == "BBIN" && $gametype == 1){

    }*/
    $id = $game_arr[$type];
    global $mydata5_db;
    if($id) {
        $time = time() + 3600 * 12;
        $sql = " select * from aibo_close_game where id ={$id} AND status = 1  ";//and starttime < {$time} and endtime > {$time}
        $query = $mydata5_db->query($sql);
        $rows = $query->fetch();
        if ($rows) {
            if (!empty($rows['title'])) {
                echo "<script> alert('{$rows['title']}');window.close();</script>";
                die;
            } else {
                echo "<script> alert('{$type}系统维护中，暂停下注！');window.close();</script>";
                die;
            }

        }
    }

}




/**
 * 额度转换前判断此游戏是否关闭，关闭则不给予额度转换
 * @param $type
 */
function money_change_game_is_close($type){
    if(empty($type)){
        return false;
    }
    $game_arr = get_game_data();
    $id = $game_arr[$type];
    if($id) {
        $time = time()+ 3600 * 12;
        global $mydata5_db;
          
        $sql = " select * from aibo_close_game where id ={$id} AND status = 1 ";//and starttime < {$time} and endtime > {$time}
        $query = $mydata5_db->query($sql);
        $rows = $query->fetch();
        if ($rows) {
            /*if (!empty($rows['title'])) {
                echo "<script>alert('{$type}系统维护中，暂停额度转入！');</script>";
               
            } else {
                echo "<script>alert('{$type}系统维护中，暂停额度转入！');</script>";
               
            }*/
            return false;   
        }
        
    }
    return true;
}


function display_html_weihu($type){
    if(empty($type)){
        return  '';
    }
    $game_arr = get_game_data();
    $id = $game_arr[$type];
    $time = time()+ 3600 * 12;
    global $mydata5_db;
    if(!$id){
      return '';
    } 
    $sql = " select * from aibo_close_game where id ={$id} and status = 1  ";//and starttime < {$time} and endtime > {$time}
    $query = $mydata5_db->query($sql);
    $rows = $query->fetch();
    if($rows){
        return "&nbsp;&nbsp;<span style='color: #ff0000;'>维护中</span>";
    }
}

/**
 *
 * @return array
 *
 */
function get_game_data(){
    return array(
             'PT'  => 2,
             'AG'  => 3,
             'MW'  => 4,
             'BBIN电子'  => 5,
            'AGIN'   => 6,
            '捕鱼王Ⅱ'   => 7,
            'BBIN' => 8,
            'AG'   => 9,
            'OG'   => 10,
            'BBIN体育'   => 11,
            'MAYA' => 13,
            'ABA'  => 14,
            'HG'   => 15,
    );
}
