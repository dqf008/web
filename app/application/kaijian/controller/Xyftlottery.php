<?php

namespace app\kaijian\controller;

use app\common\model\Db1_c_auto_8;
class Xyftlottery extends Common
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
        //$type = isset($_GET['type']) ? $_GET['type'] : "xyft";
        $data = Db1_c_auto_8::order('qishu', 'desc')->find();
        $arr  = array();
        if ($data) {
            $arr1     = array();
            $arr2     = array();
            $opencode = array();
            $arr2     = array("first","second","third","fourth","fifth","sixth","seventh","eighth","ninth","tenth");
            for($i=1;$i<11;$i++){
                $opencode[] = substr("00".$data["ball_".$i],-2);
            }
            $sumgy = $data["ball_1"]+$data["ball_2"];
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($arr2 as $k=>$v){
                $arr['result']['data'][$v.'Num']    = $data["ball_".($k+1)];
                if($k<5){
                    $arr['result']['data'][$v.'DT'] = $this->convert($this->compare($data["ball_".($k+1)],$data["ball_".(10-$k)],1));
                }
            }
            $qishu = substr($data['qishu'],-3);
            if($qishu == 180){
                $nextqishu = date('Ymd', $this->time)."001";
                $nextdate  = date("Y-m-d H:i:s", strtotime($data['datetime'])+32405);
            }else{
                $nextqishu = $data['qishu']+1;
                $nextdate  = date("Y-m-d H:i:s", strtotime($data['datetime'])+300);
            }
            $arr['result']['data']['preDrawCode']     = implode(",",$opencode);
            $arr['result']['data']['preDrawIssue']    = $data['qishu'];
            $arr['result']['data']['preDrawTime']     = $data['datetime'];
            $arr['result']['data']['preDrawDate']     = substr($data['datetime'],0,10);
            $arr['result']['data']['drawTime']        = $nextdate;
            $arr['result']['data']['drawIssue']       = $nextqishu;
            $arr['result']['data']['drawCount']       = intval($qishu);
            $arr['result']['data']['sumFS']           = $sumgy;
            $arr['result']['data']['sumSingleDouble'] = $sumgy%2==0 ? 1 : 0;
            $arr['result']['data']['sumBigSamll']     = $sumgy<12 ? 1 : 0;
            $arr['result']['data']['serverTime']      = $this->timezone;
            //$arr['result']['data']['serverTime']      = $data['datetime'];
            $arr['result']['data']['lotName']         = "幸运飞艇";
            $arr['result']['data']['groupCode']       = 35;
            $arr['result']['data']['totalCount']      = 180;
            $arr['result']['data']['iconUrl']         = "";
            $arr['result']['data']['index']           = 100;
            $arr['result']['data']['frequency']       = "";
            $arr['result']['data']['shelves']         = 0;
            $arr['result']['message']                 = "操作成功";
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
        $type = isset($_GET['type']) ? $_GET['type'] : "xyft";
        if($type == "xyft"){
            $content = include '../cache/lot_xyft.php';
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
                if ($v[0] == "冠军" || $v[0] == "冠军vs第十") {
                    $arr1['result']['data'][$k]["rank"] = 1;
                } elseif ($v[0] == "亚军" || $v[0] == "亚军vs第九") {
                    $arr1['result']['data'][$k]["rank"] = 2;
                } elseif ($v[0] == "第三名" || $v[0] == "第三vs第八") {
                    $arr1['result']['data'][$k]["rank"] = 3;
                } elseif ($v[0] == "第四名" || $v[0] == "第四vs第七") {
                    $arr1['result']['data'][$k]["rank"] = 4;
                } elseif ($v[0] == "第五名" || $v[0] == "第五vs第六") {
                    $arr1['result']['data'][$k]["rank"] = 5;
                } elseif ($v[0] == "第六名") {
                    $arr1['result']['data'][$k]["rank"] = 6;
                } elseif ($v[0] == "第七名") {
                    $arr1['result']['data'][$k]["rank"] = 7;
                } elseif ($v[0] == "第八名") {
                    $arr1['result']['data'][$k]["rank"] = 8;
                } elseif ($v[0] == "第九名") {
                    $arr1['result']['data'][$k]["rank"] = 9;
                } elseif ($v[0] == "第十名") {
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
        //$type = isset($_GET['type']) ? $_GET['type'] : "xyft";
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        //$date = "2018-06-15";
        $where['datetime'] = array('like',"%".$date."%");
        $data = Db1_c_auto_8::where($where)->order('qishu', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1     = array();
            $opencode = array();
            $arr1     = array("first","second","third","fourth","fifth");
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                for($i=1;$i<11;$i++){
                    $opencode[$key][] = substr("00".$val["ball_".$i],-2);
                }
                foreach($arr1 as $k=>$v){
                    $arr['result']['data'][$key][$v.'DT'] = $this->convert($this->compare($val["ball_".($k+1)],$val["ball_".(10-$k)],1));
                }
                $sumgy = $val["ball_1"]+$val["ball_2"];
                $arr['result']['data'][$key]['preDrawCode']     = implode(",",$opencode[$key]);
                $arr['result']['data'][$key]['preDrawTime']     = $val['datetime'];
                $arr['result']['data'][$key]['preDrawIssue']    = $val["qishu"];
                $arr['result']['data'][$key]['sumFS']           = $sumgy;
                $arr['result']['data'][$key]['sumSingleDouble'] = $sumgy%2==0 ? 1 : 0;
                $arr['result']['data'][$key]['sumBigSamll']     = $sumgy<12 ? 1 : 0;
                $arr['result']['data'][$key]['groupCode']       = 1;
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
        //$type   = isset($_GET['type']) ? $_GET['type'] : "xyft";
        $date   = $this->datezone;
        //$date = "2018-06-15";
        $where['datetime'] = array('like',"%".$date."%");
        $data = Db1_c_auto_8::where($where)->order('qishu', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1  = array();
            $arr2  = array();
            $arr3  = array();
            $demo  = array();
            $sumDS = array();
            $sumDX = array();
            $singledx = array();
            $singleds = array();
            $arr4 = array("first","second","third","fourth","fifth");
            $arr5 = array("first","second","third","fourth","fifth","sixth","seventh","eighth","ninth","tenth");
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                for($j=1; $j<11; $j++){
                    $demo[$j][] = $val["ball_".$j];
                }
                $sumgy   = $val["ball_1"]+$val["ball_2"];
                $sumDS[] = $sumgy%2==0 ? "双" : "单";
                $sumDX[] = $sumgy<12 ? "小" : "大";
                for($k=1; $k<6; $k++){
                    $arr1[$k][] = $this->convert($this->compare($val["ball_".$k],$val["ball_".(11-$k)],1));
                }
            }
            $sumBigSCount    = array_count_values($sumDX);
            $sumSingleDCount = array_count_values($sumDS);
            for($i=1; $i<11; $i++){
                foreach($demo[$i] as $k=>$v) {
                    $singledx[$i][$k] = $v<6 ? "小" : "大";
                    $singleds[$i][$k] = $v%2==0 ? "双" : "单";
                }
                $arr2[$i]['dx'] = array_count_values($singledx[$i]);
                $arr2[$i]['ds'] = array_count_values($singleds[$i]);
            }
            for($j=1; $j<6; $j++){
                $arr3[$j]['DragonT'] = array_count_values($arr1[$j]);
            }
            foreach($arr4 as $c=>$d){
                $arr['result']['data'][$d.'DragonCount']   = isset($arr3[$c+1]['DragonT'][0]) ? $arr3[$c+1]['DragonT'][0] : 0;
                $arr['result']['data'][$d.'TigerCount']    = isset($arr3[$c+1]['DragonT'][1]) ? $arr3[$c+1]['DragonT'][1] : 0;
            };
            foreach($arr5 as $a=>$b){
                $arr['result']['data'][$b.'SingleCount']   = isset($arr2[$a+1]['ds']['单']) ? $arr2[$a+1]['ds']['单'] : 0;
                $arr['result']['data'][$b.'DoubleCount']   = isset($arr2[$a+1]['ds']['双']) ? $arr2[$a+1]['ds']['双'] : 0;
                $arr['result']['data'][$b.'BigCount']      = isset($arr2[$a+1]['dx']['大']) ? $arr2[$a+1]['dx']['大'] : 0;
                $arr['result']['data'][$b.'SmallCount']    = isset($arr2[$a+1]['dx']['小']) ? $arr2[$a+1]['dx']['小'] : 0;
            }
            $arr['result']['data']['sumSingleCount']     = isset($sumSingleDCount['单']) ? $sumSingleDCount['单'] : 0;
            $arr['result']['data']['sumDoubleCount']     = isset($sumSingleDCount['双']) ? $sumSingleDCount['双'] : 0;
            $arr['result']['data']['sumBigCount']        = isset($sumBigSCount['大']) ? $sumBigSCount['大'] : 0;
            $arr['result']['data']['sumSmallCount']      = isset($sumBigSCount['小']) ? $sumBigSCount['小'] : 0;
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
        //$type = isset($_GET['type']) ? $_GET['type'] : "xyft";
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        //$date = "2018-06-15";
        $where['datetime'] = array('like',"%".$date."%");
        $data = Db1_c_auto_8::where($where)->order('qishu', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1             = array();
            $arr2             = array();
            $arr3             = array();
            $arr4             = array();
            $sumgyarr         = array();
            $demo             = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val) {
                for($i=1;$i<11;$i++){
                    $arr1[$i]["ds"][] = $val["ball_".$i]%2==0 ? 0 : 1;
                    $arr1[$i]["dx"][] = $val["ball_".$i] < 6 ? 0 : 1;
                }
                for($j=1; $j<6; $j++){
                    $arr1[$j]["dt"][] = $this->compare($val["ball_".$j],$val["ball_".(11-$j)],3);  //龙虎
                }
                $sumgy = $val["ball_1"]+$val["ball_2"];
                $sumgyarr["ds"][] = $sumgy%2==0 ? 0 : 1;
                $sumgyarr["dx"][] = $sumgy<12 ? 0 : 1;
            }
            foreach($arr1 as $k=>$v){
                $Shuang         = isset(array_count_values($v['ds'])[0]) ? array_count_values($v['ds'])[0] : 0;     //双
                $Dan            = isset(array_count_values($v['ds'])[1]) ? array_count_values($v['ds'])[1] : 0;     //单
                $demo[$k]['ds'] = array($Shuang,$Dan);
                $Da             = isset(array_count_values($v['dx'])[1]) ? array_count_values($v['dx'])[1] : 0;     //大
                $Xiao           = isset(array_count_values($v['dx'])[0]) ? array_count_values($v['dx'])[0] : 0;     //小
                $demo[$k]['dx'] = array($Da,$Xiao);
                if($k<6){
                    $Dragon         = isset(array_count_values($v['dt'])[1]) ? array_count_values($v['dt'])[1] : 0;     //龙
                    $Tiger          = isset(array_count_values($v['dt'])[0]) ? array_count_values($v['dt'])[0] : 0;     //虎
                    $demo[$k]['dt'] = array($Dragon,$Tiger);
                }
            }
            $sumgyS       = isset(array_count_values($sumgyarr["ds"])[0]) ? array_count_values($sumgyarr["ds"])[0] : 0;
            $sumgyDan     = isset(array_count_values($sumgyarr["ds"])[1]) ? array_count_values($sumgyarr["ds"])[1] : 0;
            $sumgyDSCount = array($sumgyS, $sumgyDan);
            $sumgyX       = isset(array_count_values($sumgyarr["dx"])[0]) ? array_count_values($sumgyarr["dx"])[0] : 0;
            $sumgyDa      = isset(array_count_values($sumgyarr["dx"])[1]) ? array_count_values($sumgyarr["dx"])[1] : 0;
            $sumgyDXCount = array($sumgyDa, $sumgyX);
            for($k=1; $k<11; $k++){
                $arr2[] = array($k,1,$arr1[$k]['ds'],$demo[$k]['ds']);
                $arr2[] = array($k,2,$arr1[$k]['dx'],$demo[$k]['dx']);
                if ($k < 6) {
                    $arr2[] = [$k, 3, $arr1[$k]['dt'], $demo[$k]['dt']];
                }
            }
            $arr3 = array(array(11, 1, $sumgyarr["ds"], $sumgyDSCount), array(11, 2, $sumgyarr["dx"], $sumgyDXCount));
            $arr4 = array_merge($arr2,$arr3);
            foreach($arr4 as $a=>$v){
                $arr['result']['data'][$a]["date"]      = $val['datetime'];
                $arr['result']['data'][$a]["rank"]      = $v[0];
                $arr['result']['data'][$a]["state"]     = $v[1];
                $arr['result']['data'][$a]["roadBeads"] = $v[2];
                $arr['result']['data'][$a]["totals"]    = $v[3];
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
        //$type = isset($_GET['type']) ? $_GET['type'] : "xyfj";
        $date = isset($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        $where['datetime'] = array('like',"%".$date."%");
        $data = Db1_c_auto_8::where($where)->order('qishu', 'asc')->select();
        $arr  = array();
        if($data){
            $yilou = [];
            $arr1  = array();
            $arr2  = array();
            $arr3  = array();
            $arr4  = array();
            $demo  = array();
            $dq    = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            for($i = 0; $i < 10; $i++){
                for($j=0; $j<10; $j++){
                    $yilou[$i][]=0;
                }
            }
            foreach($data as $key=>$val){
                for($i=1;$i<11;$i++){
                    $opencode[$key][] = $val["ball_".$i];
                }
                for($k = 0; $k < 10; $k++){
                    $code = $opencode[$key][$k];
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
                    $arr1[$k]['rank']    = $k+1;
                    $arr1[$k]['missing'] = $v;
                    $dx[$k]              = $v;
                }
                $arr['result']['data']['bodyList'][$key]['preDrawCode'] = $opencode[$key];
                $arr['result']['data']['bodyList'][$key]['preDrawTime'] = $val['datetime'];
                $arr['result']['data']['bodyList'][$key]['preIssue']    = $val["qishu"];
                $arr['result']['data']['bodyList'][$key]['subBodyList'] = $arr1; //遗漏号码
                $demo = $this->arrToOne($yilou);
                for($b=0; $b<100; $b++){
                    if($demo[$b]>0){
                        $arr2[$b][] = $demo[$b];
                        $arr3[$b][] = 0;
                    }else{
                        $arr2[$b][] = 0;
                        $arr3[$b][] = $demo[$b];
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
        //$type = isset($_GET['type']) ? $_GET['type'] : "xyft";
        $single = Db1_c_auto_8::order('qishu', 'desc')->field("datetime")->find();
        $end    = $single["datetime"];
        $time   = substr($single["datetime"],0,10);
        $start  = $this->takeOneMonth($time);
        $where['datetime'] = array('between',"$start,$end");
        $data = Db1_c_auto_8::where($where)->field("datetime,ball_1,ball_2,ball_3,ball_4,ball_5,ball_6,ball_7,ball_8,ball_9,ball_10")->order('qishu', 'desc')->select();
        $arr    = array();
        if($data){
            $arr['errorCode'] = 0;
            $riqi = array();
            $arr1 = array();
            $arr2 = array();
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                $riqi[] = substr($val["datetime"],0,10);
            }
            $riqi = array_unique($riqi);
            foreach($data as $k=>$v){
                foreach($riqi as $key=>$val){
                    if(strpos(substr($v["datetime"],0,10),$val) !== false){
                        for($i=1; $i<11; $i++){
                            $arr1[$val][$i]['dx'][]  = $v["ball_".$i]>5 ? 1 : 2;
                            $arr1[$val][$i]['ds'][]  = $v["ball_".$i]%2==0 ? 2 : 1;
                        }
                    }
                }
            }
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
     * compare 比较
     *
     * @param $int1
     * @param $int2
     * @return string
     */
    public function compare($int1,$int2,$type){
        $num = 0;
        $str = "";
        if($type == 1){
            if($int1 > $int2){
                $str = "龙";
            }else{
                $str = "虎";
            }
            return $str;
        }elseif($type == 2){
            if($int1 > $int2){
                $num = 1; //虎
            }else{
                $num = 0; //龙
            }
            return $num;
        }elseif($type == 3){
            if($int1 > $int2){
                $num = 0; //虎
            }else{
                $num = 1; //龙
            }
            return $num;
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