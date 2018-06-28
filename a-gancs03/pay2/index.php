<?php
    include '../../pay/list.conf.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支付管理</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/element-ui@2.0.8/lib/theme-chalk/index.css">
    <style>
      .el-switch{
        height: 23px;
        line-height: 23px;
      }
    </style>
</head>
<body>
<div id="app">
    <h2 class="text-center">支付管理</h2>
    <template>
      <el-table :data="list" stripe style="width: 80%">
        <el-table-column prop="name" label="第三方" width="180"></el-table-column>
        <el-table-column label="已启用支付">
          <template slot-scope="scope">
          <el-tag v-for="li in scope.row.list" v-text="li" style="margin-right:5px;">标签一</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="开关" width="100">
          <template slot-scope="scope">
            <el-switch v-model="scope.row.status" @change="change(scope.row)"></el-switch>
          </template>
        </el-table-column>
        <el-table-column label="操作" width="100">
          <template slot-scope="scope"><el-button type="primary" icon="el-icon-edit" @click="edit(scope.row.code)" v-text="'编辑'"></el-button></template>
        </el-table-column>
      </el-table>
    </template>
</div>
    <script src="https://unpkg.com/jquery@3.2.1/dist/jquery.min.js"></script>
    <!-- 先引入 Vue -->
    <script src="https://unpkg.com/vue@2.5.11/dist/vue.min.js"></script>
    <!-- 引入组件库 -->
    <script src="https://unpkg.com/element-ui@2.0.8/lib/index.js"></script>
    <script>
        new Vue({
            data: {
                list:[]
            },
            methods: {
              change (obj){
                $.getJSON("api.php?act=change&code="+obj.code+"&status="+obj.status, function(res){
                    if (res.code != 200) obj.status = !obj.status;
                });
              },
              edit (code){
                window.location.href = code + "/index.php";
              }
            },
            created: function () {
              _self = this;
              $.getJSON("api.php?act=list", function (res) {
                  if (res.code == 200)
                      _self.list = res.data;
              });
            }
        }).$mount('#app');
    </script>
</body>
</html>