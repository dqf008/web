<?php

namespace app\kaijian\controller;

use app\common\model\Db1_c_auto_choose5;
class X5lottery extends Common
{
    /**
     * kjjg    开奖结果
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     */
    public function kjjg(){
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : 'fjchoose5';
        $data = Db1_c_auto_choose5::where('name',$type)->order('qishu', 'desc')->find();
        $arr  = array();
        if ($data) {
            $arr1 = array();
            $arr['errorCode']              = 0;
            $arr['message']                = "操作成功";
            $arr['result']['businessCode'] = 0;
            if($type == 'fjchoose5'){
                $arr['result']['data']['lotName']    = "福建11选5";
                $arr['result']['data']['totalCount'] = 90;
                $num     = 90;
                $addtime = 600;
            }elseif($type == 'bjchoose5'){
                $arr['result']['data']['lotName']    = "北京11选5";
                $arr['result']['data']['totalCount'] = 85;
                $num     = 85;
                $addtime = 0;
            }
            $qishu = substr($data['qishu'],-2);
            if($qishu == $num){
                $nextqishu = date('Ymd', $this->time+43200)."01";
                $nextdate  = date("Y-m-d H:i:s", strtotime($data['datetime'])+9*3600+$addtime);
            }else{
                $nextqishu = $data['qishu']+1;
                $nextdate  = date("Y-m-d H:i:s", strtotime($data['datetime'])+600);
            }
            $opencode = array($data["ball_1"],$data["ball_2"],$data["ball_3"],$data["ball_4"],$data["ball_5"]);
            if(array_sum($opencode)>30){
                $int = 0;
            }elseif(array_sum($opencode)<30){
                $int = 1;
            }elseif(array_sum($opencode)==30){
                $int = 2;
            }
            $behindtree  = array($data["ball_1"],$data["ball_2"],$data["ball_3"]);
            $betweentree = array($data["ball_2"],$data["ball_3"],$data["ball_4"]);
            $lasttree    = array($data["ball_3"],$data["ball_4"],$data["ball_5"]);
            $arr['result']['data']['behindtree']         = $this->judeRule($behindtree);
            $arr['result']['data']['betweentree']        = $this->judeRule($betweentree);
            $arr['result']['data']['lasttree']           = $this->judeRule($lasttree);
            $arr['result']['data']['behindThree']        = $this->judeRule($behindtree);
            $arr['result']['data']['betweenThree']       = $this->judeRule($betweentree);
            $arr['result']['data']['lastThree']          = $this->judeRule($lasttree);
            $arr['result']['data']['dragonTiger']        = $this->compare($data["ball_1"],$data["ball_5"],1);
            $arr['result']['data']['preDrawCode']        = implode(",",$opencode);
            $arr['result']['data']['preDrawTime']        = $data['datetime'];
            $arr['result']['data']['preDrawIssue']       = $data['qishu'];
            $arr['result']['data']['drawCount']          = intval($qishu);
            $arr['result']['data']['drawIssue']          = $nextqishu;
            $arr['result']['data']['drawTime']           = $nextdate;
            $arr['result']['data']['serverTime']         = $this->timezone;
            //$arr['result']['data']['serverTime']         = $data['datetime'];
            $arr1 = array("first","second","third","fourth","fifth");
            foreach($arr1 as $a=>$b){
                $arr['result']['data'][$b.'Num']           = $data['ball_'.($a+1)];
                $arr['result']['data'][$b.'SingleDouble']  = $this->judgeDS($data['ball_'.($a+1)],1);
                $arr['result']['data'][$b.'BigSmall']      = $this->judgeDX($data['ball_'.($a+1)],1);
            }
            $arr['result']['data']['sumNum']             = array_sum($opencode);
            $arr['result']['data']['sumSingleDouble']    = array_sum($opencode)%2==0 ? 1 : 0;
            $arr['result']['data']['sumBigSmall']        = $int;
            $arr['result']['data']['frequency']          = "";
            $arr['result']['data']['enable']             = "";
            $arr['result']['data']['groupCode']          = 6;
            $arr['result']['data']['id']                 = 242843;
            $arr['result']['data']['index']              = 100;
            $arr['result']['data']['shelves']            = 0;
            $arr['result']['message'] = "操作成功";
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
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : 'fjchoose5';
        if($type == 'fjchoose5'){
            $content = include '../cache/lot_fjchoose5.php';
        }elseif($type == 'bjchoose5'){
            $content = include '../cache/lot_bjchoose5.php';
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
                if($v[0] == "第一球") {
                    $arr1['result']['data'][$k]["rank"] = 1;
                } elseif ($v[0] == "第二球") {
                    $arr1['result']['data'][$k]["rank"] = 2;
                } elseif ($v[0] == "第三球") {
                    $arr1['result']['data'][$k]["rank"] = 3;
                } elseif ($v[0] == "第四球") {
                    $arr1['result']['data'][$k]["rank"] = 4;
                } elseif ($v[0] == "第五球") {
                    $arr1['result']['data'][$k]["rank"] = 5;
                } elseif ($v[0] == "总和单双" || $v[0] == "总和大小") {
                    $arr1['result']['data'][$k]["rank"] = 6;
                } elseif ($v[0] == "总和尾数"){
                    $arr1['result']['data'][$k]["rank"] = 7;
                }
                if ($v[1] == "单") {
                    $arr1['result']['data'][$k]["state"] = 1;
                } elseif ($v[1] == "双") {
                    $arr1['result']['data'][$k]["state"] = 2;
                } elseif ($v[1] == "大") {
                    $arr1['result']['data'][$k]["state"] = 3;
                } elseif ($v[1] == "小") {
                    $arr1['result']['data'][$k]["state"] = 4;
                }elseif ($v[1] == "和") {
                    $arr1['result']['data'][$k]["state"] = 5;
                } elseif ($v[1] == "龙") {
                    $arr1['result']['data'][$k]["state"] = 6;
                } elseif ($v[1] == "虎") {
                    $arr1['result']['data'][$k]["state"] = 7;
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
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : 'fjchoose5';
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        //$date = "2018-06-15";
        $where["datetime"] = array("like","%".$date."%");
        $where['name']     = $type;
        $data = Db1_c_auto_choose5::where($where)->order('qishu', 'desc')->select();
        $arr  = array();
        if($data){
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val) {
                $opencode = array($val["ball_1"],$val["ball_2"],$val["ball_3"],$val["ball_4"],$val["ball_5"]);
                if (array_sum($opencode) > 30) {
                    $int = 0;
                } elseif (array_sum($opencode) < 30) {
                    $int = 1;
                } elseif (array_sum($opencode) == 30) {
                    $int = 2;
                }
                foreach($opencode as $k => $v) {
                    $num[$k] = substr("00".$v,-2);
                }
                $behindtree  = array($val["ball_1"], $val["ball_2"], $val["ball_3"]);
                $betweentree = array($val["ball_2"], $val["ball_3"], $val["ball_4"]);
                $lasttree    = array($val["ball_3"], $val["ball_4"], $val["ball_5"]);
                $arr['result']['data'][$key]['behindThree']     = $this->judeRule($behindtree);
                $arr['result']['data'][$key]['betweenThree']    = $this->judeRule($betweentree);
                $arr['result']['data'][$key]['lastThree']       = $this->judeRule($lasttree);
                $arr['result']['data'][$key]['preDrawCode']     = implode(",", $num);
                $arr['result']['data'][$key]['preDrawTime']     = $val['datetime'];
                $arr['result']['data'][$key]['preDrawIssue']    = $val["qishu"];
                $arr['result']['data'][$key]['sumNum']          = array_sum($opencode);
                $arr['result']['data'][$key]['sumSingleDouble'] = array_sum($opencode) % 2 == 0 ? 1 : 0;
                $arr['result']['data'][$key]['sumBigSmall']     = $int;
                $arr['result']['data'][$key]['dragonTiger']     = $this->compare($val["ball_1"], $val["ball_5"],1);
                $arr['result']['data'][$key]['groupCode']       = 6;
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
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : 'fjchoose5';
        $date = $this->datezone;
        //$date = "2018-06-15";
        $where["datetime"] = array("like","%".$date."%");
        $where['name']     = $type;
        $data = Db1_c_auto_choose5::where($where)->order('qishu', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1  = array();
            $arr2  = array();
            $arr3  = array();
            $arr4  = array();
            $dxarr = array();
            $dsarr = array();
            $demo  = array();
            $arr3  = array("first","second","third","fourth","fifth");
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                $opencode[]       = array($val["ball_1"],$val["ball_2"],$val["ball_3"],$val["ball_4"],$val["ball_5"]);
                for($i=1; $i<6; $i++){
                    $arr1[$i][] = $demo[] = $val["ball_".$i];
                }
            }
            foreach($opencode as $k=>$v){
                if(array_sum($v)> 30){
                    $dxarr[] = "大";
                }elseif(array_sum($v)<30){
                    $dxarr[] = "小";
                }elseif(array_sum($v)==30){
                    $dxarr[] = "和";
                }
                if(array_sum($v)%2 == 0){
                    $dsarr[] = "双";
                }else{
                    $dsarr[] = "单";
                }
            }
            for($k=1; $k<6; $k++){
                $arr2[$k]['ds'] = array_count_values($this->judgeArrDS($arr1[$k]));
                $arr2[$k]['dx'] = array_count_values($this->judgeArrDx($arr1[$k]));
            }
            $arr['result']['data']['sumSingle']    = isset(array_count_values($dsarr)['单']) ? array_count_values($dsarr)['单'] : 0;
            $arr['result']['data']['sumDouble']    = isset(array_count_values($dsarr)['双']) ? array_count_values($dsarr)['双'] : 0;
            $arr['result']['data']['sumBig']       = isset(array_count_values($dxarr)['大']) ? array_count_values($dxarr)['大'] : 0;
            $arr['result']['data']['sumSmall']     = isset(array_count_values($dxarr)['小']) ? array_count_values($dxarr)['小'] : 0;
            foreach($arr3 as $a=>$b){
                $arr['result']['data'][$b.'Single']   = isset($arr2[$a+1]['ds']['单']) ? $arr2[$a+1]['ds']['单'] : 0;
                $arr['result']['data'][$b.'Double']   = isset($arr2[$a+1]['ds']['双']) ? $arr2[$a+1]['ds']['双'] : 0;
                $arr['result']['data'][$b.'Big']      = isset($arr2[$a+1]['dx']['大']) ? $arr2[$a+1]['dx']['大'] : 0;
                $arr['result']['data'][$b.'Small']    = isset($arr2[$a+1]['dx']['小']) ? $arr2[$a+1]['dx']['小'] : 0;
            }
            $numArr = array_count_values($demo);
            $arr4   = array("One","Two","Three","Four","Five","Six","Seven","Eight","Nine","Ten","Eleven");
            foreach($arr4 as $c=>$d){
                $arr['result']['data']['num'.$d] = isset($numArr[$c+1]) ? $numArr[$c+1] : 0;
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
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : 'fjchoose5';
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        $where["datetime"] = array("like","%".$date."%");
        $where['name']     = $type;
        $data = Db1_c_auto_choose5::where($where)->order('qishu', 'asc')->select();
        $arr  = array();
        if($data){
            $arr1             = array();
            $demo             = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            //$arr1 = array(array(1,1,2,2,3,3,4,4,5,5,6,6,1,7),array(1,2,1,2,1,2,1,2,1,2,1,2,3,2));
            foreach($data as $key=>$val) {
                $opencode[] = array_sum(array($val["ball_1"],$val["ball_2"],$val["ball_3"],$val["ball_4"],$val["ball_5"]));
                for($i=1;$i<6;$i++){
                    $arr1[$i]["ds"][] = $this->judgeDS($val["ball_".$i],2);
                    $arr1[$i]["dx"][] = $this->judgeDX($val["ball_".$i],2);
                }
                $firstDT[]  = $this->compare($val["ball_1"],$val["ball_5"],2);  //龙虎
            }
            foreach($opencode as $v){
                if($v>30){
                    $sumDX[] = 1;
                }elseif($v<30){
                    $sumDX[] = -1;
                }elseif($v==30){
                    $sumDX[] = 0;
                }
                if($v%2 == 0){
                    $sumDS[] = 1;
                }elseif($v%2 == 1){
                    $sumDS[] = -1;
                }
                $sumWDX[] = $this->judgeWDX($this->subNum($v));
            }
            foreach($arr1 as $k=>$v){
                $Shuang         = isset(array_count_values($v['ds'])[1]) ? array_count_values($v['ds'])[1] : 0;       //双
                $Dan            = isset(array_count_values($v['ds'])[-1]) ? array_count_values($v['ds'])[-1] : 0;     //单
                $He             = isset(array_count_values($v['ds'])[0]) ? array_count_values($v['ds'])[0] : 0;       //和
                $demo[$k]['ds'] = array($Shuang,$Dan,$He);
                $Da             = isset(array_count_values($v['dx'])[1]) ? array_count_values($v['dx'])[1] : 0;       //大
                $Xiao           = isset(array_count_values($v['dx'])[-1]) ? array_count_values($v['dx'])[-1] : 0;     //小
                $H              = isset(array_count_values($v['dx'])[0]) ? array_count_values($v['dx'])[0] : 0;       //和
                $demo[$k]['dx'] = array($Da,$Xiao,$H);
            }
            $sumS             = isset(array_count_values($sumDS)[1]) ? array_count_values($sumDS)[1] : 0;       //双
            $sumDan           = isset(array_count_values($sumDS)[-1]) ? array_count_values($sumDS)[-1] : 0;     //单
            $sumDSCount       = array($sumS,$sumDan);
            $sumDa            = isset(array_count_values($sumDX)[1]) ? array_count_values($sumDX)[1] : 0;       //大
            $sumX             = isset(array_count_values($sumDX)[-1]) ? array_count_values($sumDX)[-1] : 0;     //小
            $sumH             = isset(array_count_values($sumDX)[0]) ? array_count_values($sumDX)[0] : 0;       //和
            $sumDXCount       = array($sumDa,$sumX,$sumH);

            $firstDr          = isset(array_count_values($firstDT)[1]) ? array_count_values($firstDT)[1] : 0;       //龙
            $firstTi          = isset(array_count_values($firstDT)[0]) ? array_count_values($firstDT)[0] : 0;     //虎
            $firstDTSumCount  = array($firstDr,$firstTi);
            $sumWD            = isset(array_count_values($sumWDX)[1]) ? array_count_values($sumWDX)[1] : 0;       //总和尾大
            $sumWX            = isset(array_count_values($sumWDX)[-1]) ? array_count_values($sumWDX)[-1] : 0;       //总和尾小
            $sumWDXCount      = array($sumWD,$sumWX);
            $arr1 = array(
                array(1,1,$arr1[1]['ds'],$demo[1]['ds']),
                array(1,2,$arr1[1]['dx'],$demo[1]['dx']),
                array(2,1,$arr1[2]['ds'],$demo[2]['ds']),
                array(2,2,$arr1[2]['dx'],$demo[2]['dx']),
                array(3,1,$arr1[3]['ds'],$demo[3]['ds']),
                array(3,2,$arr1[3]['dx'],$demo[3]['dx']),
                array(4,1,$arr1[4]['ds'],$demo[4]['ds']),
                array(4,2,$arr1[4]['dx'],$demo[4]['dx']),
                array(5,1,$arr1[5]['ds'],$demo[5]['ds']),
                array(5,2,$arr1[5]['dx'],$demo[5]['dx']),
                array(6,1,$sumDS,$sumDSCount),
                array(6,2,$sumDX,$sumDXCount),
                array(1,3,$firstDT,$firstDTSumCount),
                array(7,2,$sumWDX,$sumWDXCount)
            );
            foreach($arr1 as $a=>$v){
                $arr['result']['data'][$a]["date"]      = date("Y-m-d",strtotime($val['datetime']));
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
    public function jbzs()
    {
        $type = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : 'fjchoose5';
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        //$date = "2018-06-15";
        $where["datetime"] = array("like","%".$date."%");
        $where['name']     = $type;
        $data = Db1_c_auto_choose5::where($where)->order('qishu', 'asc')->select();
        $arr  = array();
        if($data){
            $yilou = [];
            for($i = 0; $i < 55; $i++){
                $yilou[$i] = 0;
            }
            $arr1  = array();
            $arr2  = array();
            $arr3  = array();
            $arr4  = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                for($k = 1; $k <= 5; $k++){
                    $code = $val['ball_'.$k];
                    $index = ($k - 1) * 11;
                    for($ii = 0; $ii < 11; $ii++){
                        if($code - 1 == $ii){
                            $yilou[$index + $ii] = $code;
                        } else {
                            if ($yilou[$index + $ii] > 0) {
                                $yilou[$index + $ii] = -1;
                            } else {
                                $yilou[$index + $ii]--;
                            }
                        }
                    }
                }
                $opencode = array($val["ball_1"],$val["ball_2"],$val["ball_3"],$val["ball_4"],$val["ball_5"]);
                foreach($opencode as $k => $v) {
                    if ($v < 10) {
                        $num[$k] = sprintf("%02d", $v);
                    } else {
                        $num[$k] = $v;
                    }
                }
                $arr['result']['data'][0]['bodyList'][$key]['code'] = implode(",",$num);
                $arr['result']['data'][0]['bodyList'][$key]['issue'] = $val['qishu'];
                $arr['result']['data'][0]['bodyList'][$key]['array'] = $yilou; //遗漏号码
                for($b=0; $b<55; $b++){
                    if($yilou[$b]>0){
                        $arr1[$b][] = $yilou[$b];
                        $arr2[$b][] = 0;
                    }else{
                        $arr1[$b][] = 0;
                        $arr2[$b][] = $yilou[$b];
                    }

                }
            }
            ksort($arr1);
            ksort($arr2);
            $cxcs = array();
            $zdyl = array();
            $dqyl = array();
            $misslist = array();
            foreach($arr1 as $k=>$v){
                $arr3[] = array_filter($v);
            }
            foreach($arr3 as $k=>$v){
                if(!$v){
                    $cxcs[] = 0;
                }else{
                    $cxcs[] = implode(array_count_values($v));
                }
            }
            foreach($arr2 as $k=>$v){
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
        $type   = isset($_GET['type'])&&!empty($_GET['type']) ? $_GET['type'] : 'fjchoose5';
        $where['name'] = $type;
        $single = Db1_c_auto_choose5::where($where)->order('qishu', 'desc')->find();
        $end    = $single['datetime'];
        $time   = substr($single["datetime"],0,10);
        $start  = $this->takeOneMonth($time);
        $where['datetime'] = array('between',"$start,$end");
        $data   = Db1_c_auto_choose5::where($where)->field("datetime,ball_1,ball_2,ball_3,ball_4,ball_5")->order('qishu', 'desc')->select();
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
                $riqi[] = substr($val["datetime"],0,10);
            }
            foreach($data as $k=>$v){
                foreach(array_unique($riqi) as $key=>$val){
                    if(strpos(substr($v["datetime"],0,10),$val) !== false){
                        for($i=1; $i<6; $i++){
                            $arr1[$val][$i]['dx'][]  = $v["ball_".$i]>6 ? 1 : 2;
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
     * takeOneMonth 取一个月日期
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
     * compare 比较
     *
     * @param $int1
     * @param $int2
     * @return string
     */
    public function compare($int1,$int2,$type){
        $int = 0;
        if($type == 1){
            if($int1 > $int2){
                $int = 0; // "龙";
            }else{
                $int = 1; //"虎";
            }
        }elseif($type == 2){
            if($int1 > $int2){
                $int = 1; // "龙";
            }else{
                $int = 0; //"虎";
            }
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
     * judgeDX 判断尾数大小
     *
     * @param $arr
     * @return array
     */
    public function judgeWDX($num){
        $int  = 0;
        $xiao = array(0,1,2,3,4);
        $da   = array(5,6,7,8,9);
        if (in_array($num, $xiao)) {
            $int = -1;
        }elseif(in_array($num, $da)) {
            $int = 1;
        }
        return $int;
    }

    /**
     * judgeDX 判断单个大小
     *
     * @param $arr
     * @return array
     */
    public function judgeDX($num,$type){
        $int  = 0;
        $xiao = array(1,2,3,4,5);
        $da   = array(6,7,8,9,10);
        if($type == 1){
            if (in_array($num, $xiao)) {
                $int = 1;
            }elseif(in_array($num, $da)) {
                $int = 0;
            }elseif($num == 11) {
                $int = 2;
            }
        }elseif($type == 2){
            if (in_array($num, $xiao)) {
                $int = -1;
            }elseif(in_array($num, $da)) {
                $int = 1;
            }elseif($num == 11) {
                $int = 0;
            }
        }
        return $int;
    }

    /**
     * judgeDS 判断单个单双
     *
     * @param $arr
     * @return array
     */
    public function judgeDS($num,$type){
        $int    = 0;
        $dan    = array(1,3,5,7,9);
        $shuang = array(2,4,6,8,10);
        if($type == 1) {
            if (in_array($num, $shuang)) {
                $int = 1;
            } elseif (in_array($num, $dan)) {
                $int = 0;
            } elseif ($num == 11) {
                $int = 2;
            }
        }elseif($type == 2) {
            if (in_array($num, $shuang)) {
                $int = 1;
            } elseif (in_array($num, $dan)) {
                $int = -1;
            } elseif ($num == 11) {
                $int = 0;
            }
        }
        return $int;
    }
    /**
     * judgeDX 判断数组大小返回文字
     *
     * @param $arr
     * @return array
     */
    public function judgeArrDX($arr){
        $arr1 = array();
        $int  = 0;
        $xiao = array(1,2,3,4,5);
        $da   = array(6,7,8,9,10);
        foreach($arr as $k=>$v) {
            if (in_array($v, $xiao)) {
                $arr1[] = "小";
            }elseif(in_array($v, $da)) {
                $arr1[] = "大";
            }elseif($v == 11) {
                $arr1[] = "和";
            }
        }
        return $arr1;
    }

    /**
     * judgeDS 判断数组单双返回数字文字
     *
     * @param $arr
     * @return array
     */
    public function judgeArrDS($arr){
        $arr1 = array();
        $int  = 0;
        $dan    = array(1,3,5,7,9);
        $shuang = array(2,4,6,8,10);
        foreach($arr as $k=>$v) {
            if (in_array($v, $dan)) {
                $arr1[] = "单";
            }elseif(in_array($v, $shuang)) {
                $arr1[] = "双";
            }elseif($v == 11) {
                $arr1[] = "和";
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