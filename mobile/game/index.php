<?php
session_start();
include_once '../../include/config.php';
website_close();
website_deny();
include_once '../../database/mysql.config.php';
include_once '../../common/function.php';
include_once '../../class/user.php';
include_once '../../include/newpage.php';
include_once '../../member/function.php';
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];
$loginid = $_SESSION['user_login_id'];
$userinfo = user::getinfo($uid);
$game = strtolower($_GET['g']);
$cdn_url = '//cdn.fox008.cc/';
$list = ['mg2', 'cq9', 'kg', 'xin', 'pt', 'bbin', 'ky', 'fish'];
if(!in_array($game ,$list)){
  $game = $list[0];
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
  <link rel="stylesheet" href="../sports/css/style.css" type="text/css" media="all">
  <script type="text/javascript" src="../sports/js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="../sports/js/top.js"></script>
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
    .el-select {
      display: block;
    }
    .el-radio-group {
      overflow-x: scroll;
      width: 100%;
      white-space:nowrap;  text-overflow:ellipsis;
    }
  </style>
</head>
<body>
  <div id="app" :class="config.name">
    <!--头部开始-->
    <header id="header">
        <a href="../" class="ico ico_home ico_home_l ui-link"></a>
            <span><?php echo $curGame; ?>电子游戏</span>
    </header>
    <div class="mrg_header"></div>
    <div style="margin:10px 5px;">
      <div style="padding:10px 0; border-bottom: 1px solid #988d8d; margin-bottom: 10px;">
        <el-radio-group v-model="game" size="mini" @change="gamechange">
          <el-radio-button label="mg2">新MG电子</el-radio-button>
          <el-radio-button label="pt">PT电子</el-radio-button>
          <el-radio-button label="cq9">CQ9电子</el-radio-button>
          <el-radio-button label="ky">开元棋牌</el-radio-button>
          <el-radio-button label="kg">AV女优</el-radio-button>
          <el-radio-button label="xin">XIN电子</el-radio-button>
          <el-radio-button label="bbin">BB电子</el-radio-button>
          <el-radio-button label="fish">捕鱼达人</el-radio-button>
        </el-radio-group>
      </div>
      <div style="padding-bottom:10px;">
      <el-select v-model="category" value-key="CategoryKey" placeholder="请选择">
        <el-option
          v-for="item in Categories"
          :label="item.DisplayName"
          :value="item.CategoryKey">
        </el-option>
      </el-select>
        </div>
      <el-input placeholder="查找游戏" v-model="keyword">
        <i slot="prefix" class="el-input__icon el-icon-search"></i>
      </el-input>
      </div>
      <ul class="list" id="list">
          <li class="game" v-for="game in gamelist">
            <div class="content" @click="open(game.id)">
              <div class="icon" :style="icon(game.ButtonImagePath)"></div>
              <!--img :src="icon2(game.img)" -->
            </div>
            <div class="title" v-text="game.name" :title="game.name"></div>
          </li>
        <div style=" clear: both;"></div>
        </ul>
        <el-pagination autofocus="false"  v-if="pagecount>1" background layout="pager" @current-change="CurrentChange" :page-size="pagesize" :total="count" :current-page="currentPage"></el-pagination>
  </div>
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
        global: [],
        config: [],
        data: [],
        Categories:[],
        currentPage : 1,
        pagesize : 18,
        pagecount : 0,
        keyword: '',
        category: '',
        count: 0
      },
      methods: {
        icon: function(img){
          return 'background-image:url(<?=$cdn_url?>'+img+')';
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
            //this.category = '0';
            this.pagecount = 0;
            this.count = 0;
            _self = this;
            this.config = this.global[this.game];
            $.getJSON('<?=$cdn_url?>' + this.config.list,'',function(json){
              _self.data = json.Games;
              _self.Categories = json.Categories
              _self.category =  _self.Categories[0].CategoryKey;
            });
        },
        categorychange: function(){

        },
        CurrentChange: function(val){
          this.currentPage = val;
          $( "html,body").animate({ "scrollTop" : 65 }, 200);
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
          //console.log(this.data)
          for(var i=0;i<this.data.length;i++){
            if(this.category != '0'){
              var inArray = false;
                  for(var f in this.data[i].CategoryKey){
                    if(this.data[i].CategoryKey[f] === this.category) inArray = true;
                  }
              if(!inArray) continue;
            }
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
        _self = this;
        $.getJSON('<?=$cdn_url?>Common/SlotCasinoData/m/GLOBAL2.json?_=20180521','',function(json){
          _self.global = json;
          _self.gamechange();
        });
      }
    });
  </script>
  </body>
  </html>