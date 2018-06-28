<?php
include_once __DIR__ . '/../../include/config.php';
include_once __DIR__ . '/../../database/mysql.config.php';
include_once __DIR__ . '/../common/login_check.php';
check_quanxian('cwgl');
$type = empty($_GET["type"])?"-1":$_GET["type"];
if($type == '7') $type = '0';
$time =  empty($_GET["time"])?"CN":$_GET["time"];
if(empty($_GET['bdate']) || empty($_GET['bhour']) || empty($_GET['bsecond'])){
    $btime = date('Y-m-d 00:00:00',time()+12*3600);
}else{
    $btime = $_GET['bdate'].' '.$_GET['bhour'].':'.$_GET['bsecond'].':00';
}

if(empty($_GET['edate']) || empty($_GET['ehour']) || empty($_GET['esecond'])){
    $etime = date('Y-m-d 23:59:59', time()+12*3600);
}else{
    $etime = $_GET['edate'].' '.$_GET['ehour'].':'.$_GET['esecond'] . ':59';
}

if ($_GET['act'] == 'list') {
    $time = $_GET['time'];
    if (!isset($_GET['bdate'])) {
        $btime = strtotime(date('Y-m-d 00:00:00', time()));
    } else {
        $btime = strtotime($_GET['bdate']);
    }
    if (!isset($_GET['edate'])) {
        $etime = strtotime(date('Y-m-d 23:59:59', time()));
    } else {
        $etime = strtotime($_GET['edate']);
    }
    $type = $_GET['type'];
    $username = $_GET['username'];
    $sqlwhere = ' 1=1 ';
    $where = '';
    $params = array();
    if ($username != '') {
        $stmt = $mydata1_db->prepare("select uid from k_user where username=:username limit 1");
        $stmt->execute([':username'=>$username]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $uid = (int)$res['uid'];
        $where = ' and uid='.$uid;
    }

    if ($type != '' && $type != "-1") {
        $params[':type'] = $type;
        $sqlwhere .= ' and `type`=:type';
    }
    if ($time == 'CN') {
        $btime -= (12 * 3600);
        $etime -= (12 * 3600);
    }
    $params[':btime1'] = $params[':btime2'] = date('Y-m-d H:i:s',$btime);
    $params[':etime1'] = $params[':etime2'] = date('Y-m-d H:i:s',$etime);
    $sql1 = "select id,uid,money,lsh,`adddate` as `time`,assets,balance,'0' as `type`,bank as about from huikuan where `adddate`>=:btime1 and `adddate`<=:etime1 and `status`=1".$where;

    $sql2 = "select m_id as id,uid, m_value as money,m_order as lsh,m_make_time as `time`,assets,balance,`type`,about from k_money where `m_make_time`>=:btime2 and `m_make_time`<=:etime2 and `status`=1".$where;

    $sql = $sql1 . " union all " . $sql2;

    $page = (int)$_GET['page'];
    $size = (int)$_GET['size'];
    $page < 1 && $page = 1;
    $size < 10 && $size = 10;
    $start = ($page - 1) * $size;
    $stmt = $mydata1_db->prepare("select count(1) from (".$sql.") a where " . $sqlwhere );
    $stmt->execute($params);
    $count = $stmt->fetch()[0];
    //echo $count;exit;
    $stmt = $mydata1_db->prepare('select `type`,sum(`money`) as `money` from ('.$sql.') a where ' . $sqlwhere .' group by `type`');
    $stmt->execute($params);
    $res = $stmt->fetchAll();
    $countArr = [];
    foreach($res as $v) $countArr[$v[0]] = $v[1];
    
    $sql = 'select a.*,u.username from ('.$sql.') a left join k_user u on a.uid=u.uid where ' . $sqlwhere . ' order by `time` desc limit ' . $start . ',' . $size;
    $stmt = $mydata1_db->prepare($sql);
    $stmt->execute($params);
    $dataList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $list = [];
    foreach ($dataList as $row) {
        switch ($row['type']) {
            case 0:
                $row['typename'] = '<span class="yellow">汇款</span>';
                break;
            case 1:
                $row['typename'] = '<span class="green">存款</span>';
                break;
            case 2:
                $row['typename'] = '<span class="red">取款</span>';
				$row['about'] = $row['lsh'];
                break;
            case 3:
                $row['typename'] = '人工汇款';
                break;
            case 4:
                $row['typename'] = '彩金派送';
                break;
            case 5:
                $row['typename'] = '反水派送';
                break;
            case 6:
                $row['typename'] = '其他情况';
                break;
        }
        $row['time'] = $time == 'CN' ? date('Y-m-d H:i:s', strtotime($row['time']) + 12 * 3600) : $row['time'];
        $row['url'] = $row['type'] == 0 ? 'cwgl/hk_look.php?id=' . $row['id'] : 'cwgl/tixian_show.php?id=' . $row['id'];
        if($row['type'] == '0'){
            $row['url'] = 'cwgl/hk_look.php?id=' . $row['id'];
            $bank = explode('<br/>',$row['about']);
            $row['bank']['name'] = (string)$bank[0];
            $row['bank']['code'] = (string)$bank[1];
            unset($row['about']);
        }else{
            $row['url'] = 'cwgl/tixian_show.php?id=' . $row['id'];
        }
        $list[] = $row;
    }

    $data['list'] = $list;
    $data['total'] = $count;
    $data['count'] = (int)($count / $size);
    if ($count % $size != 0) {
        $data['count'] += 1;
    }
    $data['moneyCount'] = $countArr;
    die(json_encode($data));
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize@0.4.0/modern-normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.2.2/lib/theme-chalk/index.min.css">
    <style>
        body{padding:8px;margin:0;font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;} 
        .green{color: #006600;}
        .yellow{color: #F37605;}
        .red{color: #ff0000;}
        .gray{color:#999999;}
		.btn{cursor: pointer;}
        .el-form-item__label,.el-select-dropdown__item {font-size: 12px;}
        .el-popper[x-placement^=bottom] .popper__arrow{
            display: none !important;
        }
        .el-select-dropdown__item{height: 30px;line-height: 30px;}
    </style>
</head>
<body>
<div id="app">
    <el-form :inline="true" :model="form" size="mini" class="demo-form-inline">
        <el-form-item>
            <el-select style="width: 95px" v-model="form.time">
                <el-option v-for="item in option.time" :key="item.value" :label="item.label" :value="item.value"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="类型">
            <el-select style="width: 95px" v-model="form.type">
                <el-option v-for="item in option.type" :key="item.value" :label="item.label" :value="item.value"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="会员名称">
            <el-input v-model="form.username" placeholder="会员名称"></el-input>
        </el-form-item>
        <el-form-item label="开始日期">
            <el-date-picker value-format="yyyy-MM-dd HH:mm:ss" style="width: 177px;" :clearable="false" v-model="form.bdate" type="datetime" :editable="false" placeholder="选择日期时间"></el-date-picker>
        </el-form-item>
        <el-form-item label="结束日期">
            <el-date-picker value-format="yyyy-MM-dd HH:mm:ss" style="width: 177px;" :clearable="false" v-model="form.edate" type="datetime" :editable="false" placeholder="选择日期时间"></el-date-picker>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" icon="search" @click="find()" v-text="'查找'"></el-button>
        </el-form-item>
    </el-form>
    <template>
        <el-table :row-style="rowStyle" :resizable="true" v-loading.body="loading" size="mini" :data="tableData" border style="width: 100%">
            <el-table-column type="index" align="center" label="编号" width="50">
            </el-table-column>
            <el-table-column align="center" prop="username" label="用户名" width="180">
                <template slot-scope="scope">
                    <!--el-button class="red" type="text" size="mini" v-text="scope.row.username" @click="checkUser(scope.row.username)"></el-button-->
					<a class="btn" v-text="scope.row.username" @click="checkUser(scope.row.username)"></a>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="typename" label="类型" width="80">
                <template slot-scope="scope">
                    <div v-html="scope.row.typename"></div>
                </template>
            </el-table-column>
            <el-table-column :show-overflow-tooltip="true" align="center" width="250" prop="lsh" label="订单明细">
                <template slot-scope="scope">
                    <el-tooltip class="item" :content="scope.row.lsh" placement="top" effect="light">
                        <a class="btn" @click="showDetail(scope.row.type,scope.row.id)">
                        <span v-if="scope.row.type != 0" v-text="scope.row.about"></span>
                        <span v-else >[管理员结算]</span>
                        </a>
                    </el-tooltip>                    
                </template>
            </el-table-column>
            <el-table-column min-width="150" align="center" prop="about" label="汇款银行">
                <template slot-scope="scope">
                    <el-tooltip v-if="scope.row.type == 0" :disabled="scope.row.bank.code == ''" class="item" :content="scope.row.bank.code" placement="top" effect="light">
                        <span style="display:block;" v-text="scope.row.bank.name"></span>
                    </el-tooltip>
                    <a class="yellow btn" @click="showAllBank(scope.row.username)">历史银行卡信息</a>
                </template>
            </el-table-column>
            <el-table-column align="center" width="100" label="存取前金额">
                <template slot-scope="scope">
                    <span style="color:#999;" v-text="scope.row.assets.toFixed(2)"></span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="money" width="100" label="存取金额">
                <template slot-scope="scope">
                    <span class="red" v-text="scope.row.money.toFixed(2)"></span>
                </template>
            </el-table-column>
            <el-table-column align="center" width="100" label="存取后金额">
                <template slot-scope="scope">
                    <span style="color:#999;" v-text="scope.row.balance.toFixed(2)"></span>
                </template>
            </el-table-column>
            <el-table-column width="150" align="center" prop="time" label="提交时间">
            </el-table-column>
            <table slot="append" id="countList" width="100%" v-show="showCount" cellspacing="0" cellpadding="0" border="0" >
                <tr style="background-color:#D8DCE5;text-align:center">
                    <td>汇款：<span v-text="getMoneyCount(0)"></span></td>
                    <td>存款：<span v-text="getMoneyCount(1)"></span></td>
                    <td>取款：<span v-text="getMoneyCount(2)"></span></td>
                    <td>人工汇款：<span v-text="getMoneyCount(3)"></span></td>
                    <td>彩金派送：<span v-text="getMoneyCount(4)"></span></td>
                    <td>反水派送：<span v-text="getMoneyCount(5)"></span></td>
                    <td>其他情况：<span v-text="getMoneyCount(6)"></span></td>
                </tr>
            </table>
        </el-table>
    </template>
    <el-pagination style="margin-top:10px;" @size-change="SizeChange" @current-change="CurrentChange"
                   :current-page="currentPage" :page-sizes="[15, 30, 50, 200, 500, 1000, 3000, 5000]" :page-size="pageSize"
                   layout="total, sizes, prev, pager, next, jumper" :total="total">
    </el-pagination>
    <br><br><br>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.cookie@1.4.1/jquery.cookie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/element-ui@2.2.2/lib/index.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/sentsin/layer@3.1.1/dist/layer.js"></script>
<script>
    new Vue({
        data: {
            currentPage: 1,
            total: 0,
            pageSize: 15,
            loading: true,
            showCount: false,
            form: { time: 'CN', type: '-1', username: '', bdate: '', edate: '' },
            moneyCount :[],
            tableData: [],
            option: {
                time: [{value: 'CN', label: '中国时间'}, {value: 'EN', label: '美东时间'}],
                type: [
                    {value: '-1', label: '全部'}, 
                    {value: '0', label: '汇款'}, 
                    {value: '1', label: '存款'}, 
                    {value: '2', label: '取款'}, 
                    {value: '3', label: '人工汇款'}, 
                    {value: '4', label: '彩金派送'}, 
                    {value: '5', label: '反水派送'}, 
                    {value: '6', label: '其他情况'}
                ]
            }
        },
        methods: {
            loadData() {
                _self = this;
                this.loading = true;
                this.showCount = false;
                url = "?act=list&username=" + this.form.username + "&time=" + this.form.time + "&type=" + this.form.type + "&bdate=" + this.form.bdate + "&edate=" + this.form.edate + "&page=" + this.currentPage + "&size=" + this.pageSize;
                $.getJSON(url, function (res) {
                    _self.tableData = res.list;
                    _self.total = res.total;
                    _self.moneyCount = res.moneyCount;
                    if(_self.tableData.length>0) _self.showCount = true;
                    _self.loading = false;
                });
            },
            rowStyle({row, rowIndex}){
                return "";
                switch(row.type){
                    case "0":
                        return "background-color:rgba(73, 220, 0, 0.1);";
                        break;
                    case "1":
                        return "background-color:rgba(73, 220, 0, 0.1);";
                        break;
                    case "2":
                        return "background-color:rgba(239, 0, 0, 0.1);";
                        break;
                }
            },
            getMoneyCount(val){
                var money = this.moneyCount[val];
                if(typeof(money)=="undefined") return "0.00";
                return money.toFixed(2);
            },
            SizeChange(val) {
                $.cookie('hccw_page_size',val);
                this.currentPage = 1;
                this.pageSize = val;
                this.loadData();
            },
            CurrentChange(val) {
                this.currentPage = val;
                this.loadData();
            },
            find() {
                this.currentPage = 1;
                this.loadData();
            },
            showAllBank(name){
                var url = '../hygl/lsyhxx.php?isAlert=true&action=1&username='+name;
                layer.open({
                    type:2,
                    title: false,
                    shadeClose: true,
                    area: ['700px', '300px'],
                    content:url,
                });
            },
            showDetail(type,id){
                var url = '../cwgl/tixian_show.php?isAlert=true&id='+id;
                if(type==0) url = '../cwgl/hk_look.php?isAlert=true&id='+id;
                layer.open({
                    type:2,
                    title: false,
                    shadeClose: true,
                    area: ['650px', '500px'],
                    content:url,
                });
            },
            checkUser(name){
                var url = '../bbgl/report_day.php?username=' + name;
                layer.open({
                    type:2,
                    title: false,
                    shadeClose: true,
                    area: ['90%', '90%'],
                    content:url,
                });
            }
        },
        created: function () {
            this.form.type = '<?=$type?>';
            this.form.time = '<?=$time?>';
            this.form.bdate = '<?=$btime?>';
            this.form.edate = '<?=$etime?>';
            this.form.username = "<?=$_GET['username']?>";
            this.pageSize = 50;
            if($.cookie('hccw_page_size')){
                this.pageSize = Number($.cookie('hccw_page_size'));
            }
            this.loadData();
        }
    }).$mount('#app');
</script>
</html>