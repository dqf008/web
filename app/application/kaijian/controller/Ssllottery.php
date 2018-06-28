<?php

namespace app\kaijian\controller;

use app\common\model\Db1_lottery_k_ssl;
class Ssllottery extends Common
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
        $data = Db1_lottery_k_ssl::order('qihao', 'desc')->find();
        $arr  = array();
        if ($data) {
            $arr1     = array();
            $opencode = array($data["hm1"],$data["hm2"],$data["hm3"]);
            if(array_sum($opencode)>14){
                $int = 0;
            }elseif(array_sum($opencode)<13){
                $int = 1;
            }
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            $arr1 = array("first","second","third");
            foreach($arr1 as $a=>$b){
                $arr['result']['data'][$b.'Num']          = $data['hm'.($a+1)];
                $arr['result']['data'][$b.'SingleDouble'] = $data['hm'.($a+1)]%2==0 ? 1 : 0;
                $arr['result']['data'][$b.'BigSmall']     = $this->judgeDX($data['hm'.($a+1)],2);
            }
            $qishu = substr($data['qihao'],-2);
            if($qishu == 23){
                $nextqishu = date('Ymd', $this->time+43200)."01";
                $nextdate  = date("Y-m-d H:i:s", strtotime($data['addtime'])+13*3600);
            }else{
                $nextqishu = $data['qihao']+1;
                $nextdate  = date("Y-m-d H:i:s", strtotime($data['addtime'])+30*60);
            }
            $arr['result']['data']['preDrawCode'] = implode(",",$opencode);
            $arr['result']['data']['preDrawTime'] = $data['addtime'];
            $arr['result']['data']['preDrawIssue'] = $data['qihao'];
            $arr['result']['data']['dragonTiger'] = $data["hm1"]>$data["hm3"] ? 0 : 1;
            $arr['result']['data']['drawCount'] = intval($qishu);
            $arr['result']['data']['drawIssue'] = $nextqishu;
            $arr['result']['data']['drawTime'] = $nextdate;
            $arr['result']['data']['serverTime'] = $this->timezone;
            //$arr['result']['data']['serverTime'] = $data['addtime'];
            $arr['result']['data']['sumNum'] = array_sum($opencode);
            $arr['result']['data']['sumSingleDouble'] = array_sum($opencode)%2==0 ? 1 : 0;
            $arr['result']['data']['sumBigSmall'] = $int;
            $arr['result']['data']['frequency'] = "";
            $arr['result']['data']['groupCode'] = 2;
            $arr['result']['data']['id'] = 385524;
            $arr['result']['data']['index'] = 100;
            $arr['result']['data']['lotName'] = "上海时时乐";
            $arr['result']['data']['sdrawCount'] = "";
            $arr['result']['data']['shelves'] = 0;
            $arr['result']['data']['status'] = 0;
            $arr['result']['data']['totalCount']      = 23;
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
        $content = include '../cache/lot_shssl.php';
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
                if ($v[0] == "个位") {
                    $arr1['result']['data'][$k]["rank"] = 1;
                } elseif ($v[0] == "十位") {
                    $arr1['result']['data'][$k]["rank"] = 2;
                } elseif ($v[0] == "百位") {
                    $arr1['result']['data'][$k]["rank"] = 3;
                } elseif ($v[0] == "和值") {
                    $arr1['result']['data'][$k]["rank"] = 4;
                }
                if ($v[1] == "单") {
                    $arr1['result']['data'][$k]["state"] = 1;
                } elseif ($v[1] == "双") {
                    $arr1['result']['data'][$k]["state"] = 2;
                } elseif ($v[1] == "大") {
                    $arr1['result']['data'][$k]["state"] = 3;
                } elseif ($v[1] == "小") {
                    $arr1['result']['data'][$k]["state"] = 4;
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
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        $where["addtime"] = array("like","%".$date."%");
        $data = Db1_lottery_k_ssl::where($where)->order('qihao', 'desc')->select();
        if($data){
            $arr1 = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val) {
                $opencode = array($val["hm1"],$val["hm2"],$val["hm3"]);
                $int = array_sum($opencode)>14 ? 0 : 1;
                $arr['result']['data'][$key]['preDrawCode'] = implode(",", $opencode);
                $arr['result']['data'][$key]['preDrawTime'] = $val['addtime'];
                $arr['result']['data'][$key]['preDrawIssue'] = $val["qihao"];
                $arr['result']['data'][$key]['sumNum'] = array_sum($opencode);
                $arr['result']['data'][$key]['sumSingleDouble'] =  array_sum($opencode)%2==0 ? 1 : 0;
                $arr['result']['data'][$key]['sumBigSmall'] = $int;
                $arr1 = array("first","second","third");
                foreach($arr1 as $a=>$b){
                    $arr['result']['data'][$key][$b.'BigSmall']     = $this->judgeDX($val["hm".($a+1)],2);
                    $arr['result']['data'][$key][$b.'SingleDouble'] = $val["hm".($a+1)]%2==0 ? 1 : 0;
                }
                $arr['result']['data'][$key]['groupCode'] = 2;
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
        $date = $this->datezone;
        //$where["addtime"] = array("like","%2018-04-02%");
        $where["addtime"] = array("like","%".$date."%");
        $data = Db1_lottery_k_ssl::where($where)->order('qihao', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1  = array();
            $arr2  = array();
            $arr3  = array();
            $arr4  = array();
            $dxarr = array();
            $dsarr = array();
            $demo  = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                $opencode[] = array($val["hm1"],$val["hm2"],$val["hm3"]);
                for($i=1; $i<4; $i++){
                    $arr1[$i][] = $demo[] = $val["hm".$i];
                }
            }
            foreach($opencode as $k=>$v){
                if(array_sum($v)>14){
                    $dxarr[] = "大";
                }elseif(array_sum($v)<15){
                    $dxarr[] = "小";
                }
                if(array_sum($v)%2 == 0){
                    $dsarr[] = "双";
                }else{
                    $dsarr[] = "单";
                }
            }
            for($i=1; $i<4; $i++){
                $arr2[$i]['ds'] = array_count_values($this->judgeDS($arr1[$i]));
                $arr2[$i]['dx'] = array_count_values($this->judgeDX($arr1[$i],3));
            }
            $arr['result']['data']['sumSingle']    = isset(array_count_values($dsarr)['单']) ? array_count_values($dsarr)['单'] : 0;
            $arr['result']['data']['sumDouble']    = isset(array_count_values($dsarr)['双']) ? array_count_values($dsarr)['双'] : 0;
            $arr['result']['data']['sumBig']       = isset(array_count_values($dxarr)['大']) ? array_count_values($dxarr)['大'] : 0;
            $arr['result']['data']['sumSmall']     = isset(array_count_values($dxarr)['小']) ? array_count_values($dxarr)['小'] : 0;
            $arr3 = array("first","second","third");
            foreach($arr3 as $a=>$b){
                $arr['result']['data'][$b.'Single']  = isset($arr2[$a+1]['ds']['单']) ? $arr2[$a+1]['ds']['单'] : 0;
                $arr['result']['data'][$b.'Double']  = isset($arr2[$a+1]['ds']['双']) ? $arr2[$a+1]['ds']['双'] : 0;
                $arr['result']['data'][$b.'Big']     = isset($arr2[$a+1]['dx']['大']) ? $arr2[$a+1]['dx']['大'] : 0;
                $arr['result']['data'][$b.'Small']   = isset($arr2[$a+1]['dx']['小']) ? $arr2[$a+1]['dx']['小'] : 0;
            }
            $numArr = array_count_values($demo);
            $arr4   = array("Zero","One","Two","Three","Four","Five","Six","Seven","Eight","Nine");
            foreach($arr4 as $c=>$d){
                $arr['result']['data']['num'.$d] = isset($numArr[$c]) ? $numArr[$c] : 0;
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
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        $where["addtime"] = array("like","%".$date."%");
        $data = Db1_lottery_k_ssl::where($where)->order('qihao', 'asc')->select();
        $arr  = array();
        if($data){
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            $arr1 = array();
            $arr2 = array();
            $arr3 = array();
            foreach($data as $key=>$val) {
                $arr1['dx'][] = ($val["hm1"]+$val["hm2"]+$val["hm3"])>14 ? 1 : 0;
                $arr1['ds'][] = ($val["hm1"]+$val["hm2"]+$val["hm3"])%2==0 ? 0 : 1;
            }
            $dan        = isset(array_count_values($arr1['ds'])[1]) ? array_count_values($arr1['ds'])[1] : 0;       //单
            $Shuang     = isset(array_count_values($arr1['ds'])[0]) ? array_count_values($arr1['ds'])[0] : 0;       //双
            $arr2['ds'] = array($dan,$Shuang,0);
            $Da         = isset(array_count_values($arr1['dx'])[1]) ? array_count_values($arr1['dx'])[1] : 0;       //大
            $Xiao       = isset(array_count_values($arr1['dx'])[0]) ? array_count_values($arr1['dx'])[0] : 0;     //小
            $arr2['dx'] = array($Da,$Xiao);
            $arr3 = array(
                array(1,$arr1['ds'],$arr2['ds']),
                array(2,$arr1['dx'],$arr2['dx'])
            );
            foreach($arr3 as $a=>$b){
                $arr['result']['data'][$a]["date"]      = date("Y-m-d",strtotime($val['addtime']));
                $arr['result']['data'][$a]["rank"]      = 6;
                $arr['result']['data'][$a]["state"]     = $b[0];
                $arr['result']['data'][$a]["roadBeads"] = $b[1];
                $arr['result']['data'][$a]["totals"]    = $b[2];
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
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        $where["addtime"] = array("like","%".$date."%");
        $data = Db1_lottery_k_ssl::where($where)->order('qihao', 'asc')->select();
        $arr  = array();
        if($data){
            $yilou  = array();
            $yilou1 = array();
            for($i = 0; $i < 30; $i++){
                $yilou1[$i][] = $yilou[$i][] = 0;
            }
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            $arr1  = array();
            $arr2  = array();
            $arr3  = array();
            foreach($data as $key=>$val){
                for($k = 1; $k <4; $k++){
                    $code = $val['hm'.$k];
                    $index = ($k-1)*10;
                    for($ii = 0; $ii < 10; $ii++){
                        if($code == $ii){
                            $yilou[$index+$ii] = $code;
                        } else {
                            if ($yilou[$index+$ii]  > 0) {
                                $yilou[$index+$ii]  = -1;
                            } else {
                                $yilou[$index+$ii] --;
                            }
                        }
                    }
                }
                $arr['result']['data'][0]['bodyList'][$key]['code']  = implode(",",array($val['hm1'],$val['hm2'],$val['hm3']));
                $arr['result']['data'][0]['bodyList'][$key]['issue'] = $val['qihao'];
                $arr['result']['data'][0]['bodyList'][$key]['array'] = $yilou; //遗漏号码
                for($k = 1; $k < 4; $k++){
                    $code  = $val['hm'.$k]+1;
                    $index = ($k-1)*10;
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
                for($b=0; $b<30; $b++){
                    if($yilou1[$b]>-1){
                        $arr1[$b][] = $yilou1[$b];
                        $arr2[$b][] = 0;
                    }else{
                        $arr1[$b][] = "";
                        $arr2[$b][] = $yilou1[$b];
                    }

                }
            }
            ksort($arr1);
            ksort($arr2);
            $cxcs = array();
            $zdyl = array();
            $dqyl = array();
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
        $single = Db1_lottery_k_ssl::order('qihao', 'desc')->find();
        $end    = $single["addtime"];
        $time   = substr($single["addtime"],0,10);
        $start  = $this->takeOneMonth($time);
        $where['addtime'] = array('between',"$start,$end");
        $data = Db1_lottery_k_ssl::where($where)->field("addtime,hm1,hm2,hm3")->order('qihao', 'desc')->select();
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
                $riqi[] = substr($val["addtime"],0,10);
            }
            $riqi = array_unique($riqi);
            foreach($data as $k=>$v){
                foreach($riqi as $key=>$val){
                    if(substr($v["addtime"],0,10) == $val){
                        for($i=1; $i<4; $i++){
                            $arr1[$val][$i]['dx'][]  = $v["hm".$i]>4 ? 1 : 2;
                            $arr1[$val][$i]['ds'][]  = $v["hm".$i]%2==0 ? 2 : 1;
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
    public function judgeDX($arr,$num){
        $arr1 = array();
        $int  = 0;
        if($num == 1){
            $dx = array(1,2,3,4,5,6);
        }elseif($num == 2){
            $dx = array(0,1,2,3,4);
        }elseif($num == 3){
            $dx = array(1,2,3,4,5);
        }

        if(is_array($arr)){
            foreach($arr as $k=>$v) {
                if (in_array($v, $dx)) {
                    $arr1[] = "小";
                } else {
                    $arr1[] = "大";
                }
            }
            return $arr1;
        }else{
            if (in_array($arr, $dx)) {
                $int = 1;
            } else {
                $int = 0;
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
    public function judgeDS($arr){
        $arr1 = array();
        $int  = 0;
        $ds   = array(1,3,5,7,9,11,13);
        if(is_array($arr)) {
            foreach ($arr as $v) {
                if($v%2 == 0){
                    $arr1[] = "单";
                } else {
                    $arr1[] = "双";
                }
            }
            return $arr1;
        }else{
            if (in_array($arr, $ds)) {
                $int = 1;
            } else {
                $int = 0;
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
        }elseif($str=="双" || $str=="小" || $str=="虎"){
            $num = 1;
        }elseif($str=="和"){
            $num = 2;
        }
        return $num;
    }
}