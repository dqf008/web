<?php
  include $_SERVER['DOCUMENT_ROOT'] . '/class/Db.class.php';
  $_GET['id'] = (int)$_GET['id'];
  if(!empty($_GET['act']) && $_GET['act'] == 'save'){
    $sort = (int)$_POST['sort'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $id = (int)$_POST['id'];
    $db = new DB();
    $code = 'main-tc-'.$sort;
    if($id>0){
      $res = $db->query('update webinfo set code=:code,title=:title,content=:content where id=:id',['code'=>$code,'title'=>$title,'content'=>$content,'id'=>$id]);
    }else{
      $res = $db->query("insert webinfo(code,title,content) values(:code,:title,:content)",['code'=>$code,'title'=>$title,'content'=>$content]);
    }    
    if($res){
      die(json_encode(['code'=>'00']));
    }else{
      die(json_encode(['code'=>'01']));
    }
  }
  if(!empty($_GET['act']) && $_GET['act'] == 'info'){
    $db = new DB();
    $info = $db->row('select * from webinfo where id=:id and code like "main-tc-%"',['id'=>$_GET['id']]);
    if($info){
      $info['sort'] = explode("-",$info['code'])[2];
    }
    die(json_encode(['data'=>$info]));
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
    .el-form-item--mini.el-form-item{
      margin-bottom: 10px;
    }
    #editor {margin-bottom: 10px;height:500px;}
  </style>
</head>
<body>
  <div id="app">  
  <el-form size="mini" label-position="right" label-width="80px">
  <el-form-item label="排序">
    <el-input style="width: 150px;" v-model="form.sort" placeholder="请输入排序"></el-input>
  </el-form-item>
  <el-form-item label="弹窗标题">
    <el-input style="width: 500px;" v-model="form.title" placeholder="请输入弹窗标题"></el-input>
    <el-button size="mini" @click="save" type="primary">保存</el-button>
  </el-form-item>
  </el-form>    
  </div>
  <div id="editor"></div>
</body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/element-ui/2.4.0/index.js"></script>  
   <link rel="stylesheet" type="text/css" href="../wangEditor/dist/css/wangEditor.min.css">
    <script type="text/javascript" src="../wangEditor/dist/js/wangEditor.js"></script>
  <script src="/skin/layer/layer.js"></script>
  <script>
    /*var E = window.wangEditor;
    var editor = new E('#editor');
    // 或者 var editor = new E( document.getElementById('editor') )
    //editor.customConfig.uploadImgServer = '/upload';
    //editor.customConfig.uploadImgShowBase64 = true;
    editor.customConfig.uploadImgServer = '../upload.php';
    editor.create();*/
    var editor = new wangEditor('editor');
    //editor.config.menus = ["source", "|", "bold", "underline", "italic", "strikethrough", "eraser", "forecolor", "bgcolor", "|", "quote", "fontfamily", "fontsize", "head", "unorderlist", "orderlist", "alignleft", "aligncenter", "alignright", "|", "link", "unlink", "table", "emotion", "|", "img", "video", "|", "undo", "redo", "fullscreen"];
    editor.config.uploadImgUrl = '../wangEditor/upload.php';
    editor.create();
    new Vue({
      data: {
        form:{
          sort:0,
          title:'',
          id:'<?=$_GET['id']?>',
          content:''
        }        
      },
      methods: {
        save: function(){
          this.form.content = editor.$txt.html();
          $.post("?act=save",this.form, function(i){
            if(i.code == '00'){
              alert('保存成功')
              var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
              parent.layer.close(index);
            }else{
              alert('保存失败')
            }
          },'json');
          //alert(editor.txt.html())
        }
      },
      created: function () {
          _self = this;
          if(this.form.id > 0){
            $.getJSON("?act=info&id="+this.form.id,function (i) {
              _self.form = i.data;
              editor.$txt.html(i.data.content)
          })
          }
          
      }
    }).$mount('#app');
  </script>
</html>