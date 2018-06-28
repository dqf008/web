<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('jkkk');
$group = array();
$sql = 'select id,name from k_group order by id asc';
$query = $mydata1_db->query($sql);
while ($rows = $query->fetch()){
	$group[$rows['id']] = $rows['name'];
}
function fileext($filename)
{
	return substr(strrchr($filename, '.'), 1);
}
if(!empty($_GET['act']) && $_GET['act'] == 'upload') {
	  $lj = '../static/uploads/'.date('Ymd').'/';
	  $destination_folder = dirname(__FILE__).'/../'.$lj;    //上传文件路径
	  $uptypes = array (
			'image/jpg',
			'image/png',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/bmp',
			'image/x-png'
	  );
	  if(is_uploaded_file($_FILES['file']['tmp_name'])) {
	  	$upfile = $_FILES['file'];
		$name = time().'.'.fileext($upfile['name']);    //文件名
        $type = $upfile['type']; //文件类型
        $size = $upfile['size']; //文件大小
        $tmp_name = $upfile['tmp_name'];  //临时文件
        $error = $upfile['error']; //出错原因
		if (!in_array($type, $uptypes)) {        //判断文件的类型
            message('请上传图片文件！');
            exit ();
        }
		if (!file_exists($destination_folder)) {
            mkdir($destination_folder);
        }
		$uploadfile1 = $destination_folder.$name;
		$card_img = $lj.$name;
		move_uploaded_file($tmp_name, $uploadfile1);
		die($card_img);
	}
}
if(!empty($_GET['act']) && $_GET['act'] == 'list'){
	include_once '../../cache/bank2.php';
	$list = [];
	foreach($bank as $gid=>$data){
		$list[] = ['groupid'=>$gid,'groupname'=>$group[$gid]];
		foreach($data as $v){
			$v['groupid'] = $gid;
			if($v['state'] === null){
				$v['state'] = true;
			} 
			$list[] = $v;
		}
	}
	die(json_encode($list));
}
if(!empty($_GET['act']) && $_GET['act'] == 'update'){
	$list = $_POST['list'];
	$str = '<?php ' . "\r\n";
	$str .= 'unset($bank);' . "\r\n";
	$str .= '$bank = array();' . "\r\n";
	for($i = 0; $i<count($list);$i++){
		$li = $list[$i];
		$li['groupid'] = (int)$li['groupid'];
		$li['state'] = $li['state']==='true'?'true':'false';
		$str .= '$bank[' . $li['groupid'] . '][' . $i . '][\'card_bankName\']=\'' .  str_replace("'",'',$li['card_bankName']) . '\';' . "\r\n";
		$str .= '$bank[' . $li['groupid'] . '][' . $i . '][\'card_ID\']=\'' .  str_replace("'",'',$li['card_ID']) . '\';' . "\r\n";
		$str .= '$bank[' . $li['groupid'] . '][' . $i . '][\'card_name\']=\'' .  str_replace("'",'',$li['card_name']) . '\';' . "\r\n";
		$str .= '$bank[' . $li['groupid'] . '][' . $i . '][\'card_img\']=\'' .  str_replace("'",'',$li['card_img']) . '\';' . "\r\n";
		$str .= '$bank[' . $li['groupid'] . '][' . $i . '][\'state\']=' .  $li['state'] . ';' . "\r\n";
	}
	//die(json_encode($_POST));
	if (@!chmod('../../cache', 511))
	{
		//message('缓存文件写入失败！请先设 /cache 文件权限为：0777');
		die('error');
	}
	if (!write_file('../../cache/bank2.php', $str . '?>'))
	{
		//message('缓存文件写入失败！请先设/cache/bank2.php文件权限为：0777');
		die('error');
	}
	include_once '../../class/admin.php';
	admin::insert_log($_SESSION['adminid'], '修改了入款微信支付宝');
	//message('缓存文件写入成功！');
	die('ok');
}
?> 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>微信、支付宝</title> 
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/modern-normalize@0.4.0/modern-normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.2.1/lib/theme-chalk/index.min.css">
    <style>
        body {
		    padding: 8px;
		    font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
		}
		[v-cloak] {
		    display: none !important
		}
		.avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
  .el-table div.cell{
  	text-align: center;
  }
</style> 
</head> 
<body> 
<div id="app">
	<h2>微信支付宝二维码设置</h2>
	<el-table border :data="list" style="width:100%" size="mini" :span-method="colspan" :cell-style="cellstyle">
		<el-table-column label="支付名称">
			<template slot-scope="scope">
				<span v-if="scope.row.groupname" v-text="scope.row.groupname"></span>
				<span v-else v-text="scope.row.card_bankName"></span>
			</template>
		</el-table-column>
		<el-table-column prop="card_ID" label="入款帐号"></el-table-column>
		<el-table-column prop="card_name" label="昵称"></el-table-column>
		<el-table-column prop="card_img" label="二维码">
			<template slot-scope="scope">
				<el-tooltip placement="right" effect="light">
					<div slot="content"><img style="max-width:200px" v-if="scope.row.card_img" :src="'/static/'+scope.row.card_img"></div>
					<el-button size="mini">查看</el-button>
				</el-tooltip>
			</template>
		</el-table-column>
		<el-table-column label="状态">
			<template slot-scope="scope">
				<el-switch
					v-model="scope.row.state"
					active-color="#13ce66"
					inactive-color="#dcdfe6"
					@change=change(scope)
					:active-text="scope.row.state?'启用':'停用'">
				</el-switch>
			</template>
		</el-table-column>
		<el-table-column label="操作">
			<template slot-scope="scope">
				<el-button size="mini" type="primary" @click="edit(scope)">编辑</el-button>
				<el-button size="mini" type="danger" @click="del(scope.$index)">删除</el-button>
			</template>
		</el-table-column>
	</el-table>
	<h3>支付信息设置</h3>
	<el-form  ref="form" size="mini" style="width:600px;margin:10px;" label-width="100px">
		<el-form-item label="支付名称">
			<el-input v-model="form.card_bankName"></el-input>
		</el-form-item>
		<el-form-item label="入款帐号">
			<el-input v-model="form.card_ID"></el-input>
		</el-form-item>
		<el-form-item label="昵称">
			<el-input v-model="form.card_name"></el-input>
		</el-form-item>
		<el-form-item label="二维码">
			<el-upload
			  class="avatar-uploader"
			  action="?act=upload"
			  :show-file-list="false"
			  :on-success="handleAvatarSuccess"
			  :before-upload="beforeAvatarUpload">
			  <img v-if="form.card_img" :src="'/static/'+form.card_img" class="avatar">
			  <i v-else class="el-icon-plus avatar-uploader-icon"></i>
			</el-upload>
			注意：只允许上传png、jpg、gif、bmp图片文件（大小规格：200*200）
		</el-form-item>
		<el-form-item label="所属会员组">
			<el-select v-model="form.groupid" placeholder="请选择">
				<el-option v-for="g in group" :value="g.id" :label="g.name"></el-option>
			</el-select>
		</el-form-item>
		<el-form-item>
			注意：【扫一扫充值】的订单，统一存放在【汇款管理】
		</el-form-item>
		<el-form-item>
  			<el-button type="primary" @click="submit">提交</el-button>
			<el-button>返回</el-button>
		</el-form-item>
	</el-form>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/element-ui@2.2.1/lib/index.min.js"></script>
<script type="text/javascript">
 var vm = new Vue({
	data: {
		form:{
			card_bankName:'',
			card_ID:'',
			card_name:'',
			card_img: '',
			groupid:'',
		},
		isedit:false,
		list:[],
		group:[
			<?php foreach($group as $k=>$v):?>
			{id:<?=$k?>,name:'<?=$v?>'},
			<?php endforeach;?>
		]
	},
	methods: {
		del(i){
			this.list.splice(i,1);
			var data = JSON.parse(JSON.stringify(this.list));
			for(var i in data){
				if(data[i].groupname){
					data.splice(i,1);
				}
			}
			$.post('?act=update',{list:data},function(res){
				if(res === 'ok'){
					_self.$message({
			          message: '删除成功',
			          type: 'success'
			        });
					_self.getlist();
				}else{
					_self.$message.error('删除失败')
				}
			});
		},
		change(scope){
			this.list[scope.$index] = scope.row;
			var data = JSON.parse(JSON.stringify(this.list));
			for(var i in data){
				if(data[i].groupname){
					data.splice(i,1);
				}
			}
			console.log(data)
			$.post('?act=update',{list:data},function(res){
				console.log(res)
				if(res === 'ok'){
					_self.$message({
			          message: '修改成功',
			          type: 'success'
			        });
					_self.getlist();
				}else{
					_self.$message.error('修改失败')
				}
			});
		},
		edit(scope){
			obj = JSON.parse(JSON.stringify(scope.row))
			obj.index = scope.$index;
			this.form = obj;
			this.isedit = true
		},
		submit(){
			_self = this;
			var obj = JSON.parse(JSON.stringify(this.form));
			console.log(obj)
			if(obj.groupid<1){
				_self.$message.error('所属会员组不能为空！');
				return;
			}
			if(!obj.card_bankName || obj.card_bankName.length === 0){
				_self.$message.error('支付名称不能为空！');
				return;
			}
			if(!obj.card_ID || obj.card_ID.length === 0){
				_self.$message.error('入款帐号不能为空！');
				return;
			}
			if(!obj.card_name || obj.card_name.length === 0){
				_self.$message.error('昵称不能为空！');
				return;
			}
			if(!obj.card_img || obj.card_img.length === 0){
				_self.$message.error('二维码不能为空！');
				return;
			}
			if(this.isedit){
				this.list[obj.index] = obj;
			}else{
				var insert = false;
				for(var i in this.list){
					if(this.list[i].groupid == obj.groupid) insert = true;
					if(insert){
						if(this.list[i].groupid != obj.groupid){
							this.list.splice(i,0,obj);
							break;
						} else if( i == (this.list.length-1)){
							this.list.push(obj);
							break;
						}
					} 
				}
				if(!insert){
					for(var i in this.group){
						if(this.group[i].id == obj.groupid){
							this.list.push({groupname:this.group[i].name});
							this.list.push(obj);
							break;
						} 
					}

				}
			}
			var data = JSON.parse(JSON.stringify(this.list));
			for(var i in data){
				if(data[i].groupname){
					data.splice(i,1);
				}
			}
			$.post('?act=update',{list:data},function(res){
				var msg = _self.isedit?'修改':'添加';
				if(res === 'ok'){
					_self.$message({
			          message: msg+'成功',
			          type: 'success'
			        });
					_self.getlist();
				}else{
					_self.$message.error(msg+'失败')
				}
			});
		},
		 handleAvatarSuccess(res, file) {
        	this.form.card_img = res;
      },
      beforeAvatarUpload(file) {
      	//return true;
        //const isJPG = file.type === 'image/jpeg';
        const isLt2M = file.size / 1024 / 1024 < 2;
        if (!isLt2M) {
          this.$message.error('上传二维码大小不能超过 2MB!');
        }
        return isLt2M;
      },
      colspan({ row, column, rowIndex, columnIndex }) {
      	if(row.groupname){
      		if(columnIndex === 0)
      			return {colspan:6,rowspan:1};
      		else
      			return {colspan:0,colspan:0}
      	}else{
      		return {rowspan:1, colspan:1}
      	}
      },
      cellstyle({row, column, rowIndex, columnIndex}){
      	if(row.groupname){
      		return {background:'#d9d9d9','font-size':'20px','text-align':'center'}
      	}else{
      		return '';
      	}
      },
      getlist(){
      	_self = this;
		$.getJSON('?act=list',function(json){
			_self.list = json;
		});
		this.init();
		},
		init(){
			this.form.groupid = this.group[0].id;
			this.isedit = false;
			this.form.card_name = '';
			this.form.card_img = '';
			this.form.card_bankName = '';
			this.form.card_ID = '';
			this.form.state = true;
		}
	},
	created: function() {
		this.getlist();
	}
}).$mount('#app');
</script>
</body> 
</html>