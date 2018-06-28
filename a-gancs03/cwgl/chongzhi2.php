<?php
include_once __DIR__ . '/../../include/config.php';
include_once __DIR__ . '/../../database/mysql.config.php';
include_once __DIR__ . '/../common/login_check.php';
check_quanxian('cwgl');
        $params = array();
        $sqlwhere = '';
        if ($status != 3){
            $params[':status'] = $status;
            $sqlwhere .= ' and status=:status';
        }

        if ($money_type && ($money_type != -1)){
            $params[':money_type'] = '%' . $money_type . '%';
            $sqlwhere .= ' and money_type like :money_type';
        }
        
        if (trim($pay_mid)){
            $params[':pay_mid'] = $pay_mid;
            $sqlwhere .= ' and pay_mid=:pay_mid';
        }
        
        if ($username != ''){
            $params[':username'] = $username;
            $sqlwhere .= ' and uid=(select uid from k_user where username=:username)';
        }
        
        if ($time == 'CN'){
            $q_btime = date('Y-m-d H:i:s', strtotime($btime) - (12 * 3600));
            $q_etime = date('Y-m-d H:i:s', strtotime($etime) - (12 * 3600));
        }else{
            $q_btime = $btime;
            $q_etime = $etime;
        }
        
        $params[':q_btime'] = $q_btime;
        $params[':q_etime'] = $q_etime;
        $sql = 'select m_id from k_money where `type`=1 ' . $sqlwhere . ' and `m_make_time`>=:q_btime and `m_make_time`<=:q_etime';
        $stmt = $mydata1_db->prepare($sql);
        $stmt->execute($params);
        $sum = $stmt->rowCount();
        $thisPage = 1;
        
        if ($_GET['page']){
            $thisPage = $_GET['page'];
        }
        
        
        while ($row = $stmt->fetch()){
            if (($start <= $i) && ($i <= $end)){
                $mid .= intval($row['m_id']) . ',';
            }
            
            if ($end < $i){
                break;
            }
            $i++;
        }
        
        $sum = $true = $sxf_sum = $false = $cl = 0;
        if ($mid){
            $mid = rtrim($mid, ',');
            $arr = array();
            $sql = 'select k_money.*,k_user.username from k_money left outer join k_user on k_money.uid=k_user.uid where m_id in (' . $mid . ') order by ' . $order . ' desc';
            $query = $mydata1_db->query($sql);
            $rows = $query->fetch();
        }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://unpkg.com/jquery@3.2.1/dist/jquery.min.js"></script>
    <script src="/Public/js/jquery.cookie.js"></script>
    <script src="/Public/layer/layer.js"></script>
    <!-- 引入样式 -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui@2.0.0/lib/theme-chalk/index.css">
    <!-- 先引入 Vue -->
    <script src="https://unpkg.com/vue@2.5.2/dist/vue.js"></script>
    <!-- 引入组件库 -->
    <script src="https://unpkg.com/element-ui@2.0.0/lib/index.js"></script>
    <style> #app{ display:none;} body{padding:8px;margin:0;font-size: 12px;} </style>
</head>
<body>
<div id="app">
    <el-form size="mini" :inline="true" :model="form" class="demo-form-inline">
        <el-form-item>
            <el-select style="width: 95px" size="mini" v-model="form.time">
                <el-option v-for="item in option.time" :key="item.value" :label="item.label" :value="item.value">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="类型">
            <el-select style="width: 95px" size="mini" v-model="form.type">
                <el-option v-for="item in option.type" :key="item.value" :label="item.label" :value="item.value">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="开始日期">
            <el-date-picker style="width: 162px;" @change="setBdate" size="mini" v-model="bdate" type="datetime"  placeholder="选择日期时间">
            </el-date-picker>
        </el-form-item>
        <el-form-item label="结束日期">
            <el-date-picker style="width: 162px;" @change="setEdate" size="mini" v-model="edate" type="datetime" placeholder="选择日期时间">
            </el-date-picker>
        </el-form-item>
        <br>
        <el-form-item label="会员名称">
            <el-input size="mini" v-model="form.username" placeholder="会员名称"></el-input>
        </el-form-item>
        <el-form-item label="第三方支付">
            <el-input size="mini" v-model="form.username" placeholder="第三方支付"></el-input>
        </el-form-item>
        <el-form-item label="商户ID">
            <el-input size="mini" v-model="form.username" placeholder="商户ID"></el-input>
        </el-form-item>
        <el-form-item>
            <el-button size="mini" type="primary" @click="find()">查 询</el-button>
        </el-form-item>
    </el-form>
    <template>
        <el-table v-loading.body="loading" element-loading-text="拼命加载中" size="mini" :stripe="true" :data="tableData" border style="width: 100%">
            <el-table-column type="index" align="center" label="编号" width="50">
            </el-table-column>
            <el-table-column align="center" prop="username" label="系统订单号" width="">
                <template scope="scope">
                    <span @click="checkUser(scope.row.username)" v-text="scope.row.username" style="cursor:pointer;"></span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="typename" label="存款金额" width="">
                <template scope="scope">
                    <div v-html="scope.row.typename"></div>
                </template>
            </el-table-column>
            <el-table-column align="center" min-width="" prop="lsh" label="手续费">
                <template scope="scope">
                    <div @click="showDetail(scope.row.type,scope.row.id)" v-text="scope.row.lsh" style="color:#F37605;cursor:pointer;"></div>
                    <span v-if="scope.row.type != 0" style="color:red;" v-text="scope.row.about"></span>
                </template>
            </el-table-column>
            <el-table-column min-width="" align="center" prop="about" label="查看财务">
                <template scope="scope">
                    <div v-if="scope.row.type == 0" v-html="scope.row.about"></div>
                    <span style="color:#F37605;cursor:pointer;" @click="showAllBank(scope.row.username)">历史银行卡信息</span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="money" min-width="180" label="申请时间">
                <template scope="scope">
                    <span style="width:33%;float:left;text-align:left;color:#999;" v-text="scope.row.assets.toFixed(2)"></span>
                    <span style="width:34%;display:inline-block;color:red;" v-text="scope.row.money.toFixed(2)"></span>
                    <span style="width:33%;float:right;text-align:right;color:#999;" v-text="scope.row.balance.toFixed(2)"></span>
                </template>
            </el-table-column>
            <el-table-column width="" align="center" prop="time" label="第三方">
            </el-table-column>
            <el-table-column width="" align="center" prop="time" label="商户ID">
            </el-table-column>
            <el-table-column width="" align="center" prop="time" label="操作">
            </el-table-column>
            <div slot="append" id="countList" v-show="showCount">
                <table  cellspacing="0" cellpadding="0" border="0" class="el-table__footer">
                <tr style="background-color:#FBFDFF;text-align:center">
                    <td>
                        汇款：<span v-text="getMoneyCount(0)"></span> 
                    </td>
                    <td>
                        存款：<span v-text="getMoneyCount(1)"></span>
                    </td>
                    <td>
                        取款：<span v-text="getMoneyCount(2)"></span> 
                    </td>
                    <td>
                        人工汇款：<span v-text="getMoneyCount(3)"></span> 
                    </td>
                    <td>
                        彩金派送：<span v-text="getMoneyCount(4)"></span>
                    </td>
                    <td>
                        反水派送：<span v-text="getMoneyCount(5)"></span> 
                    </td>
                    <td>
                        其他情况：<span v-text="getMoneyCount(6)"></span>
                    </td>
                </tr>
                </table>
            </div>
        </el-table>
    </template>
    <el-pagination style="margin-top:10px;" @size-change="handleSizeChange" @current-change="handleCurrentChange"
                   :current-page="currentPage" :page-sizes="[15, 30, 50, 200, 500, 1000, 3000, 5000]" :page-size="pageSize"
                   layout="total, sizes, prev, pager, next, jumper" :total="total">
    </el-pagination>
    <br><br><br>
</div>
</body>
<script>
    new Vue({
        data: {
            currentPage: 1,
            total: 0,
            pageSize: 15,
            loading: true,
            bdate: '',
            edate: '',
            width: 0,
            showCount: false,
            form: {
                time: 'CN',
                type: '2',
                username: '',
                bdate: '',
                edate: ''
            },
            moneyCount :[],
            option: {
                time: [
                    {
                        value: 'CN',
                        label: '中国时间'
                    }, {
                        value: 'EN',
                        label: '美东时间'
                    }
                ],
                type: [
                    {
                        value: '2',
                        label: '未处理'
                    }, {
                        value: '0',
                        label: '存款失败'
                    }, {
                        value: '1',
                        label: '存款成功'
                    }, {
                        value: '-1',
                        label: '全部存款'
                    }
                ]
            },
            tableData: []
        },
        methods: {
            loadData() {
                _self = this;
                _self.loading = false;
                _self.showCount = false;
                $.getJSON("?act=list&username=" + _self.form.username + "&time=" + _self.form.time + "&type=" + _self.form.type + "&bdate=" + _self.form.bdate + "&edate=" + _self.form.edate + "&page=" + _self.currentPage + "&size=" + _self.pageSize, function (res) {
                    _self.tableData = res.list;
                    _self.total = res.total;
                    _self.moneyCount = res.moneyCount;
                    if(_self.tableData.length>0) _self.showCount = true;
                    _self.loading = false;
                });
            },
            getMoneyCount(val){
                var money = this.moneyCount[val];
                if(typeof(money)=="undefined") return "0.00";
                return money.toFixed(2);
            },
            handleSizeChange(val) {
            	$.cookie('hccw_page_size',val);
				this.currentPage = 1;
                this.pageSize = val;
                this.loadData();
            },
            handleCurrentChange(val) {
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
            },
            setBdate(val) {
                this.form.bdate = val;
            },
            setEdate(val) {
                this.form.edate = val;
            }
        },
        created: function () {
            this.bdate = this.form.bdate = "<?=date('Y-m-d 00:00:00',time()+12*3600)?>";
            this.edate = this.form.edate = "<?=date('Y-m-d 23:59:59',time()+12*3600)?>";
			this.form.username = "<?=$_GET['username']?>";
			this.pageSize = 50;
			if($.cookie('hccw_page_size')){
				this.pageSize = Number($.cookie('hccw_page_size'));
			}
            this.loadData();
			$('#app').show();
            setInterval(function(){$('#countList>table').attr('style',$('table').attr('style'));},500);
        }
    }).$mount('#app');
</script>
</html>