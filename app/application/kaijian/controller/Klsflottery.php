<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/6/6
 * Time: 18:36
 */

namespace app\kaijian\controller;

use app\common\model\Db1_c_auto_klsf;
class Klsflottery extends Common
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
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : "hnkl10";
        $data = Db1_c_auto_klsf::where('name', $type)->order('qishu', 'desc')->find();
        $arr      = array();
        if ($data) {
            $opencode = array($data["ball_1"],$data["ball_2"],$data["ball_3"],$data["ball_4"],$data["ball_5"],$data["ball_6"],$data["ball_7"],$data["ball_8"]);
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            if(array_sum($opencode)>84){
                $int = 0;
            }elseif(array_sum($opencode)<84){
                $int = 1;
            }elseif(array_sum($opencode)==84){
                $int = 2;
            }
            if($type == "hnkl10"){
                $arr['result']['data']['lotCode'] = 10035;
                $arr['result']['data']['lotName'] = "湖南快乐十分";
                $arr['result']['data']['totalCount'] = 84;
                $num       = 84;
                $addtime   = 10*3600+600;
                $spacetime = 600;
            }elseif($type == "sxkl10"){
                $arr['result']['data']['lotCode'] = 10036;
                $arr['result']['data']['lotName'] = "山西快乐十分";
                $arr['result']['data']['totalCount'] = 86;
                $num = 86;
                $addtime = 9*3600+540;
                $spacetime = 540;
            }elseif($type == "ynkl10"){
                $arr['result']['data']['lotCode'] = 10037;
                $arr['result']['data']['lotName'] = "云南快乐十分";
                $arr['result']['data']['totalCount'] = 72;
                $num = 72;
                $addtime = 12*3600+600;
                $spacetime = 540;
            }elseif($type == "cqkl10"){
                $arr['result']['data']['lotCode'] = 10038;
                $arr['result']['data']['lotName'] = "重庆快乐十分";
                $arr['result']['data']['totalCount'] = 97;
            }
            $qishu = substr($data["qishu"],-3);
            if($type == "cqkl10"){
                if($qishu == 97){
                    $nextqishu = date('Ymd', $this->time+10000)."01";
                }else{
                    $nextqishu = $data['qishu']+1;
                }
                if($qishu == 13){
                    $nextdate  = date("Y-m-d H:i:s", strtotime($data['datetime'])+8*3600);
                }else{
                    $nextdate  = date("Y-m-d H:i:s", strtotime($data['datetime'])+600);
                }
            }else{
                if($qishu == $num){
                    $nextqishu = date('Ymd', $this->time+43200)."01";
                    $nextdate  = date("Y-m-d H:i:s", strtotime($data['datetime'])+$addtime);
                }else{
                    $nextqishu = $data['qishu']+1;
                    $nextdate  = date("Y-m-d H:i:s", strtotime($data['datetime'])+$spacetime);
                }
            }
            foreach ($opencode as $val) {
                $codeNum[] = substr("00".$val,-2);
            }
            $arr['result']['data']['drawCount'] = intval($qishu);
            $arr['result']['data']['drawIssue'] = $nextqishu;
            $arr['result']['data']['drawTime'] = $nextdate;
            $arr['result']['data']['preDrawCode'] = implode(",",$codeNum);
            $arr['result']['data']['preDrawIssue'] = $data["qishu"];
            $arr['result']['data']['preDrawTime'] = $data["datetime"];
            $arr['result']['data']['serverTime'] = $this->timezone;
            //$arr['result']['data']['serverTime'] = $data["datetime"];
            $arr['result']['data']['firstDragonTiger'] = $this->convert($this->compare($data["ball_1"],$data["ball_8"],1));
            $arr['result']['data']['secondDragonTiger'] = $this->convert($this->compare($data["ball_2"],$data["ball_7"],1));
            $arr['result']['data']['thirdDragonTiger'] = $this->convert($this->compare($data["ball_3"],$data["ball_6"],1));
            $arr['result']['data']['fourthDragonTiger'] = $this->convert($this->compare($data["ball_4"],$data["ball_5"],1));
            $arr['result']['data']['sumNum'] = array_sum($opencode);
            $arr['result']['data']['sumSingleDouble'] = array_sum($opencode)%2==0 ? 1 : 0;
            $arr['result']['data']['sumBigSmall'] = $int;
            $arr['result']['data']['lastBigSmall'] = array_sum($opencode)>5 ? 0 : 1;
            $arr['result']['data']['groupCode'] = 3;
            $arr['result']['data']['shelves'] = 0;
            $arr['result']['data']['frequency'] = "";
            $arr['result']['data']['index'] = 100;
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
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : "hnkl10";
        if($type == "hnkl10"){
            $content = include '../cache/lot_hnkl10.php';
        }elseif($type == "sxkl10"){
            $content = include '../cache/lot_sxkl10.php';
        }elseif($type == "ynkl10"){
            $content = include '../cache/lot_ynkl10.php';
        }elseif($type == "cqkl10"){
            $content = include '../cache/lot_cqkl10.php';
        }
        //dump($content);die;
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
                } elseif ($v[0] == "第六球") {
                    $arr1['result']['data'][$k]["rank"] = 6;
                } elseif ($v[0] == "第七球") {
                    $arr1['result']['data'][$k]["rank"] = 7;
                } elseif ($v[0] == "第八球") {
                    $arr1['result']['data'][$k]["rank"] = 8;
                } elseif ($v[0] == "总和单双" || $v[0] == "总和大小" || $v[0] == "总和尾数") {
                    $arr1['result']['data'][$k]["rank"] = 9;
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
                }elseif ($v[1] == "尾大") {
                    $arr1['result']['data'][$k]["state"] = 7;
                }elseif ($v[1] == "尾小") {
                    $arr1['result']['data'][$k]["state"] = 8;
                }elseif ($v[1] == "合单") {
                    $arr1['result']['data'][$k]["state"] = 9;
                }elseif ($v[1] == "合双") {
                    $arr1['result']['data'][$k]["state"] = 10;
                }elseif ($v[1] == "和") {
                    $arr1['result']['data'][$k]["state"] = 11;
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
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : "hnkl10";
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        //$where['datetime'] = array('like',"%2018-06-15%");
        $where['datetime'] = array('like',"%".$date."%");
        $where['name'] = $type;
        $data = Db1_c_auto_klsf::where($where)->order('qishu', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1 = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                $opencode = array($val["ball_1"],$val["ball_2"],$val["ball_3"],$val["ball_4"],$val["ball_5"],$val["ball_6"],$val["ball_7"],$val["ball_8"]);
                foreach ($opencode as $k=>$v) {
                    if ($v < 10) {
                        $num[$k] = sprintf("%02d", $v);
                    } else {
                        $num[$k] = $v;
                    }
                }
                if(array_sum($opencode)>84){
                    $int = 0;
                }elseif(array_sum($opencode)<84){
                    $int = 1;
                }elseif(array_sum($opencode)==84){
                    $int = 2;
                }
                $arr['result']['data'][$key]['preDrawCode'] = implode(",",$num);
                $arr['result']['data'][$key]['preDrawIssue'] = $val["qishu"];
                $arr['result']['data'][$key]['preDrawTime'] = $val["datetime"];
                $arr['result']['data'][$key]['firstDragonTiger'] = $this->convert($this->compare($val["ball_1"],$val["ball_8"],1));
                $arr['result']['data'][$key]['secondDragonTiger'] = $this->convert($this->compare($val["ball_2"],$val["ball_7"],1));
                $arr['result']['data'][$key]['thirdDragonTiger'] = $this->convert($this->compare($val["ball_3"],$val["ball_6"],1));
                $arr['result']['data'][$key]['fourthDragonTiger'] = $this->convert($this->compare($val["ball_4"],$val["ball_5"],1));
                $arr['result']['data'][$key]['lastBigSmall'] = $this->judgeWDX($this->subNum(array_sum($opencode)),1);
                $arr['result']['data'][$key]['sumNum'] = array_sum($opencode);
                $arr['result']['data'][$key]['sumSingleDouble'] = array_sum($opencode)%2==0 ? 1 : 0;
                $arr['result']['data'][$key]['sumBigSmall'] = $int;
                $arr['result']['data'][$key]['groupCode'] = 3;
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
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : "hnkl10";
        $date = $this->datezone;
        //$date = "2018-06-15";
        $where['name']     = $type;
        $where['datetime'] = array('like',"%".$date."%");
        $data = Db1_c_auto_klsf::where($where)->order('qishu', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1   = array();
            $arr2   = array();
            $arr3   = array();
            $demo   = array();
            $dxarr  = array();
            $dsarr  = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                $opencode[] = array($val["ball_1"],$val["ball_2"],$val["ball_3"],$val["ball_4"],$val["ball_5"],$val["ball_6"],$val["ball_7"],$val["ball_8"]);
                for($i=1; $i<9; $i++){
                    $demo[$i][]    = $val["ball_".$i];
                }
                $arr1[1][]  = $this->compare($val["ball_1"],$val["ball_8"],1);
                $arr1[2][] = $this->compare($val["ball_2"],$val["ball_7"],1);
                $arr1[3][]  = $this->compare($val["ball_3"],$val["ball_6"],1);
                $arr1[4][]   = $this->compare($val["ball_4"],$val["ball_5"],1);
            }
            foreach($opencode as $k=>$v){
                if(array_sum($v)>84){
                    $dxarr[] = "大";
                }elseif(array_sum($v)<84){
                    $dxarr[] = "小";
                }elseif(array_sum($v)==84){
                    $dxarr[] = "和";
                }
                if(array_sum($v)%2 == 0){
                    $dsarr[] = "双";
                }else{
                    $dsarr[] = "单";
                }
            }
            for($i=1; $i<9; $i++){
                $arr2[$i]['dx'] = array_count_values($this->judgeDx($demo[$i],1));
                $arr2[$i]['ds'] = array_count_values($this->judgeDs($demo[$i],1));
                if($i<5){
                    $arr2[$i]['dt'] = array_count_values($arr1[$i]);
                }
            };
            $arr3 = array("first","second","third","fourth","fifth","sixth","seventh","eighth");
            foreach($arr3 as $a=>$b){
                $arr['result']['data'][$b.'BigCount']    = isset($arr2[$a+1]['dx'][0]) ? $arr2[$a+1]['dx'][0] : 0;
                $arr['result']['data'][$b.'SmallCount']  = isset($arr2[$a+1]['dx'][1]) ? $arr2[$a+1]['dx'][1] : 0;
                $arr['result']['data'][$b.'SingleCount'] = isset($arr2[$a+1]['ds'][0]) ? $arr2[$a+1]['ds'][0] : 0;
                $arr['result']['data'][$b.'DoubleCount'] = isset($arr2[$a+1]['ds'][1]) ? $arr2[$a+1]['ds'][1] : 0;
                if($a<4){
                    $arr['result']['data'][$b.'DragonCount'] = isset($arr2[$a+1]['dt']["龙"]) ? $arr2[$a+1]['dt']["龙"] : 0;
                    $arr['result']['data'][$b.'TigerCount']  = isset($arr2[$a+1]['dt']["虎"]) ? $arr2[$a+1]['dt']["虎"] : 0;
                }
            }
            $sumSingleDCount = array_count_values($dsarr);
            $sumBigSMCount   = array_count_values($dxarr);
            $arr['result']['data']['sumSingleCount']     = isset($sumSingleDCount["单"]) ? $sumSingleDCount["单"] : 0;
            $arr['result']['data']['sumDoubleCount']     = isset($sumSingleDCount["双"]) ? $sumSingleDCount["双"] : 0;
            $arr['result']['data']['sumBigCount']        = isset($sumBigSMCount["大"]) ? $sumBigSMCount["大"] : 0;
            $arr['result']['data']['sumSmallCount']      = isset($sumBigSMCount["小"]) ? $sumBigSMCount["小"] : 0;
            $arr['result']['data']['sumMiddleCount']     = isset($sumBigSMCount["和"]) ? $sumBigSMCount["和"] : 0;
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
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : "hnkl10";
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        $where["datetime"] = array("like","%".$date."%");
        $where['name']     = $type;
        $data = Db1_c_auto_klsf::where($where)->order('qishu', 'asc')->select();
        $arr  = array();
        if($data){
            $arr1             = array();
            $arr2             = array();
            $arr3             = array();
            $arr4             = array();
            $demo             = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val) {
                $opencode[] = array_sum(array($val["ball_1"],$val["ball_2"],$val["ball_3"],$val["ball_4"],$val["ball_5"],$val["ball_6"],$val["ball_7"],$val["ball_8"]));
                for($i=1,$j=8;$i<9;$i++,$j--){
                    $arr1[$i]["ds"][]   = $this->judgeDS($val["ball_".$i],2);           //单双
                    $arr1[$i]["dx"][]   = $this->judgeDX($val["ball_".$i],2);                   //大小
                    $arr1[$i]["wdx"][]  = $this->judgeWDX($this->subNum($val["ball_".$i]),2);   //尾大小
                    $arr1[$i]["hds"][]  = $this->judgeDS($this->sumAdd($val["ball_".$i]),2);  //合单双
                    $arr1[$i]["zfb"][]  = $this->zfb($val["ball_".$i]);                       //中发白
                    $arr1[$i]["dxnb"][] = $this->dxnb($val["ball_".$i]);                      //东西南北
                    if($i<5){
                        $arr1[$i]["DT"][] = $this->compare($val["ball_".$i],$val["ball_".$j],2);   //龙虎
                    }
                }
            }
            foreach($opencode as $v){
                if($v>84){
                    $sumDX[] = 1;
                }elseif($v<84){
                    $sumDX[] = 0;
                }elseif($v==84){
                    $sumDX[] = 9;
                }
                if($v%2 == 0){
                    $sumDS[] = 0;
                }elseif($v%2 == 1){
                    $sumDS[] = 1;
                }
                $sumWDX[] = $this->judgeWDX($this->subNum($v),2);
            }
            foreach($arr1 as $k=>$v){
                $Shuang           = isset(array_count_values($v['ds'])[0]) ? array_count_values($v['ds'])[0] : 0;     //双
                $Dan              = isset(array_count_values($v['ds'])[1]) ? array_count_values($v['ds'])[1] : 0;     //单
                $demo[$k]['ds']   = array($Dan,$Shuang);
                $Xiao             = isset(array_count_values($v['dx'])[0]) ? array_count_values($v['dx'])[0] : 0;     //小
                $Da               = isset(array_count_values($v['dx'])[1]) ? array_count_values($v['dx'])[1] : 0;     //大
                $demo[$k]['dx']   = array($Da,$Xiao);
                $WXiao            = isset(array_count_values($v['wdx'])[0]) ? array_count_values($v['wdx'])[0] : 0;   //尾小
                $WDa              = isset(array_count_values($v['wdx'])[1]) ? array_count_values($v['wdx'])[1] : 0;   //尾大
                $demo[$k]['wdx']  = array($WDa,$WXiao);
                $HShuang          = isset(array_count_values($v['hds'])[0]) ? array_count_values($v['hds'])[0] : 0;   //合双
                $HDan             = isset(array_count_values($v['hds'])[1]) ? array_count_values($v['hds'])[1] : 0;   //合单
                $demo[$k]['hds']  = array($HDan,$HShuang);
                $Zhong            = isset(array_count_values($v['zfb'])[2]) ? array_count_values($v['zfb'])[2] : 0;   //中
                $Fa               = isset(array_count_values($v['zfb'])[3]) ? array_count_values($v['zfb'])[3] : 0;    //发
                $Bai              = isset(array_count_values($v['zfb'])[4]) ? array_count_values($v['zfb'])[4] : 0;    //白
                $demo[$k]['zfb']  = array($Zhong,$Fa,$Bai);
                $dong             = isset(array_count_values($v['dxnb'])[5]) ? array_count_values($v['dxnb'])[5] : 0;  //东
                $xi               = isset(array_count_values($v['dxnb'])[6]) ? array_count_values($v['dxnb'])[6] : 0;  //西
                $nan              = isset(array_count_values($v['dxnb'])[7]) ? array_count_values($v['dxnb'])[7] : 0;  //南
                $bei              = isset(array_count_values($v['dxnb'])[8]) ? array_count_values($v['dxnb'])[8] : 0;  //北
                $demo[$k]['dxnb'] = array($dong,$xi,$nan,$bei);
                if($k<5){
                    $Tiger            = isset(array_count_values($v['DT'])[0]) ? array_count_values($v['DT'])[0] : 0;     //虎
                    $Dragon           = isset(array_count_values($v['DT'])[1]) ? array_count_values($v['DT'])[1] : 0;     //龙
                    $demo[$k]['DT']   = array($Dragon,$Tiger);
                }
            }
            $sumS        = isset(array_count_values($sumDS)[1]) ? array_count_values($sumDS)[1] : 0;       //双
            $sumDan      = isset(array_count_values($sumDS)[0]) ? array_count_values($sumDS)[0] : 0;     //单
            $sumDSCount  = array($sumS,$sumDan);
            $sumDa       = isset(array_count_values($sumDX)[1]) ? array_count_values($sumDX)[1] : 0;       //大
            $sumX        = isset(array_count_values($sumDX)[0]) ? array_count_values($sumDX)[0] : 0;     //小
            $sumH        = isset(array_count_values($sumDX)[9]) ? array_count_values($sumDX)[9] : 0;       //和
            $sumDXCount  = array($sumDa,$sumX,$sumH);
            $sumWD       = isset(array_count_values($sumWDX)[1]) ? array_count_values($sumWDX)[1] : 0;     //总和尾大
            $sumWX       = isset(array_count_values($sumWDX)[0]) ? array_count_values($sumWDX)[0] : 0;   //总和尾小
            $sumWDXCount = array($sumWD,$sumWX);
            for($k=1; $k<9; $k++){
                $arr2[] = array($k,1,$arr1[$k]['ds'],$demo[$k]['ds']);
                $arr2[] = array($k,2,$arr1[$k]['dx'],$demo[$k]['dx']);
                $arr2[] = array($k,4,$arr1[$k]['wdx'],$demo[$k]['wdx']);
                $arr2[] = array($k,5,$arr1[$k]['hds'],$demo[$k]['hds']);
                $arr2[] = array($k,6,$arr1[$k]['zfb'],$demo[$k]['zfb']);
                $arr2[] = array($k,7,$arr1[$k]['dxnb'],$demo[$k]['dxnb']);
                if($k<5){
                    $arr2[] = array($k,3,$arr1[$k]['DT'],$demo[$k]['DT']);
                }
            }
            $arr3 = array(array(9,1,$sumDS,$sumDSCount), array(9,2,$sumDX,$sumDXCount), array(9,4,$sumWDX,$sumWDXCount));
            $arr4 = array_merge($arr2,$arr3);
            foreach($arr4 as $a=>$v){
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
     * dxdshistory 历史大小单双开奖个数
     *
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function dxdshistory(){
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : "hnkl10";
        $where['name'] = $type;
        $single = Db1_c_auto_klsf::where($where)->order('qishu', 'desc')->find();
        $end    = $single["datetime"];
        $time   = substr($single["datetime"],0,10);
        $start  = $this->takeOneMonth($time);
        $where['datetime'] = array('between',"$start,$end");
        $data = Db1_c_auto_klsf::where($where)->field("datetime,ball_1,ball_2,ball_3,ball_4,ball_5,ball_6,ball_7,ball_8")->order('qishu', 'desc')->select();
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
            $riqi = array_unique($riqi);
            foreach($data as $k=>$v){
                foreach($riqi as $key=>$val){
                    if(strpos(substr($v["datetime"],0,10),$val) !== false){
                        for($i=1; $i<9; $i++){
                            $arr1[$val][$i]['dx'][]  = $v["ball_".$i]>10 ? 1 : 2;
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
     * zfb  中发白
     *
     * @param $num
     * @return int
     */
    public function zfb($num){
        $z   = array(1,2,3,4,5,6,7);       //中
        $f   = array(8,9,10,11,12,13,14);  //发
        $b   = array(15,16,17,18,19,20);   //白
        $int = 0;
        if(in_array($num, $z)){
            $int = 2; //中
        }elseif(in_array($num, $f)){
            $int = 3; //发
        }elseif(in_array($num, $b)){
            $int = 4; //白
        }
        return $int;
    }

    /**
     * dxnb  东西南北
     *
     * @param $num
     * @return int
     */
    public function dxnb($num){
        $d = array(1,5,9,13,17);   //东
        $x = array(3,7,11,15,19);  //西
        $n = array(2,6,10,14,18);  //南
        $b = array(4,8,12,16,20);  //北
        $int = 0;
        if(in_array($num, $d)){
            $int = 5; //东
        }elseif(in_array($num, $x)){
            $int = 6; //西
        }elseif(in_array($num, $n)){
            $int = 7; //南
        }elseif(in_array($num, $b)){
            $int = 8; //北
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
     * judgeWDX 判断尾数大小
     *
     * @param $arr
     * @return array
     */
    public function judgeWDX($num,$type){
        $int  = 0;
        $xiao = array(0,1,2,3,4);
        $da   = array(5,6,7,8,9);
        if($type == 1){
            if (in_array($num, $xiao)) {
                $int = 1;
            }elseif(in_array($num, $da)) {
                $int = 0;
            }
        }elseif($type == 2){
            if (in_array($num, $xiao)) {
                $int = 0;
            }elseif(in_array($num, $da)) {
                $int = 1;
            }
        }
        return $int;
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
        }
    }
    /**
     * judgeDX 判断大小
     *
     * @param $arr
     * @return array
     */
    public function judgeDX($num,$type){
        $int = 0;
        $arr = array();
        $dx  = array(1,2,3,4,5,6,7,8,9,10);
        if($type == 1){
            if(is_array($num)){
                foreach($num as $v){
                    if (in_array($v, $dx)) {
                        $arr[] = 1;
                    } else {
                        $arr[] = 0;
                    }
                }
                return $arr;
            }else{
                if (in_array($num, $dx)) {
                    $int = 1;
                } else {
                    $int = 0;
                }
                return $int;
            }
        }elseif($type == 2){
            if (in_array($num, $dx)) {
                $int = 0;
            } else {
                $int = 1;
            }
            return $int;
        }
    }

    /**
     * judgeDS 判断单双
     *
     * @param $arr
     * @return array
     */
    public function judgeDS($num,$type){
        $int = 0;
        $arr = array();
        if($type == 1) {
            if(is_array($num)){
                foreach($num as $v){
                    if($v%2 == 0){
                        $arr[] = 1;
                    }else{
                        $arr[] = 0;
                    }
                }
                return $arr;
            }else{
                if($num%2 == 0){
                    $int = 1;
                }else{
                    $int = 0;
                }
                return $int;
            }
        }elseif($type == 2) {
            if($num%2 == 0){
                $int = 0;
            }else{
                $int = 1;
            }
            return $int;
        }
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
        }elseif($str=="和"){
            $num = 2;
        }else{
            $num = 1;
        }
        return $num;
    }
}
