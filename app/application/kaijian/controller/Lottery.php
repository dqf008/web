<?php

namespace app\kaijian\controller;

use app\common\model\Db1_c_auto_data;
class Lottery extends Common
{

    /**
     * kjjg    开奖结果
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     */
    public function kjjg()
    {
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : "jssc";
        $where['type']   = $type;
        $where['status'] = array('between',"0,1");
        $data = Db1_c_auto_data::where($where)->order('qishu', 'desc')->find();
        $arr      = array();
        if ($data) {
            $arr1     = array();
            $arr2     = array();
            $arr3     = array();
            $arr4     = array();
            $arr1     = unserialize($data['value']);
            $arr2     = array("first","second","third","fourth","fifth");
            $arr3     = array("first","second","third","fourth","fifth","sixth","seventh");
            $arr4     = array("first","second","third","fourth","fifth","sixth","seventh","eighth","ninth","tenth");
            $opentime = $data['opentime'];
            $qishu    = $arr1['qishu'];
            $info     = $arr1['info'];
            $opencode = $arr1['opencode'];
            $bjtime   = $this->time;
            $time     = fmod($bjtime-14400, 86400);
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode']         = 0;
            $arr['result']['data']['preDrawTime']  = date("Y-m-d H:i:s", $opentime);
            $arr['result']['data']['preDrawDate']  = date("Y-m-d", $opentime);
            $arr['result']['data']['serverTime']   = $this->timezone;
            $arr['result']['data']['preDrawIssue'] = $qishu;
            /*$arr['result']['data']['sumNum']       = $info[0];*/
            if($type=="jssc" || $type=="jsssc") {
                $arr['result']['data']['drawTime']        = date("Y-m-d H:i:s", ($opentime+75));
                $arr['result']['data']['drawIssue']       = date('Ymd', $bjtime).substr('0000'.(floor($time/75)+1), -4);
                $arr['result']['data']['drawCount']       = preg_replace('/^0*/', '', substr($qishu,-4));
                $arr['result']['data']['sumNum']          = $info[0];
                $arr['result']['data']['sumFS']           = $info[0];
                $arr['result']['data']['sumSingleDouble'] = $this->convert($info[1]);
                $arr['result']['data']['sumBigSamll']     = $this->convert($info[2]);
            }elseif($type == "jslh") {
                $arr['result']['data']['drawTime']        = date("Y-m-d H:i:s", ($opentime+90));
                $arr['result']['data']['drawIssue']       = date('Ymd', $bjtime).substr('000'.(floor($time/90)+1), -3);
                $arr['result']['data']['drawCount']      = preg_replace('/^0*/', '', substr($qishu,-3));
                $arr['result']['data']['sumSingleDouble'] = $info[1]=="单" ? 0 : 1;
                $arr['result']['data']['sumBigSamll']     = $info[2]=="大" ? 0 : 1;
            }elseif($type=="ffk3" || $type=="sfk3" || $type=="wfk3"){
                $arr['result']['data']['preDrawCode']     = implode(",",$opencode);
                $arr['result']['data']['firstSeafood']    = intval($opencode[0]);
                $arr['result']['data']['secondSeafood']   = intval($opencode[1]);
                $arr['result']['data']['thirdSeafood']    = intval($opencode[2]);
                $arr['result']['data']['sumNum']          = $info[0];
                $arr['result']['data']['sumFS']           = $info[0];
                $arr['result']['data']['sumSingleDouble'] = $info[1]=="双" ? 1 : 0;
                $arr['result']['data']['sumBigSamll']     = $this->judgeK3DX($info[2],$opencode);
            }
            if($type == "jssc") {
                foreach ($opencode as $val) {
                    $num[] = substr("00".$val,-2);
                }
                foreach($arr2 as $k=>$v){
                    $arr['result']['data'][$v.'DT']    = $this->convert($info[$k+3]);
                }
                foreach($arr4 as $a=>$b){
                    $arr['result']['data'][$b.'Num']   = $opencode[0];
                }
                $arr['result']['data']['preDrawCode']     = implode(",",$num);
                $arr['result']['data']['lotName']         = "极速赛车";
                $arr['result']['data']['groupCode']       = 1;
                $arr['result']['data']['lotCode']         = 10037;
                $arr['result']['data']['totalCount']      = 1152;
            }elseif($type == "jsssc") {
                $behindtree  = array($opencode[0],$opencode[1],$opencode[2]);
                $betweentree = array($opencode[1],$opencode[2],$opencode[3]);
                $lasttree    = array($opencode[2],$opencode[3],$opencode[4]);
                if($info[3] == "龙"){
                    $dragonTiger = 0;
                }elseif($info[3] == "虎"){
                    $dragonTiger = 1;
                }elseif($info[3] == "和"){
                    $dragonTiger = 2;
                }
                foreach($arr2 as $k=>$v){
                    $arr['result']['data'][$v.'BigSmall']      = $opencode[$k]>5 ? 0 : 1;
                    $arr['result']['data'][$v.'SingleDouble']  = $opencode[$k]%2==0 ? 0 : 1;
                    $arr['result']['data'][$v.'Num']           = $opencode[0];
                }
                $arr['result']['data']['preDrawCode']  = implode(",",$opencode);
                $arr['result']['data']['dragonTiger']  = $dragonTiger;
                $arr['result']['data']['behindThree']  = $this->judeRule($behindtree);
                $arr['result']['data']['betweenThree'] = $this->judeRule($betweentree);
                $arr['result']['data']['lastThree']    = $this->judeRule($lasttree);
                $arr['result']['data']['lotName']      = "极速时时彩";
                $arr['result']['data']['groupCode']    = 2;
                $arr['result']['data']['id']           = "";
                $arr['result']['data']['status']       = 0;
                $arr['result']['data']['sdrawCount']   = "";
                $arr['result']['data']['lotCode']      = 10036;
                $arr['result']['data']['totalCount']   = 1152;
            }elseif($type == "jslh"){
                foreach($arr3 as $k=>$v){
                    $arr['result']['data'][$v.'Num']   = $opencode[$k];
                    $arr['result']['data'][$v]         = $arr1["animal"][$k];
                }
                $arr['result']['data']['preDrawCode']  = implode(",",$opencode);
                $arr['result']['data']['animal']       = implode(",",$arr1["animal"]);
                $arr['result']['data']['lastBigSmall'] = $this->subNum($info[0])>4 ? 0 : 1;
                $arr['result']['data']['color']        = implode(",",$arr1["color"]);
                $arr['result']['data']['animalcolor']  = $arr1["color"];
                $arr['result']['data']['totalCount']   = 960;
            }elseif($type == "ffk3"){
                $arr['result']['data']['drawTime']     = date("Y-m-d H:i:s", ($opentime+60));
                $arr['result']['data']['drawCount']    = preg_replace('/^0*/', '', substr($qishu,-4));
                $arr['result']['data']['drawIssue']    = date('Ymd', $bjtime).substr('0000'.(floor($time/60)+1), -4);
                $arr['result']['data']['lotName']      = "分分快3";
                $arr['result']['data']['totalCount']   = 1440;
            }elseif($type == "sfk3"){
                $arr['result']['data']['drawTime']     = date("Y-m-d H:i:s", ($opentime+180));
                $arr['result']['data']['drawCount']    = preg_replace('/^0*/', '', substr($qishu,-3));
                $arr['result']['data']['drawIssue']    = date('Ymd', $bjtime).substr('0000'.(floor($time/180)+1), -3);
                $arr['result']['data']['lotName']      = "超级快3";
                $arr['result']['data']['totalCount']   = 480;
            }elseif($type == "wfk3"){
                $arr['result']['data']['drawTime']     = date("Y-m-d H:i:s", ($opentime+300));
                $arr['result']['data']['drawCount']    = preg_replace('/^0*/', '', substr($qishu,-3));
                $arr['result']['data']['drawIssue']    = date('Ymd', $bjtime).substr('0000'.(floor($time/300)+1), -3);
                $arr['result']['data']['lotName']      = "好运快3";
                $arr['result']['data']['totalCount']   = 288;
            }
            $arr['result']['data']['iconUrl']          = "";
            $arr['result']['data']['index']            = 100;
            $arr['result']['data']['frequency']        = "";
            $arr['result']['data']['shelves']          = 1;
            $arr['result']['message']                  = "操作成功";
            return $arr;
        } else {
            $arr['errorCode']         = 1;
            $arr['message']           = "操作失败";
            $arr['result']['message'] = "操作失败";
            return $arr;
        }
    }

    /**
     * cldata 长龙统计
     *
     * @return array
     */
    public function cldata()
    {
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : "jssc";
        if($type == "jssc"){
            $content = include '../cache/lot_jssc.php';
        }elseif($type == "jsssc"){
            $content = include '../cache/lot_jsssc.php';
        }
        $arr  = array();
        $arr1 = array();
        if($content){
            $arr1['errorCode'] = 0;
            $arr1['message']   = "操作成功";
            $arr1['result']['businessCode'] = 0;
            $i = 0;
            foreach ($content["两面长龙"] as $key => $val) {
                if ($val > 1) {
                    $arr[$i]          = explode('-', $key);
                    $arr[$i]['count'] = $val;
                }
                $i++;
            }
            foreach ($arr as $k => $v) {
                if ($v[0] == "冠军" || $v[0] == "第一球" || $v[0] == "冠军vs第十") {
                    $arr1['result']['data'][$k]["rank"] = 1;
                } elseif ($v[0] == "亚军" || $v[0] == "第二球" || $v[0] == "亚军vs第九") {
                    $arr1['result']['data'][$k]["rank"] = 2;
                } elseif ($v[0] == "第三名" || $v[0] == "第三球" || $v[0] == "第三vs第八") {
                    $arr1['result']['data'][$k]["rank"] = 3;
                } elseif ($v[0] == "第四名" || $v[0] == "第四球" || $v[0] == "第四vs第七") {
                    $arr1['result']['data'][$k]["rank"] = 4;
                } elseif ($v[0] == "第五名" || $v[0] == "第五球" || $v[0] == "第五vs第六") {
                    $arr1['result']['data'][$k]["rank"] = 5;
                } elseif ($v[0] == "第六名" || $v[0] == "第六球") {
                    $arr1['result']['data'][$k]["rank"] = 6;
                } elseif ($v[0] == "第七名" || $v[0] == "第七球") {
                    $arr1['result']['data'][$k]["rank"] = 7;
                } elseif ($v[0] == "第八名" || $v[0] == "第八球") {
                    $arr1['result']['data'][$k]["rank"] = 8;
                } elseif ($v[0] == "第九名" || $v[0] == "第九球") {
                    $arr1['result']['data'][$k]["rank"] = 9;
                } elseif ($v[0] == "第十名" || $v[0] == "第十球") {
                    $arr1['result']['data'][$k]["rank"] = 10;
                } elseif ($v[0] == "冠亚和" || $v[0] == "总和单双" || $v[0] == "总和大小") {
                    $arr1['result']['data'][$k]["rank"] = 11;
                }
                if ($v[1] == "单") {
                    $arr1['result']['data'][$k]["state"] = 1;
                } elseif ($v[1] == "双") {
                    $arr1['result']['data'][$k]["state"] = 2;
                } elseif ($v[1] == "大") {
                    $arr1['result']['data'][$k]["state"] = 3;
                } elseif ($v[1] == "小") {
                    $arr1['result']['data'][$k]["state"] = 4;
                } elseif ($v[1] == "龙") {
                    $arr1['result']['data'][$k]["state"] = 5;
                } elseif ($v[1] == "虎") {
                    $arr1['result']['data'][$k]["state"] = 6;
                }
                $arr1['result']['data'][$k]['count'] = $v['count'];
            }
            $arr1['result']['message'] = "操作成功";
            return $arr1;
        }else{
            $arr1['errorCode']         = 1;
            $arr1['message']           = "操作失败";
            $arr1['result']['message'] = "操作失败";
            return $arr1;
        }

    }

    /**
     * historyList 今日历史纪录
     *
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function historyList(){
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : "jssc";
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        //$date = "2018-06-15";
        $timeStart = strtotime($date . " 00:00:01");
        $timeEnd   = strtotime($date . " 24:00:00");
        $where['opentime'] = array('between',"$timeStart,$timeEnd");
        $where['status']   = array('between',"0,1");
        $where['type']     = $type;
        $data = Db1_c_auto_data::where($where)->order('qishu', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1 = array();
            $arr2 = array("first","second","third","fourth","fifth");
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                $arr1     = unserialize($val['value']);
                $info     = $arr1['info'];
                if($type=="jssc" || $type=="jsssc") {
                    $arr['result']['data'][$key]['preDrawTime']     = date("Y-m-d H:i:s",$val['opentime']);
                    $arr['result']['data'][$key]['preDrawIssue']    = $arr1["qishu"];
                    $arr['result']['data'][$key]['sumSingleDouble'] = $this->convert($info[1]);
                    $arr['result']['data'][$key]['sumBigSamll']     = $this->convert($info[2]);
                    $arr['result']['data'][$key]['groupCode']       = 1;
                }
                if($type == "jssc") {
                    foreach ($arr1['opencode'] as $k => $v) {
                        $num[$k] = substr("00".$v,-2);
                    }
                    foreach ($arr2 as $a => $b) {
                        $arr['result']['data'][$key][$b.'DT']     = $this->convert($info[$a+3]);
                    }
                    $arr['result']['data'][$key]['preDrawCode'] =  implode(",",$num);
                    $arr['result']['data'][$key]['sumFS']       = $info[0];
                }elseif($type == "jsssc"){
                    $arr['result']['data'][$key]['preDrawCode']     =  implode(",",$arr1['opencode']);
                    $arr['result']['data'][$key]['groupCode']       = 1;
                    $arr['result']['data'][$key]['dragonTiger']     = $this->convert($info[3]);
                    $arr['result']['data'][$key]['sumNum']          = $info[0];
                }elseif($type == "jslh"){
                    $colorArr = array();
                    $czAndFe  = array();
                    foreach($arr1["color"] as $a){
                        $colorArr[] = $this->convertColor($a);
                    }
                    if(isset($_GET)&&isset($_GET['num'])){
                        foreach($arr1["animal"] as $b){
                            if($_GET['num'] == 1){
                                $czAndFe[] = $this->convertAnimal($b);
                            }elseif($_GET['num'] == 3){
                                $czAndFe[] = $this->homeOrbeast($b);
                            }elseif($_GET['num'] == 4){
                                $czAndFe[] = $this->nanV($b);
                            }elseif($_GET['num'] == 5){
                                $czAndFe[] = $this->tianDi($b);
                            }elseif($_GET['num'] == 6){
                                $czAndFe[] = $this->fourSeasons($b);
                            }elseif($_GET['num'] == 7){
                                $czAndFe[] = $this->qinqsh($b);
                            }
                        }
                        if($_GET['num'] == 2){
                            foreach($arr1["opencode"] as $c){
                                $czAndFe[] = $this->fiveElement($c);
                            }
                        }
                        if($_GET['num'] == 8){
                            $czAndFe = $colorArr;
                        }
                        $arr['result']['data']['bodyList'][$key]['czAndFe'] = $czAndFe;
                    }
                    $arr['result']['data']['bodyList'][$key]['color'] = $colorArr;
                    $arr['result']['data']['bodyList'][$key]['animalcolor']  = $arr1["color"];
                    $arr['result']['data']['bodyList'][$key]['issue'] = $arr1["qishu"];
                    $arr['result']['data']['bodyList'][$key]['preDrawCode'] = implode(",",$arr1['opencode']);
                    $arr['result']['data']['bodyList'][$key]['preDrawDate'] = date("Y-m-d",$val['opentime']);
                    $arr['result']['data']['bodyList'][$key]['preDrawTime'] = date("H:i:s",$val['opentime']);
                    $arr['result']['data']['bodyList'][$key]['preDrawIssue'] =  $arr1["qishu"];
                    $arr['result']['data']['bodyList'][$key]['seventhSingleDouble'] = $this->convert($info[3]);
                    $arr['result']['data']['bodyList'][$key]['seventhBigSmall'] = $this->convert($info[4]);
                    $arr['result']['data']['bodyList'][$key]['seventhCompositeBig'] = $this->sumAdd($arr1['opencode'][6])>7 ? 0 : 1;
                    $arr['result']['data']['bodyList'][$key]['seventhCompositeDouble'] = $this->sumAdd($arr1['opencode'][6])%2==0 ? 0 : 1;
                    $arr['result']['data']['bodyList'][$key]['seventhMantissaBig'] = $this->sumAdd($arr1['opencode'][6])>5 ? 0 : 1;
                    $arr['result']['data']['bodyList'][$key]['sumTotal'] = $info[0];
                    $arr['result']['data']['bodyList'][$key]['totalSingleDouble'] = $this->convert($info[1]);
                    $arr['result']['data']['bodyList'][$key]['totalBigSmall'] = $this->convert($info[2]);
                }elseif($type=="ffk3" || $type=="sfk3" || $type=="wfk3"){
                    $opencode = $arr1["opencode"];
                    $arr['result']['data'][$key]['preDrawCode']     = implode(",",$opencode);
                    $arr['result']['data'][$key]['preDrawIssue']    = $arr1["qishu"];
                    $arr['result']['data'][$key]['preDrawTime']     = date("Y-m-d H:i:s", $val["opentime"]);
                    $arr['result']['data'][$key]['firstSeafood']    = intval($opencode[0]);
                    $arr['result']['data'][$key]['secondSeafood']   = intval($opencode[1]);
                    $arr['result']['data'][$key]['thirdSeafood']    = intval($opencode[2]);
                    $arr['result']['data'][$key]['sumNum']          = $info[0];
                    $arr['result']['data'][$key]['sumSingleDouble'] = $info[1]=="双" ? 1 : 0;
                    $arr['result']['data'][$key]['sumBigSmall']     = $this->judgeK3DX($info[2],$opencode);;
                    $arr['result']['data'][$key]['groupCode']       = 3;
                }
            }
            $arr['result']['message'] = "操作成功";
            return $arr;
        }else{
            $arr['errorCode']         = 1;
            $arr['message']           = "操作失败";
            $arr['result']['message'] = "操作失败";
            return $arr;
        }
    }
    /**
     * doubleCount 今日双面/号码统计
     *
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function doubleCount(){
        $type   = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : "jssc";
        $date   = $this->datezone;
        //$date = "2018-06-15";
        $timeStart = strtotime($date . "00:00:01");
        $timeEnd   = strtotime($date . "23:59:59");
        $where['type']     = $type;
        $where['status']   = array('between',"0,1");
        $where['opentime'] = array('between',"$timeStart,$timeEnd");
        $data = Db1_c_auto_data::where($where)->order('qishu', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1  = array();
            $arr2  = array();
            $arr3  = array();
            $arr4  = array();
            $arr5  = array();
            $arr6  = array();
            $arr7  = array();
            $demo  = array();
            $sumDS = array();
            $sumDX = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                $arr1     = unserialize($val['value']);
                $info     = $arr1['info'];
                $opencode = $arr1['opencode'];
                $sumDS[] = $info[1];
                $sumDX[] = $info[2];
                if($type == "jssc") {
                    for($i=0; $i<10; $i++){
                        $arr2[$i+1][] = $opencode[$i];
                    }
                    for($k=1; $k<6; $k++){
                        $arr3[$k][] = $info[$k+2];
                    }
                }else{
                    for($i=0; $i<5; $i++){
                        $arr2[$i+1][] = $opencode[$i];
                    }
                    foreach($opencode as $k=>$v){
                        $demo[] = $v;
                    }
                }
            }
            $sumBigSCount    = array_count_values($sumDX);
            $sumSingleDCount = array_count_values($sumDS);
            $arr7            = array("first","second","third","fourth","fifth");
            if($type == "jssc") {
                for($j=1; $j<11; $j++){
                    $arr4[$j]['ds'] = array_count_values($this->judgeDS($arr2[$j]));
                    $arr4[$j]['dx'] = array_count_values($this->judgeDX($arr2[$j]));
                }
                for($l=1; $l<6; $l++){
                    $arr5[$l]['DragonT'] = array_count_values($arr3[$l]);
                }
                $arr6 = array("first","second","third","fourth","fifth","sixth","seventh","eighth","ninth","tenth");
                foreach($arr6 as $a=>$b){
                    $arr['result']['data'][$b.'SingleCount']   = isset($arr4[$a+1]['ds']['单']) ? $arr4[$a+1]['ds']['单'] : 0;
                    $arr['result']['data'][$b.'DoubleCount']   = isset($arr4[$a+1]['ds']['双']) ? $arr4[$a+1]['ds']['双'] : 0;
                    $arr['result']['data'][$b.'BigCount']      = isset($arr4[$a+1]['dx']['大']) ? $arr4[$a+1]['dx']['大'] : 0;
                    $arr['result']['data'][$b.'SmallCount']    = isset($arr4[$a+1]['dx']['小']) ? $arr4[$a+1]['dx']['小'] : 0;
                }
                foreach($arr7 as $c=>$d){
                    $arr['result']['data'][$d.'DragonCount']   = isset($arr5[$c+1]['DragonT']['龙']) ? $arr5[$c+1]['DragonT']['龙'] : 0;
                    $arr['result']['data'][$d.'TigerCount']    = isset($arr5[$c+1]['DragonT']['虎']) ? $arr5[$c+1]['DragonT']['虎'] : 0;
                };
                $arr['result']['data']['sumSingleCount']     = isset($sumSingleDCount['单']) ? $sumSingleDCount['单'] : 0;
                $arr['result']['data']['sumDoubleCount']     = isset($sumSingleDCount['双']) ? $sumSingleDCount['双'] : 0;
                $arr['result']['data']['sumBigCount']        = isset($sumBigSCount['大']) ? $sumBigSCount['大'] : 0;
                $arr['result']['data']['sumSmallCount']      = isset($sumBigSCount['小']) ? $sumBigSCount['小'] : 0;
            }elseif($type == "jsssc"){
                for($j=1; $j<6; $j++){
                    $arr4[$j]['ds'] = array_count_values($this->judgeDS($arr2[$j]));
                    $arr4[$j]['dx'] = array_count_values($this->judgeDX($arr2[$j]));
                }
                foreach($arr7 as $a=>$b){
                    $arr['result']['data'][$b.'Single']   = isset($arr4[$a+1]['ds']['单']) ? $arr4[$a+1]['ds']['单'] : 0;
                    $arr['result']['data'][$b.'Double']   = isset($arr4[$a+1]['ds']['双']) ? $arr4[$a+1]['ds']['双'] : 0;
                    $arr['result']['data'][$b.'Big']      = isset($arr4[$a+1]['dx']['大']) ? $arr4[$a+1]['dx']['大'] : 0;
                    $arr['result']['data'][$b.'Small']    = isset($arr4[$a+1]['dx']['小']) ? $arr4[$a+1]['dx']['小'] : 0;
                }
                $numArr = array_count_values($demo);
                $arr6   = array("Zero","One","Two","Three","Four","Five","Six","Seven","Eight","Nine");
                foreach($arr6 as $c=>$d){
                    $arr['result']['data']['num'.$d]   = isset($numArr[$c]) ? $numArr[$c] : 0;
                }
                $arr['result']['data']['sumSingle']    = isset($sumSingleDCount['单']) ? $sumSingleDCount['单'] : 0;
                $arr['result']['data']['sumDouble']    = isset($sumSingleDCount['双']) ? $sumSingleDCount['双'] : 0;
                $arr['result']['data']['sumBig']       = isset($sumBigSCount['大']) ? $sumBigSCount['大'] : 0;
                $arr['result']['data']['sumSmall']     = isset($sumBigSCount['小']) ? $sumBigSCount['小'] : 0;
            }
            $arr['result']['message'] = "操作成功";
            return $arr;
        }else{
            $arr['errorCode']         = 1;
            $arr['message']           = "操作失败";
            $arr['result']['message'] = "操作失败";
            return $arr;
        }
    }

    /**
     * analyze  路珠分析
     *
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function analyze(){
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : "jssc";
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        $timeStart = strtotime($date . "00:00:01");
        $timeEnd   = strtotime($date . "23:59:59");
        $where['opentime'] = array('between',"$timeStart,$timeEnd");
        $where['type']     = $type;
        $where['status']   = array('between',"0,1");
        $data = Db1_c_auto_data::limit(1152)->where($where)->order('qishu', 'asc')->select();
        $arr  = array();
        if($data){
            $arr1             = array();
            $arr2             = array();
            $arr3             = array();
            $k3arr            = array();
            $sumgyarr         = array();
            $firstDT          = array();
            $sum              = array();
            $demo             = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val) {
                $arr1 = unserialize($val['value']);
                if($type=="ffk3" || $type=="sfk3" || $type=="wfk3"){
                    $k3arr['sum'][] = $arr1["info"][0];
                    $k3arr['ds'][]  = $arr1["info"][1]=="双" ? 1 :0;
                    $k3arr['dx'][]  = $this->judgeK3DX($arr1["info"][2],$arr1["opencode"]);
                }else{
                    if($type == "jssc"){
                        $num = 10;
                    }elseif($type == "jsssc"){
                        $num = 5;
                    }
                    for($i=0;$i<$num;$i++){
                        $arr2[$i+1]["ds"][] = $arr1['opencode'][$i]%2==0 ? 0 : 1;
                        if($type == "jssc") {
                            $arr2[$i + 1]["dx"][] = $arr1['opencode'][$i] < 6 ? 0 : 1;
                        }elseif($type == "jsssc") {
                            $arr2[$i + 1]["dx"][] = $arr1['opencode'][$i] < 5 ? 0 : 1;
                        }
                    }
                    if($type == "jssc"){
                        for($j=3; $j<8; $j++){
                            $arr2[$j-2]["dt"][]  = $arr1['info'][$j]=="虎" ? 0 : 1;  //龙虎
                        }
                        $sumgy = $arr1['opencode'][0]+$arr1['opencode'][1];
                        $sumgyarr["ds"][] = $sumgy%2==0 ? 0 : 1;
                        $sumgyarr["dx"][] = $sumgy<12 ? 0 : 1;
                    }elseif($type == "jsssc"){
                        $sum['ds'][] = $arr1['info'][1]=="双" ? 0 : 1;
                        $sum['dx'][] = $arr1['info'][2]=="小" ? 0 : 1;
                        $firstDT[]   = $arr1['info'][3]=="虎" ? 0 : 1;

                    }
                }
            }
            if($type=="ffk3" || $type=="sfk3" || $type=="wfk3") {
                $Shuang = isset(array_count_values($k3arr['ds'])[1]) ? array_count_values($k3arr['ds'])[1] : 0;       //双
                $dan = isset(array_count_values($k3arr['ds'])[0]) ? array_count_values($k3arr['ds'])[0] : 0;       //和
                $arr2['ds'] = array($dan, $Shuang, 0);
                $Da = isset(array_count_values($k3arr['dx'])[0]) ? array_count_values($k3arr['dx'])[0] : 0;       //大
                $Xiao = isset(array_count_values($k3arr['dx'])[1]) ? array_count_values($k3arr['dx'])[1] : 0;     //小
                $He = isset(array_count_values($k3arr['dx'])[2]) ? array_count_values($k3arr['dx'])[2] : 0;       //和
                $arr2['dx'] = array($Da, $Xiao, $He);
                $arr3 = array(
                    array(1, $k3arr['ds'], $arr2['ds']),
                    array(2, $k3arr['dx'], $arr2['dx'])
                );
                foreach ($arr3 as $a => $b) {
                    $arr['result']['data'][$a]["date"] = date("Y-m-d", strtotime($val['opentime']));
                    $arr['result']['data'][$a]["rank"] = 0;
                    $arr['result']['data'][$a]["state"] = $b[0];
                    $arr['result']['data'][$a]["roadBeads"] = $b[1];
                    $arr['result']['data'][$a]["totals"] = $b[2];
                }
            }else {
                foreach ($arr2 as $k => $v) {
                    $Shuang = isset(array_count_values($v['ds'])[0]) ? array_count_values($v['ds'])[0] : 0;     //双
                    $Dan = isset(array_count_values($v['ds'])[1]) ? array_count_values($v['ds'])[1] : 0;     //单
                    $demo[$k]['ds'] = array($Shuang, $Dan);
                    $Da = isset(array_count_values($v['dx'])[1]) ? array_count_values($v['dx'])[1] : 0;     //大
                    $Xiao = isset(array_count_values($v['dx'])[0]) ? array_count_values($v['dx'])[0] : 0;     //小
                    $demo[$k]['dx'] = array($Da, $Xiao);
                    if ($type == "jssc") {
                        if ($k < 6) {
                            $Dragon = isset(array_count_values($v['dt'])[1]) ? array_count_values($v['dt'])[1] : 0;     //龙
                            $Tiger = isset(array_count_values($v['dt'])[0]) ? array_count_values($v['dt'])[0] : 0;     //虎
                            $demo[$k]['dt'] = array($Dragon, $Tiger);
                        }
                    }
                }
                if ($type == "jssc") {
                    $sumgyS = isset(array_count_values($sumgyarr["ds"])[0]) ? array_count_values($sumgyarr["ds"])[0] : 0;
                    $sumgyDan = isset(array_count_values($sumgyarr["ds"])[1]) ? array_count_values($sumgyarr["ds"])[1] : 0;
                    $sumgyDSCount = array($sumgyS, $sumgyDan);
                    $sumgyX = isset(array_count_values($sumgyarr["dx"])[0]) ? array_count_values($sumgyarr["dx"])[0] : 0;
                    $sumgyDa = isset(array_count_values($sumgyarr["dx"])[1]) ? array_count_values($sumgyarr["dx"])[1] : 0;
                    $sumgyDXCount = array($sumgyDa, $sumgyX);
                } elseif ($type == "jsssc") {
                    $firstD = isset(array_count_values($firstDT)[0]) ? array_count_values($firstDT)[0] : 0;
                    $firstT = isset(array_count_values($firstDT)[1]) ? array_count_values($firstDT)[1] : 0;
                    $firstDTCount = array($firstD, $firstT);
                    $sumS = isset(array_count_values($sum["ds"])[0]) ? array_count_values($sum["ds"])[0] : 0;
                    $sumDan = isset(array_count_values($sum["ds"])[1]) ? array_count_values($sum["ds"])[1] : 0;
                    $sumDSCount = array($sumS, $sumDan);
                    $sumX = isset(array_count_values($sum["dx"])[0]) ? array_count_values($sum["dx"])[0] : 0;
                    $sumDa = isset(array_count_values($sum["dx"])[1]) ? array_count_values($sum["dx"])[1] : 0;
                    $sumDXCount = array($sumX, $sumDa);
                }
                for ($k = 1; $k < $num + 1; $k++) {
                    $arr3[] = array($k, 1, $arr2[$k]['ds'], $demo[$k]['ds']);
                    $arr3[] = array($k, 2, $arr2[$k]['dx'], $demo[$k]['dx']);
                    if ($type == "jssc") {
                        if ($k < 6) {
                            $arr3[] = [$k, 3, $arr2[$k]['dt'], $demo[$k]['dt']];
                        }
                    }
                }
                if ($type == "jssc") {
                    $arr4 = array(
                        array(11, 1, $sumgyarr["ds"], $sumgyDSCount),
                        array(11, 2, $sumgyarr["dx"], $sumgyDXCount)
                    );
                } elseif ($type == "jsssc") {
                    $arr4 = array(
                        array(6, 1, $sum["ds"], $sumDSCount),
                        array(6, 2, $sum["dx"], $sumDXCount),
                        array(12, 3, $firstDT, $firstDTCount)
                    );
                }
                $arr5 = array_merge($arr3, $arr4);
                foreach ($arr5 as $a => $v) {
                    $arr['result']['data'][$a]["date"] = date("Y-m-d", strtotime($val['opentime']));
                    $arr['result']['data'][$a]["rank"] = $v[0];
                    $arr['result']['data'][$a]["state"] = $v[1];
                    $arr['result']['data'][$a]["roadBeads"] = $v[2];
                    $arr['result']['data'][$a]["totals"] = $v[3];
                }
            }
            $arr['result']['message'] = "操作成功";
            return $arr;
        }else{
            $arr['errorCode']         = 1;
            $arr['message']           = "操作失败";
            $arr['result']['message'] = "操作失败";
            return $arr;
        }
    }

    /**
     * jbzs  基本走势
     *
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function jbzs(){
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : "jssc";
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        $timeStart = strtotime($date . "00:00:01");
        $timeEnd   = strtotime($date . "23:59:59");
        $where['opentime'] = array('between',"$timeStart,$timeEnd");
        $where['type']     = $type;
        $where['status']   = array('between',"0,1");
        $data = Db1_c_auto_data::limit(1152)->where($where)->order('qishu', 'asc')->select();
        $arr  = array();
        if($data){
            $yilou = [];
            $arr1  = array();
            $arr2  = array();
            $arr3  = array();
            $arr4  = array();
            $arr5  = array();
            $arr6  = array();
            $demo  = array();
            $dq    = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            if($type == "jssc"){
                for($i = 0; $i < 10; $i++){
                    for($j=0; $j<10; $j++){
                        $yilou[$i][]=0;
                    }
                }
                foreach($data as $key=>$val){
                    $arr1     = unserialize($val['value']);
                    $opencode = $arr1['opencode'];
                    for($k = 0; $k < 10; $k++){
                        $code = $opencode[$k];
                        for($ii = 0; $ii < 10; $ii++){
                            if($code - 1 == $ii){
                                $yilou[$k][$ii] = $code;
                            } else {
                                if ($yilou[$k][$ii] > 0) {
                                    $yilou[$k][$ii] = -1;
                                } else {
                                    $yilou[$k][$ii]--;
                                }
                            }
                        }
                    }
                    foreach($yilou as $k=>$v){
                        $arr2[$k]['rank']    = $k+1;
                        $arr2[$k]['missing'] = $v;
                        $dx[$k]              = $v;
                    }
                    $arr['result']['data']['bodyList'][$key]['preDrawCode'] = $opencode;
                    $arr['result']['data']['bodyList'][$key]['preDrawTime'] = date("Y-m-d H:i:s",$val['opentime']);
                    $arr['result']['data']['bodyList'][$key]['preIssue']    = $arr1["qishu"];
                    $arr['result']['data']['bodyList'][$key]['subBodyList'] = $arr2; //遗漏号码
                    $demo = $this->arrToOne($yilou);
                    for($b=0; $b<100; $b++){
                        if($demo[$b]>0){
                            $arr3[$b][] = $demo[$b];
                            $arr4[$b][] = 0;
                        }else{
                            $arr3[$b][] = 0;
                            $arr4[$b][] = $demo[$b];
                        }

                    }
                }
                ksort($arr3);
                ksort($arr4);
                $cxcs = array();
                $zdyl = array();
                $dqyl = array();
                foreach($arr3 as $k=>$v){
                    $arr5[] = array_filter($v);
                }
                foreach($arr5 as $k=>$v){
                    if(!$v){
                        $cxcs[] = 0;
                    }else{
                        $cxcs[] = implode(array_count_values($v));
                    }
                }
                foreach($arr4 as $k=>$v){
                    $zdyl[] = min($v);
                }
                $arr['result']['data']['bodyList'] = array_reverse($arr['result']['data']['bodyList']);
                foreach($dx as $key=>$val){
                    foreach($val as $k=>$v){
                        if($v>0){
                            $dqyl[] = 0;
                        }else{
                            $dqyl[] = $v;
                        }
                    }
                }
                $arr['result']['data']['titleList']['appearCount'] = $cxcs;
                $arr['result']['data']['titleList']['currentMissingValues'] = $dqyl;
                $arr['result']['data']['titleList']['maxMissingValues'] = $zdyl;
            }elseif($type == "jsssc"){
                for($i = 0; $i < 5; $i++){
                    for($j=0; $j<10; $j++){
                        $yilou1[] = $yilou[]=0;
                    }
                }
                foreach($data as $key=>$val){
                    $arr1     = unserialize($val['value']);
                    $opencode = $arr1['opencode'];
                    for($k = 0; $k < 5; $k++){
                        $code  = $opencode[$k];
                        $index = $k*10;
                        for($ii = 0; $ii < 10; $ii++){
                            if($code == $ii){
                                $yilou[$index+$ii] = $code;
                            } else {
                                if ($yilou[$index+$ii] > 0) {
                                    $yilou[$index+$ii] = -1;
                                } else {
                                    $yilou[$index+$ii]--;
                                }
                            }
                        }
                    }
                    $arr['result']['data'][0]['bodyList'][$key]['code']  = implode(",",$opencode);
                    $arr['result']['data'][0]['bodyList'][$key]['issue'] = $arr1['qishu'];
                    $arr['result']['data'][0]['bodyList'][$key]['array'] = $yilou; //遗漏号码
                    for($k = 0; $k < 5; $k++){
                        $code  = $opencode[$k]+1;
                        $index = $k*10;
                        for($ii = 0; $ii < 10; $ii++){
                            if($code-1 == $ii){
                                $yilou1[$index+$ii] = $code;
                            } else {
                                if ($yilou1[$index+$ii] > 0) {
                                    $yilou1[$index+$ii] = -1;
                                } else {
                                    $yilou1[$index+$ii]--;
                                }
                            }
                        }
                    }
                    for($b=0; $b<50; $b++){
                        if($yilou1[$b]>-1){
                            $arr2[$b][] = $yilou1[$b];
                            $arr3[$b][] = 0;
                        }else{
                            $arr2[$b][] = "";
                            $arr3[$b][] = $yilou1[$b];
                        }

                    }
                }
                ksort($arr2);
                ksort($arr3);
                $cxcs = array();
                $zdyl = array();
                $dqyl = array();
                foreach($arr2 as $k=>$v){
                    $arr4[] = array_filter($v);
                }
                foreach($arr4 as $k=>$v){
                    if(!$v){
                        $cxcs[] = 0;
                    }else{
                        $cxcs[] = implode(array_count_values($v));
                    }
                }
                foreach($arr3 as $k=>$v){
                    $zdyl[] = min($v);
                }
                $arr['result']['data'][0]['bodyList'] = array_reverse($arr['result']['data'][0]['bodyList']);
                foreach($arr['result']['data'][0]['bodyList'][0]["array"] as $val){
                    if($val>0){
                        $dqyl[] = 0;
                    }else{
                        $dqyl[] = $val;
                    }
                }
                $yiloudata = array($cxcs,$zdyl,$dqyl);
                foreach($yiloudata as $k=>$v){
                    $misslist[$k]['rank']  = $k;
                    $misslist[$k]['array'] = $v;
                }
                $arr['result']['data'][0]['missList'] = $misslist;
            }elseif($type=="ffk3" || $type=="sfk3" || $type=="wfk3"){
                for($i = 0; $i < 3; $i++){
                    for($j=0; $j<10; $j++){
                        $yilou[$i][]=0;
                    }
                }
                foreach($data as $key=>$val){
                    $arr1     = unserialize($val['value']);
                    sort($arr1["opencode"]);
                    for($k = 0; $k <3; $k++){
                        $code = $arr1["opencode"][$k];
                        for($ii = 0; $ii < 10; $ii++){
                            if($ii<6){
                                if($code - 1 == $ii){
                                    $yilou[$k][$ii] = $code;
                                } else {
                                    if ($yilou[$k][$ii] > 0) {
                                        $yilou[$k][$ii] = -1;
                                    } else {
                                        $yilou[$k][$ii]--;
                                    }
                                }
                            }elseif($ii==6){
                                if(in_array($code,[4,5,6])){
                                    $yilou[$k][$ii] = 1;
                                }else{
                                    if ($yilou[$k][$ii] > 0) {
                                        $yilou[$k][$ii] = -1;
                                    } else {
                                        $yilou[$k][$ii]--;
                                    }
                                }
                            }elseif($ii==7){
                                if(in_array($code,[1,2,3])){
                                    $yilou[$k][$ii] = 1;
                                }else{
                                    if ($yilou[$k][$ii] > 0) {
                                        $yilou[$k][$ii] = -1;
                                    } else {
                                        $yilou[$k][$ii]--;
                                    }
                                }
                            }elseif($ii==8){
                                if($code%2 == 1){
                                    $yilou[$k][$ii] = 1;
                                }else{
                                    if ($yilou[$k][$ii] > 0) {
                                        $yilou[$k][$ii] = -1;
                                    } else {
                                        $yilou[$k][$ii]--;
                                    }
                                }
                            }elseif($ii==9){
                                if($code%2 == 0){
                                    $yilou[$k][$ii] = 1;
                                }else{
                                    if ($yilou[$k][$ii] > 0) {
                                        $yilou[$k][$ii] = -1;
                                    } else {
                                        $yilou[$k][$ii]--;
                                    }
                                }
                            }
                        }
                    }
                    $arr['result']['data']['bodyList'][$key]['drawCode'] = array_values($arr1["opencode"]);
                    $arr['result']['data']['bodyList'][$key]['preIssue'] = $arr1["qishu"];
                    $arr['result']['data']['bodyList'][$key]['oneCode']  = $yilou[0]; //遗漏号码
                    $arr['result']['data']['bodyList'][$key]['twoCode']  = $yilou[1]; //遗漏号码
                    $arr['result']['data']['bodyList'][$key]['threeCode']  = $yilou[2]; //遗漏号码
                    $arr2 = $this->arrToOne($yilou);
                    for($b=0; $b<30; $b++){
                        if($arr2[$b]>0){
                            $arr3[$b][] = $arr2[$b];
                            $arr4[$b][] = 0;
                        }else{
                            $arr3[$b][] = 0;
                            $arr4[$b][] = $arr2[$b];
                        }

                    }
                }
                ksort($arr3);
                ksort($arr4);
                $cxcs = array();
                $zdyl = array();
                $dqyl = array();
                foreach($arr3 as $k=>$v){
                    $arr5[] = array_filter($v);
                }
                foreach($arr5 as $k=>$v){
                    if(!$v){
                        $cxcs[] = 0;
                    }else{
                        $cxcs[] = implode(array_count_values($v));
                    }
                }
                foreach($arr4 as $k=>$v){
                    $zdyl[] = min($v);
                }
                $arr['result']['data']['bodyList'] = array_reverse($arr['result']['data']['bodyList']);
                $codeArr = array("one","two","three");
                foreach($codeArr as $k=>$v){
                    foreach($arr['result']['data']['bodyList'][0][$v."Code"] as $val){
                        if($val>0){
                            $arr6[$k+1][] = 0;
                        }else{
                            $arr6[$k+1][] = $val;
                        }
                    }
                }
                for($m=1; $m<4; $m++){
                    foreach($arr6[$m] as $k=>$v){
                        $dqyl[] = $v;
                    }
                }
                $arr['result']['data']['basicTrendTitle']['appearCount'] = $cxcs;
                $arr['result']['data']['basicTrendTitle']['currentMissingValues'] = $dqyl;
                $arr['result']['data']['basicTrendTitle']['maxMissingValues'] = $zdyl;
            }
            $arr['result']['message'] = "操作成功";
            return $arr;
        }else{
            $arr['errorCode']         = 1;
            $arr['message']           = "操作失败";
            $arr['result']['message'] = "操作失败";
            return $arr;
        }
    }

    /**
     * dxdshistory 历史大小单双开奖个数
     *
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function dxdshistory(){
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : "jssc";
        $where['type']   = $type;
        $where['status'] = array('between',"0,1");
        $single = Db1_c_auto_data::where('type', $type)->order('qishu', 'desc')->find();
        $end    = $single["opentime"];
        $time   = date("Y-m-d",$single["opentime"]);
        $start  = strtotime($this->takeOneMonth($time));
        $where['qishu'] = array('between',"$start,$end");
        $data   = Db1_c_auto_data::where($where)->order('qishu', 'desc')->select();
        $arr    = array();
        if($data){
            $arr['errorCode'] = 0;
            $riqi = array();
            $arr1 = array();
            $arr2 = array();
            $arr3 = array();
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                $riqi[] = date("Y-m-d",$val["opentime"]);
            }
            $riqi = array_unique($riqi);
            foreach($data as $k=>$v){
                foreach($riqi as $key=>$val){
                    if(date("Y-m-d",$v["opentime"]) == $val){
                         for($i=0; $i<10; $i++){
                             $arr1[$val][$i]['dx'][]  = unserialize($v['value'])['opencode'][$i]>5 ? 1 : 2;
                             $arr1[$val][$i]['ds'][]  = unserialize($v['value'])['opencode'][$i]%2==0 ? 2 : 1;
                         }
                    }
                }
            };
            foreach($arr1 as $a=>$b){
                foreach($b as $c=>$d){
                    $arr2[$a][$c][] = isset(array_count_values($d["dx"])[1]) ? array_count_values($d["dx"])[1] : 0;
                    $arr2[$a][$c][] = isset(array_count_values($d["dx"])[2]) ? array_count_values($d["dx"])[2] : 0;
                    $arr2[$a][$c][] = isset(array_count_values($d["ds"])[1]) ? array_count_values($d["ds"])[1] : 0;
                    $arr2[$a][$c][] = isset(array_count_values($d["ds"])[2]) ? array_count_values($d["ds"])[2] : 0;
                }
            }
            $i = 0;
            foreach($arr2 as $K=>$V){
                $arr['result']['data'][$i]['date'] = $K;
                $arr['result']['data'][$i]['list'] = $V;
                $i++;
            }
            $arr['result']['message'] = "操作成功";
            return $arr;
        }else{
            $arr['errorCode']         = 1;
            $arr['message']           = "操作失败";
            $arr['result']['message'] = "操作失败";
            return $arr;
        }
    }

    /**
     * takeOneMonth 取一个月时间
     *
     * @param $date
     * @return false|string
     */
    public function takeOneMonth($date){
        $str     = "";
        $da      = array(1,2,4,6,8,9,11);
        $xiao    = array(5,7,10,12);
        $month   = intval(substr($date,5, 2));
        $maxdate = strtotime($date);
        if(in_array($month,$da)){
            $str = date("Y-m-d H:i:s",$maxdate-30*24*60*60);
        }elseif(in_array($month,$xiao)){
            $str = date("Y-m-d H:i:s",$maxdate-29*24*60*60);
        }elseif($month == 3){
            $str = date("Y-m-d H:i:s",$maxdate-27*24*60*60);
        }
        return $str;
    }

    /**
     * arrToOne  多维数组合并为一个数组
     *
     * @param $arr
     * @return array
     */
    public function arrToOne($arr){
        $arr1 = array();
        foreach ($arr as $key => $val) {
            if( is_array($val) ) {
                $arr1 = array_merge($arr1, $this->arrToOne($val));
            } else {
                $arr1[] = $val;
            }
        }
        return $arr1;
    }

    public function homeOrbeast($str){
        $int = 0;
        $home = array("牛","马","羊","鸡","狗","猪"); //家禽
        if(in_array($str, $home)) {
            $int = 1; //家禽
        }else{
            $int = 2; //野兽
        }
        return $int;
    }
    public function fiveElement($num){
        $Jin = [3,4,17,18,25,26,33,34,47,48];	//金
        $Mu = [7,8,15,16,29,30,37,38,45,46];	//木
       	$Shui = [5,6,13,14,21,22,35,36,43,44];	//水
        $Huo = [1,2,9,10,23,24,31,32,39,40];	//火
        $int = 0;
        if(in_array($num, $Jin)){
            $int = 1; //金
        }elseif(in_array($num, $Mu)){
            $int = 2; //木
        }elseif(in_array($num, $Shui)){
            $int = 3; //水
        }elseif(in_array($num, $Huo)){
            $int = 4; //水
        }else{
            $int = 5; //土
        }
        return $int;
    }
    public function nanv($str){
        $Nan = ["鼠","牛","虎","龙","马","猴","狗"];	//男
        $Nv = ["兔","蛇","羊","鸡","猪"];	//女
        $int = 0;
        if(in_array($str, $Nan)) {
            $int = 1; //男
        }else{
            $int = 2; //女
        }
        return $int;
    }
    public function tianDi($str){
        $tian = ["牛","兔","龙","马","猴","猪"];	//天
        $di = ["鼠","虎","蛇","羊","鸡","狗"];	//地
        $int = 0;
        if(in_array($str, $tian)) {
            $int = 1; //天
        }else{
            $int = 2; //地
        }
        return $int;
    }
    public function fourSeasons($str){
        $tmps = ["虎","兔","龙"];	//春
        $tmpd = ["蛇","马","羊"];	//夏
        $tmpf = ["猴","鸡","狗"];    //秋
        $tmpg = ["鼠","牛","猪"];	//冬
        $int = 0;
        if(in_array($str, $tmps)){
            $int = 1; //春
        }elseif(in_array($str, $tmpd)){
            $int = 2; //夏
        }elseif(in_array($str, $tmpf)){
            $int = 3; //秋
        }else{
            $int = 4; //冬
        }
        return $int;
    }
    public function qinqsh($str){
        $tmps = ["兔","蛇","鸡"];	//琴
        $tmpd = ["鼠","牛","狗"];	//棋
        $tmpf = ["虎","龙","马"];	//书
        $tmpg = ["羊","猴","猪"];	//画
        $int = 0;
        if(in_array($str, $tmps)){
            $int = 1; //琴
        }elseif(in_array($str, $tmpd)){
            $int = 2; //棋
        }elseif(in_array($str, $tmpf)){
            $int = 3; //书
        }else{
            $int = 4; //画
        }
        return $int;
    }

    /**
     * subNum 截取最后一位
     *
     * @param $int
     * @return bool|int|string
     */
    public function subNum($int){
        $str = "$int";
        $num = 0;
        if(strlen($str)<2){
            $num = intval($str);
        }else{
            $num = intval(substr($str,1,1));
        }
        return $num;
    }

    /**
     * sumAdd  两位数拆开相加
     *
     * @param $int
     * @return bool|int|string
     */
    public function sumAdd($int){
        $str = "$int";
        $num = 0;
        if(strlen($str)<2){
            $num = intval($str);
        }else{
            $num = intval(substr($str,0,1))+substr($str,1,1);
        }
        return $num;
    }
    /**
     * convertAnimal 生肖转换
     *
     * @param $str
     * @return int
     */
    public function convertAnimal($str){
        $int = 0;
        if($str == "鼠"){
            $int = 1;
        }elseif($str == "牛"){
            $int = 2;
        }elseif($str == "虎"){
            $int = 3;
        }elseif($str == "兔"){
            $int = 4;
        }elseif($str == "龙"){
            $int = 5;
        }elseif($str == "蛇"){
            $int = 6;
        }elseif($str == "马"){
            $int = 7;
        }elseif($str == "羊"){
            $int = 8;
        }elseif($str == "猴"){
            $int = 9;
        }elseif($str == "鸡"){
            $int = 10;
        }elseif($str == "狗"){
            $int = 11;
        }elseif($str == "猪"){
            $int = 12;
        }
        return $int;
    }

    /**
     * convertColor 颜色转换
     *
     * @param $str
     * @return int
     */
    public function convertColor($str){
        $int = 0;
        if($str == "red"){
            $int = 1;
        }elseif($str == "green"){
            $int = 2;
        }elseif($str == "blue"){
            $int = 3;
        }
        return $int;
    }
    /**
     * judeRule
     *
     * @param $arr
     * @return int 0：杂六、1：半顺、2：顺子、3：对子、4：豹子
     */
    public function judeRule($arr){
        $int = 0;
        if($arr[0]==$arr[1] && $arr[1]==$arr[2]){
            $int = 4; // '豹子'
        }else{
            if($arr[0]==$arr[1] || $arr[0] == $arr[2] || $arr[1] == $arr[2]){
                $int = 3; // '对子'
            }else{
                $num = 0;
                if(abs($arr[0]-$arr[1]) == 1){
                    $num++;
                }
                if (abs($arr[0]-$arr[2]) == 1){
                    $num++;
                }
                if(abs($arr[1]-$arr[2]) == 1){
                    $num++;
                }
                if($num == 0){
                    $int = 0; // '杂六'
                }if($num == 1){
                    $int = 1; // '半顺'
                }if($num == 2){
                    $int = 2; // '顺子'
                }
            }
        }
        return $int;
    }

    public function judgeK3DX($num,$code){
        $int = 0;
        if($code[0]==$code[1] && $code[1]==$code[2]){
            $int = 2;
        }elseif($num == "小"){
            $int = 1;
        }elseif($num == "大"){
            $int = 0;
        }
        return $int;
    }
    /**
     * judgeDX 判断大小
     *
     * @param $arr
     * @return array
     */
    public function judgeDX($arr){
        $arr1 = array();
        $dx   = array(1,2,3,4,5);
        if(is_array($arr)){
            foreach($arr as $k=>$v) {
                if (in_array($v, $dx)) {
                    $arr1[] = "小";
                } else {
                    $arr1[] = "大";
                }
            }
        }
        return $arr1;
    }

    /**
     * judgeDS 判断单双
     *
     * @param $arr
     * @return array
     */
    public function judgeDS($arr){
        $arr1 = array();
        $ds   = array(1,3,5,7,9,11,13);
        if(is_array($arr)) {
            foreach ($arr as $v) {
                if($v%2 == 0){
                    $arr1[] = "单";
                } else {
                    $arr1[] = "双";
                }
            }
        }
        return $arr1;
    }
    public function arroper( $arr, $num ) {
        $count = count ( $arr );
        for ($i = 0; $i < $count/$num; $i++ ) {
            $return_arr["$i"] = array_slice ( $arr, $num*$i, $num);
        }
        return $return_arr;
    }

    /**
     * convert 值转换
     *
     * @param $str
     * @return int
     */
    public function convert($str){
        $num = 0;
        if($str=="单" || $str=="大" || $str=="龙"){
            $num = 0;
        }elseif($str=="双" || $str=="小" || $str=="虎"){
            $num = 1;
        }elseif($str=="和"){
            $num = 2;
        }
        return $num;
    }
    /*public function repeatCount(){
        $type   = $_GET?$_GET['type']:"jssc";
        $single = Db1_c_auto_data::where('type',$type)->order('id', 'desc')->find();
        $gyhDS  = unserialize($single['value'])['info'][1];
        $gyhDX  = unserialize($single['value'])['info'][2];
        $more   = Db1_c_auto_data::where('type',$type)->limit(100)->order('id', 'desc')->select();
        $arr    = array();
        $data   = array();
        foreach($more as $key=>$val){
            $arr['gyh']['ds'][] = unserialize($val['value'])['info'][1];
            $arr['gyh']['dx'][] = unserialize($val['value'])['info'][2];
        }
        $demo = array();
        $demo['gyhds']= $this->countdata($arr['gyh']['ds'],$gyhDS);
        $demo['gyhdx']= $this->countdata($arr['gyh']['dx'],$gyhDX);
    }
    public function countdata($arr,$str){
        $arr    = array();
        $counts = 0;
        foreach($arr as $val){
            if($val == $str){
                $counts++;
            }else{
                break;
            }
        }
        if($counts>1){
            $arr[] = array(
                "rand"=>'11',
                "count"=>$counts,
                "status"=>1
            );
        }
        return $counts;
    }*/
}