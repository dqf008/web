<?php
$game = strtolower($_GET['g']);
$list = ['mg2', 'cq9', 'kg', 'xin', 'pt', 'fish'];
if(!in_array($game ,$list)){
  die('GAME TYPE ERROR!!!');
}
?><!DOCTYPE html> 
<html> 
<head> 
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8"> 
  <title><?=$web_site['web_title'];?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black"> 
  <link rel="shortcut icon" href="images/favicon.ico"> 
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all"> 
  <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
  <script type="text/javascript" src="js/top.js"></script> 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.1.0/lib/theme-chalk/index.css">
  <style>
    *{
       box-sizing:border-box;
      -moz-box-sizing:border-box; /* Firefox */
      -webkit-box-sizing:border-box;
    }
    .list {
      margin-bottom: 10px;
    }
    .content img{
      height: 100%;
    }
    .content{
      padding-top: 5px;
    }
    .title {
      overflow: hidden;
      white-space:nowrap;
      font-size: 12px;
      height: 20px;
      line-height: 15px;
    }
    .icon{
      height: 90px;
      width: 90px;
      background-repeat: no-repeat;
      background-size: 98% 98%;
    }
    .list>li{
      float: left;
      width: 33.33%;
      border: 1px solid #ccc;
      text-align: center;
    }
    .el-pagination.is-background .el-pager li:hover,.el-radio-button__inner:hover{
      color:#606266;
    }
    .el-pagination.is-background .el-pager li.active{
      color:#FFF !important;
    }
    .el-radio-button__orig-radio:checked+.el-radio-button__inner{
      background-color: rgb(51, 136, 204);
      border-color: rgb(51, 136, 204);
      box-shadow: rgb(51, 136, 204) -1px 0px 0px 0px
    }
    .page_navigation li{
      float:left;
    }
    .mg .icon{
      background-size: 200% 100%;
    }
  </style>
</head> 
<body> 
  <div id="app" :class="config.name">
    <!--头部开始--> 
    <header id="header"> 
        <a href="/m/" class="ico ico_home ico_home_l ui-link"></a> 
            <span><?php echo $curGame; ?>电子游戏</span> 
    </header> 
    <div class="mrg_header"></div>
    <div style="margin:10px 5px;">
      <div style="padding:10px 0; border-bottom: 1px solid #988d8d; margin-bottom: 10px;">
        <el-radio-group v-model="game" size="mini" @change="gamechange">
          <el-radio-button label="mg2">新MG电子</el-radio-button>
          <el-radio-button label="cq9">CQ9电子</el-radio-button>
          <el-radio-button label="kg">AV女优</el-radio-button>
          <el-radio-button label="xin">XIN电子</el-radio-button>
          <el-radio-button label="pt">PT电子</el-radio-button>
          <el-radio-button label="fish">捕鱼达人</el-radio-button>
        </el-radio-group>
      </div>
      <div style="padding-bottom:10px;">
       <el-radio-group v-model="category" size="mini" @change="categorychange">
          <el-radio-button label="0">所有游戏</el-radio-button>
          <el-radio-button label="1">拉霸</el-radio-button>
          <!--el-radio-button label="2">桌面游戏</el-radio-button-->
          <el-radio-button label="3">视频扑克</el-radio-button>
          <el-radio-button label="4">其他</el-radio-button>
        </el-radio-group>
        </div>
      <el-input placeholder="查找游戏" v-model="keyword" size="mini">
        <i slot="prefix" class="el-input__icon el-icon-search"></i>
      </el-input>
      </div>
      <ul class="list" id="list">
          <li class="game" v-for="game in gamelist">
            <div class="content" @click="open(game.id)">
              <div class="icon" :style="icon(game.img)"></div>
              <!--img :src="icon2(game.img)" -->
            </div>
            <div class="title" v-text="game.name" :title="game.name"></div>
          </li>
        <div style=" clear: both;"></div>
        </ul>
        <el-pagination autofocus="false"  v-if="pagecount>1" background layout="pager" @current-change="CurrentChange" :page-size="pagesize" :total="count" :current-page="currentPage"></el-pagination>
  </div>
<!--底部开始--><?php include_once 'bottom.php';?>    <!--底部结束--> 
 <!-- 先引入 Vue -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>
  <!-- 引入组件库 --> 
  <script src="https://cdn.jsdelivr.net/npm/element-ui@2.1.0/lib/index.js"></script>
  <script type="text/javascript" src="/skin/layer/mobile/layer.js"></script>
  <script>
    var vm = new Vue({
      el: '#app',
      data: {
        isLogin: <?=empty($_SESSION["uid"])?"false":"true"?>,
        game: '<?=$game?>',
        config: [],
        data: [],
        currentPage : 1,
        pagesize : 18,
        pagecount : 0,
        keyword: '',
        category: '0',
        count: 0
      },
      methods: {
        icon: function(img){
          var url = this.config.icon_uri + img;
          return 'background-image:url('+url+')';
        },
        open: function(id){
          if(this.config.try_uri !== '' && !this.isLogin){
            url = this.config.try_uri+id+'&mobile=true';
            _self = this;
            layer.open({
              content: '是否进入试玩',btn: ['确定', '取消'],yes: function(index){
                window.open(url);
              }
            });
          }else{
            url = this.config.login_uri+id+'&mobile=true';
            window.open(url);
          }
        },
        gamechange: function(){
            this.data = new Array();
            this.keyword = '';
            this.currentPage = 1;
            this.category = '0';
            this.pagecount = 0;
            this.count = 0;
            _self = this;
            url = '/game/data/'+this.game+'.conf.php?_='+Math.random();
            $.getJSON(url,'',function(json){ 
              _self.config = json;
              $.getJSON(_self.config.m_list,'',function(json){
                _self.data = json.game_list;
              });
            });
        },
        categorychange: function(){

        },
        CurrentChange: function(val){
          this.currentPage = val;
          $( "html,body").animate({ "scrollTop" : 0 }, 200);
        }
      },
      watch: {
        keyword: function(){ this.currentPage = 1;},
        category: function(){ this.currentPage = 1;},
        count: function(){ this.pagecount = Math.ceil(this.count / this.pagesize);}
      },
      computed: {
        gamelist: function(){
          if(this.data.length == 0) return [];
          var list = new Array();
          var tmp = new Array();
          var pattern = new RegExp(this.keyword);
          for(var i=0;i<this.data.length;i++){
            if(this.category !== '0' && this.data[i].type != this.category) continue;
            if(this.keyword !== '' && !pattern.test(this.data[i].name)) continue;
            tmp.push(this.data[i]); 
          }
          this.count = tmp.length;

          for(var i=0;i<this.count;i++){
            var s = (this.currentPage - 1) * this.pagesize;
            var e = s+this.pagesize;
            if(i>=s && i<e) list.push(tmp[i]);
          }
          return list;
        }
      },
      created: function(){
        this.gamechange();
      }
    });
  </script>
  </body>
  </html>