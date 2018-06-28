<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/6/6
 * Time: 18:36
 */

namespace app\kaijian\controller;

use app\common\model\Db1_lottery_k3;
class K3lottery extends Common{
    /**
     * kjjg    开奖结果
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     */
    public function kjjg(){
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : "shk3";
        $data = Db1_lottery_k3::where('name', $type)->order('qihao', 'desc')->find();
        $arr  = array();
        if ($data) {
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            $sumNum = intval(substr($data['balls'],4,1))+intval(substr($data['balls'],0,1))+intval(substr($data['balls'],2,1));
            if($type == "shk3"){
                $arr['result']['data']['lotName']    = "上海快3";
                $arr['result']['data']['lotCode']    = 10061;
                $arr['result']['data']['totalCount'] = 82;
                $num     = 82;
                $addtime = 10*3600+1800;
            }elseif($type == "jxk3"){
                $arr['result']['data']['lotName']    = "江西快3";
                $arr['result']['data']['lotCode']    = 10062;
                $arr['result']['data']['totalCount'] = 84;
                $num     = 84;
                $addtime = 10*3600+600;
            }elseif($type == "gsk3"){
                $arr['result']['data']['lotName']    = "甘肃快3";
                $arr['result']['data']['lotCode']    = 10063;
                $arr['result']['data']['totalCount'] = 72;
                $num     = 72;
                $addtime = 12*3600+600;
            }elseif($type == "gzk3"){
                $arr['result']['data']['lotName']    = "贵州快3";
                $arr['result']['data']['lotCode']    = 10066;
                $arr['result']['data']['totalCount'] = 78;
                $num     = 78;
                $addtime = 11*3600;
            }
            $qishu = substr($data['qihao'],-3);
            if($qishu == $num){
                $nextqishu = date('Ymd', $this->time+43200)."01";
                $nextdate  = date("Y-m-d H:i:s", strtotime($data['kaipan'])+$addtime);
            }else{
                $nextqishu = $data['qihao']+1;
                $nextdate  = date("Y-m-d H:i:s", strtotime($data['kaipan'])+600);
            }
            $arr['result']['data']['drawCount']  = intval($qishu);
            $arr['result']['data']['drawIssue']  = $nextqishu;
            $arr['result']['data']['drawTime']  = $nextdate;
            $arr['result']['data']['preDrawCode']  = $data['balls'];
            $arr['result']['data']['preDrawIssue']  = $data['qihao'];
            $arr['result']['data']['preDrawTime']  = $data['kaipan'];
            $arr['result']['data']['serverTime']  = $this->timezone;
            //$arr['result']['data']['serverTime']  = $data['kaipan'];
            $arr['result']['data']['firstSeafood']  = intval(substr($data['balls'],0,1));
            $arr['result']['data']['secondSeafood']  = intval(substr($data['balls'],2,1));
            $arr['result']['data']['thirdSeafood']  = intval(substr($data['balls'],4,1));
            $arr['result']['data']['sumNum']  = $sumNum;
            $arr['result']['data']['sumBigSmall']  = $this->judgeDX($sumNum);
            $arr['result']['data']['sumSingleDouble']  = $this->judgeDS($sumNum);
            $arr['result']['data']['shelves']  = 0;
            $arr['result']['data']['index']  = 100;
            $arr['result']['data']['frequency']  = "";
            $arr['result']['message']  = "操作成功";
            return $arr;
        } else {
            $arr['errorCode']         = 1;
            $arr['message']           = "操作失败";
            $arr['result']['message'] = "操作失败";
            return $arr;
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
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : "shk3";
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        //$where['kaipan'] = array('like',"%2018-06-15%");
        $where['kaipan'] = array('like',"%".$date."%");
        $where['name']   = $type;
        $data = Db1_lottery_k3::where($where)->order('qihao', 'desc')->select();
        $arr  = array();
        if($data){
            $arr1 = array();
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            foreach($data as $key=>$val){
                $num1 = intval(substr($val["balls"],0,1));
                $num2 = intval(substr($val["balls"],2,1));
                $num3 = intval(substr($val["balls"],4,1));
                if($num1==$num2 && $num2==$num3){
                    $arr1['dx'] = 2;
                }else{
                    $arr1['dx'] = $num1+$num2+$num3;
                }
                $arr['result']['data'][$key]['preDrawCode'] = $val['balls'];
                $arr['result']['data'][$key]['preDrawIssue'] = $val["qihao"];
                $arr['result']['data'][$key]['preDrawTime'] = $val["kaipan"];
                $arr['result']['data'][$key]['firstSeafood'] = intval(substr($val['balls'],0,1));
                $arr['result']['data'][$key]['secondSeafood'] = intval(substr($val['balls'],2,1));
                $arr['result']['data'][$key]['thirdSeafood'] = intval(substr($val['balls'],4,1));
                $arr['result']['data'][$key]['sumNum'] = $num1+$num2+$num3;
                $arr['result']['data'][$key]['sumSingleDouble'] = ($num1+$num2+$num3)%2==0 ? 1 : 0;
                $arr['result']['data'][$key]['sumBigSmall'] = $this->judgeDX($arr1['dx']);
                $arr['result']['data'][$key]['groupCode'] = 3;
            };
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
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : 'shk3';
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        $where["kaipan"] = array("like","%".$date."%");
        $where['name']   = $type;
        $data   = Db1_lottery_k3::where($where)->order('qihao', 'asc')->select();
        $arr  = array();
        if($data){
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            $arr1 = array();
            $arr2 = array();
            $arr3 = array();
            foreach($data as $key=>$val) {
                $num1 = intval(substr($val["balls"],0,1));
                $num2 = intval(substr($val["balls"],2,1));
                $num3 = intval(substr($val["balls"],4,1));
                if($num1==$num2 && $num2==$num3){
                    $arr1['dx'][] = 2;
                }else{
                    $arr1['dx'][] = $this->judgeDX($num1+$num2+$num3);
                }
                $arr1['ds'][] = ($num1+$num2+$num3)%2==0 ? 1 : 0;
                $arr1['sum'][] = $num1+$num2+$num3;
            }
            $Shuang     = isset(array_count_values($arr1['ds'])[1]) ? array_count_values($arr1['ds'])[1] : 0;       //双
            $dan        = isset(array_count_values($arr1['ds'])[0]) ? array_count_values($arr1['ds'])[0] : 0;       //和
            $arr2['ds'] = array($dan,$Shuang,0);
            $Da         = isset(array_count_values($arr1['dx'])[0]) ? array_count_values($arr1['dx'])[0] : 0;       //大
            $Xiao       = isset(array_count_values($arr1['dx'])[1]) ? array_count_values($arr1['dx'])[1] : 0;     //小
            $He         = isset(array_count_values($arr1['dx'])[2]) ? array_count_values($arr1['dx'])[2] : 0;       //和
            $arr2['dx'] = array($Da,$Xiao,$He);
            $arr3 = array(
                array(1,$arr1['ds'],$arr2['ds']),
                array(2,$arr1['dx'],$arr2['dx'])
            );
            foreach($arr3 as $a=>$b){
                $arr['result']['data'][$a]["date"]      = date("Y-m-d",strtotime($val['kaipan']));
                $arr['result']['data'][$a]["rank"]      = 0;
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
        $type = isset($_GET['name'])&&!empty($_GET['name']) ? $_GET['name'] : 'shk3';
        $date = isset($_GET['date'])&&!empty($_GET['date']) ? $_GET['date'] : $this->datezone;
        $date = explode("-",$date);
        $date = $date[0]."-".substr("00".$date[1],-2)."-".substr("00".$date[2],-2);
        //$date = "2018-06-15";
        $where["kaipan"] = array("like","%".$date."%");
        $where['name']   = $type;
        $data   = Db1_lottery_k3::where($where)->order('qihao', 'asc')->select();
        $arr  = array();
        if($data){
            $yilou = [];
            for($i = 0; $i < 3; $i++){
                for($j=0; $j<10; $j++){
                    $yilou[$i][]=0;
                }
            }
            $arr['errorCode'] = 0;
            $arr['message']   = "操作成功";
            $arr['result']['businessCode'] = 0;
            $arr1  = array();
            $arr2  = array();
            $arr3  = array();
            $arr4  = array();
            $arr5  = array();
            foreach($data as $key=>$val){
                for($k = 0; $k <3; $k++){
                    $code = intval(substr($val['balls'],$k*2,1));
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
                $arr['result']['data']['bodyList'][$key]['drawCode'] = explode(",",$val["balls"]);
                $arr['result']['data']['bodyList'][$key]['preIssue'] = $val['qihao'];
                $arr['result']['data']['bodyList'][$key]['oneCode']  = $yilou[0]; //遗漏号码
                $arr['result']['data']['bodyList'][$key]['twoCode']  = $yilou[1]; //遗漏号码
                $arr['result']['data']['bodyList'][$key]['threeCode']  = $yilou[2]; //遗漏号码
                $arr1 = $this->arrToOne($yilou);
                for($b=0; $b<30; $b++){
                    if($arr1[$b]>0){
                        $arr2[$b][] = $arr1[$b];
                        $arr3[$b][] = 0;
                    }else{
                        $arr2[$b][] = 0;
                        $arr3[$b][] = $arr1[$b];
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
            $codeArr = array("one","two","three");
            foreach($codeArr as $k=>$v){
                foreach($arr['result']['data']['bodyList'][0][$v."Code"] as $val){
                    if($val>0){
                        $arr5[$k+1][] = 0;
                    }else{
                        $arr5[$k+1][] = $val;
                    }
                }
            }
            for($m=1; $m<4; $m++){
                foreach($arr5[$m] as $k=>$v){
                    $dqyl[] = $v;
                }
            }
            $arr['result']['data']['basicTrendTitle']['appearCount'] = $cxcs;
            $arr['result']['data']['basicTrendTitle']['currentMissingValues'] = $dqyl;
            $arr['result']['data']['basicTrendTitle']['maxMissingValues'] = $zdyl;
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
     * judgeDX 判断大小
     *
     * @param $arr
     * @return array
     */
    public function judgeDX($arr){
        $int  = 0;
        $dx = array(4,5,6,7,8,9,10);
        $da = array(11,12,13,14,15,16,17);
        if(is_array($arr)){
            foreach($arr as $k=>$v) {
                if($v==2){
                    $int = 2;
                }else{
                    if (in_array($v, $dx)) {
                        $int = 0;
                    } elseif (in_array($v, $da)) {
                        $int = 1;
                    }
                }
            }
        }else{
            if($arr==2){
                $int = 2;
            }else{
                if (in_array($arr, $dx)) {
                    $int = 1;
                } else {
                    $int = 0;
                }
            }

        }
        return $int;
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
        if(is_array($arr)) {
            foreach ($arr as $k => $v) {
                if($v%2 == 1){
                    $arr1[] = "单";
                } else {
                    $arr1[] = "双";
                }
            }
            return $arr1;
        }else{
            if($arr%2 == 0){
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
        }elseif($str=="和"){
            $num = 2;
        }else{
            $num = 1;
        }
        return $num;
    }
}
 
 