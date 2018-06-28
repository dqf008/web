<?php
include $_SERVER['DOCUMENT_ROOT'] . '/class/Db.class.php';
  if($_GET['act'] == 'list'){
    $db = new DB();
    $list = $db->query('select id,code,title from webinfo where code like "main-tc-%" order by code desc');
    foreach($list as $k=>$v) $list[$k]['sort'] = explode("-",$v['code'])[2];
    $arr1 = array_map(create_function('$n', 'return $n["sort"];'), $list);
    array_multisort($arr1,SORT_DESC,$list);
    die(json_encode(['data'=>$list]));
  }
  if($_GET['act'] == 'config'){
    $db = new DB();
    $res = $db->row('select title,content from webinfo where code="main-tcconfig"');
    $info = json_decode($res['content'], true);
    $info['title'] = $res['title'];
    die(json_encode(['data'=>$info]));
  }
  if($_GET['act'] == 'save'){
    $db = new DB();
    $title = $_POST['title'];
    $data = [];
    $data['title'] = $_POST['title'];
    $data['time'] = (int)$_POST['time'];
    $data['color'] = $_POST['color'];
    $data['mini'] = $_POST['mini'] == 'true'?'1':'0';
    $content = json_encode($data);
    if($db->row('select title,content from webinfo where code="main-tcconfig"')){
      $res = $db->query('update webinfo set title=:title,content=:content where code="main-tcconfig"',['title'=>$title,'content'=>$content]);
    }else{
      $res = $db->query('insert webinfo(code,title,content) values("main-tcconfig",:title,:content)',['title'=>$title,'content'=>$content]);
    }
    die(json_encode(['code'=>'00']));
    
  }
  if($_GET['act'] == 'del'){
    $db = new DB();
    $db->query('delete from webinfo where id=:id',['id'=>$_GET['id']]);
    die(json_encode(['code'=>'00']));
  }
?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>首页弹窗列表</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/element-ui/2.4.0/theme-chalk/index.css" />
  <style>
    html,body{padding:0;margin:0;}
    #app{padding:8px;}
    .el-color-picker--mini{    vertical-align: middle;}
  </style>
</head>
<body>
  <div id="app">
    <h2>首页弹窗配置</h2>
    <el-form size="mini">
      <el-form-item label="显示时间">
        <el-input style="width: 200px;" v-model="form.time" placeholder="时间">
        <template slot="append">毫秒</template></el-input>（1000毫秒=1秒，0：不自动关闭，-1：不显示弹窗）
      </el-form-item>
      <el-form-item label="大标题">
        <el-input style="width: 250px;" v-model="form.title" placeholder="标题"></el-input>
        <el-color-picker v-model="form.color"></el-color-picker>
        <el-checkbox v-model="form.mini">精简模式</el-checkbox>
        <el-button style="margin-left:20px;" size="mini" type="primary" @click="save">保存</el-button>
        推荐图片大小：700x500
      </el-form-item>
    </el-form>
    <hr>
    <h2>首页弹窗列表
    <el-button style="float:right;margin-right:40px;" size="mini" type="primary" @click="open">添加</el-button></h2>
    <el-table :data="list" size="mini">
      <el-table-column width="180" prop="sort" label="排序"></el-table-column>
      <el-table-column prop="title" label="弹窗标题"></el-table-column>
      <el-table-column width="200" label="操作">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="open(scope.row.id)">编辑</el-button>
          <el-button type="danger" size="mini" @click="del(scope.row.id)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/element-ui/2.4.0/index.js"></script>  
  <script src="/skin/layer/layer.js"></script>
  <script>
    new Vue({
      data: {
        list:[],
        form:{
          time:0,
          title:'',
          color:'#D99A22',
          mini: false
        }
      },
      methods: {
        open: function(id){
          _self = this;
          var index = layer.open({
            type: 2, 
            content: "tcinfo.php?id="+id,
            //maxmin: true,
            area: ['800px', '660px'],
            end: function(){
              _self.shuaxin();
            }
          });
          //layer.full(index);
        },
        shuaxin: function(){
          _self = this;
          $.getJSON("?act=list",function (i) {
              _self.list = i.data;
          })
        },
        save: function(){
          _self = this;
          $.post("?act=save",this.form, function(i){
            if(i.code == '00'){
              alert('保存成功')
            }else{
              alert('保存失败')
            }
              _self.getconfig();
          },'json');
        },
        getconfig: function(){
          _self = this;
          $.getJSON("?act=config",function (i) {
              _self.form.time = i.data.time;
              _self.form.title = i.data.title;
              _self.form.mini = i.data.mini == 1;
              _self.form.color = i.data.color;
          })
        },
        del: function(id){
          _self = this;
          $.getJSON("?act=del&id="+id,function (i) {
              _self.shuaxin();
          })
        }
      },
      created:function () {
          this.shuaxin();
          this.getconfig();
      }
    }).$mount('#app');
    
  </script>
</html>