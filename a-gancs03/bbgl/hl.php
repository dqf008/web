<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('bbgl');
if(!empty($_GET['act']) && $_GET['act'] == 'list'){
	include_once '../../cache/hlhy.php';
	$list = [];
	foreach($hlhy as $k=>$v){
		$list[] = ['id'=>$k,'name'=>$v];
	}
	die(json_encode($list));
}
if(!empty($_GET['act']) && $_GET['act'] == 'info'){
	$username = trim($_GET['name']);
	$sql = 'select username,uid from k_user where username=:username';
	$stmt = $mydata1_db->prepare($sql);
	$stmt->execute([':username'=>$username]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if($res){
    	die(json_encode(['id'=>$res['uid'],'name'=>$res['username']]));
    }
	die(false);
}
if(!empty($_GET['act']) && $_GET['act'] == 'save'){
	$list = $_POST['list'];
	$list2 = [];
	foreach($list as $v){
		$uid = (int)$v['id'];
		$res = $mydata1_db->query('select username,uid from k_user where uid='.$uid .' limit 1')->fetch(PDO::FETCH_ASSOC);
		if($res){
			$list2[$res['uid']] = $res['username'];
		}
	}
	$str = '<?php ' . "\r\n";
	$str .= 'unset($hlhy,$hl_uid);' . "\r\n";
	$str .= '$hl_uid=\'' . implode(',',array_keys($list2)) . '\';' . "\r\n";
	$str .= '$hlhy=array();' . "\r\n";
	foreach($list2 as $k=>$v){
		$str .= '$hlhy[' . $k . ']=\'' . $v . '\';' . "\r\n";
	}
	if (@!chmod('../../cache', 511))
	{
		die(false);
	}
	if (!write_file('../../cache/hlhy.php', $str . '?>'))
	{
		die(false);
	}
	die(true);
}
?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>报表忽略</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize@0.4.0/modern-normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.2.0/lib/theme-chalk/index.min.css">
    <style>
        body {
    padding: 8px;
    font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
}

.el-tag+.el-tag {
    margin-left: 10px
}

.el-tag {
    cursor: pointer
}

.button-new-tag {
    margin-left: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
}

.input-new-tag {
    width: 90px;
    margin-left: 10px;
    vertical-align: bottom;
}

[v-cloak] {
    display: none !important
}
    </style>
</head>

<body>
    <div id="app">
        <el-card class="box-card" v-cloak>
            <div slot="header" class="clearfix"> <span>被忽略的会员</span>
                <el-button style="float: right; padding: 3px 0;margin-left:20px;" @click="clear()" type="text">清空</el-button>
                <el-button @click="save()" style="float: right; padding: 3px 0" type="text">保存</el-button>
            </div>
            <el-tag v-for="v in list" :key="v.id" @click.native="openInfo(v.id)" @close="handleClose(v.id)" closable v-cloak>{{ v.name }}</el-tag>
            <el-input class="input-new-tag" v-if="inputVisible" v-model="inputValue" ref="saveTagInput" size="small" @keyup.enter.native="handleInputConfirm" @blur="handleInputConfirm"></el-input>
            <el-button v-else class="button-new-tag" size="small" @click="showInput">+ 新增</el-button>
        </el-card>
    </div>
    <p>忽略会员此功能用于查询报表时，忽略内部账户的所有记录</p>
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/element-ui@2.2.0/lib/index.min.js"></script>
    <script type="text/javascript">
        var vm = new Vue({
            data: {
                list: [],
                inputVisible: false,
                inputValue: ''
            },
            methods: {
                openInfo(id) {
                    document.location.href = "../hygl/user_show.php?id=" + id;
                },
                handleClose(id) {
                    for (var i in this.list) {
                        if (this.list[i].id == id) this.list.splice(i, 1);
                    }
                },
                showInput() {
                    this.inputVisible = true;
                    this.$nextTick(_ => {
                        this.$refs.saveTagInput.$refs.input.focus();
                    });
                },
                handleInputConfirm() {
                    var inputValue = this.inputValue.trim();
                    _self = this;
                    var isExist = false;
                    for (var i in _self.list) {
                        if (_self.list[i].name == inputValue) isExist = true;
                    }
                    if (inputValue && !isExist) {
                        $.getJSON('?act=info&name=' + inputValue, function(json) {
                            if (json) _self.list.push(json);
                        });
                    }
                    this.inputVisible = false;
                    this.inputValue = '';
                },
                clear() {
                    this.list = [];
                },
                save() {
                	_self = this;
                    $.post('?act=save', {
                        list: this.list
                    }, function(json) {
                        var msg = '保存失败';
                        if (json) {
                            _self.$message({message: '保存成功',type: 'success'});
                        } else {
                            _self.$message.error('保存失败');
                        }
                        _self.getList();
                    });
                },
                getList(){
                	_self = this;
                	_self.list = [];
	                $.getJSON('?act=list', function(json) {
	                    _self.list = json;
	                })
                }
            },
            created: function() {
                this.getList();
            }
        }).$mount('#app');
    </script>
</body>

</html>