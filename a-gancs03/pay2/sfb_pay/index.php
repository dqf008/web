<?php
include __DIR__ . '/../common.php';
$info = json_decode(file_get_contents('conf.json'), true);
if(!empty($_GET['save'])){
    foreach($_POST as $k=>$v){
        $v = str_replace("'","",$v);
        $_POST[$k] = str_replace("\\","",$v);
    } 
    $template = file_get_contents('template.php');
    preg_match_all('{{s_(?<code>.+?)}}', $template, $matchesres);
    $list = $matchesres['code'];
    $str = '';
    $channel = $_POST['channel'];
    $closeList = [];
    foreach($list as $li){
        $start = '{{s_' . $li . '}}';
        $end = '{{e_' . $li . '}}';
        if(in_array($li,$channel) || $li == 'main')
            $str .= substr(strstr(strstr($template,$start),$end,true),strlen($start));
        else
            $closeList[] = $li;
    }
    $conf = '<?php return;?>';
    $data['mid'] = $_POST['mid'];
    $data['key'] = $_POST['key'];
    $data['url'] = $_POST['url'];
    $data['closeList'] = $closeList;
    $conf .= json_encode($data);
    file_put_contents('conf.php',$conf);
    $str = str_replace("{{pay_mid}}", $_POST['mid'], $str);
    $str = str_replace("{{pay_mkey}}", $_POST['key'], $str);
    $str = str_replace("{{pay_url}}", $_POST['url'], $str);
    $db = new Db();
    $db->query('insert pay_conf(`name`, `code`, `conf`, `status`) values (:name, :code, :conf, 0) ON DUPLICATE KEY UPDATE `name`=values(`name`),conf=values(conf)',['name'=>$info['name'], 'code'=>$info['code'], 'conf'=>$str]);
    echo 'ok';
    exit;
}else if(!empty($_GET['info'])){
    header('Content-type: application/json');
    $template = file_get_contents('template.php');
    preg_match_all('{{s_(?<code>.+?)}}', $template, $matchesres);
    $conf = file_get_contents('conf.php');
    $conf = json_decode(str_replace("<?php return;?>","",$conf), true);
    $list = [];
    unset($matchesres['code'][0]);
    foreach($matchesres['code'] as $v){
        $isClose = ! in_array($v, $conf['closeList']);
        $list[] = ['name'=>$NAME_ENUM[$v],'value'=>$v,'status'=>$isClose];
    }
    $conf['list'] = $list;
    unset($conf['closeList']);
    echo json_encode($conf);
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/element-ui@2.0.8/lib/theme-chalk/index.css">
    <style>
    .el-input.is-disabled .el-input__inner{color: #909399;}
    .el-form-item__content{height:40px;}
    </style>
</head>
<body>
<div id="app">
    <el-form ref="form" :model="form" :rules="rules" label-width="80px">
      <el-form-item label="支付名称">
        <el-input v-model="form.name" :disabled="true"></el-input>
      </el-form-item>
      <el-form-item label="商户号" prop="mid">
        <el-input v-model="form.mid"></el-input>
      </el-form-item>
      <el-form-item label="商户密钥" prop="key">
        <el-input v-model="form.key"></el-input>
      </el-form-item>
      <el-form-item label="支付域名" prop="url">
        <el-input v-model="form.url"><template slot="prepend">Http://</template></el-input>
      </el-form-item>
      <el-form-item label="支付渠道" prop="channel">
        <el-checkbox-group v-model="form.channel">
            <el-checkbox v-for="li in list" :label="li.value" :checked="li.status"><span v-text="li.name"></span></el-checkbox>
        </el-checkbox-group>
      </ele-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit('form')" v-text="'提交'"></el-button>
        <el-button v-text="'返回'" onclick="window.location.href='../'"></el-button>
      </el-form-item>
    </el-form>
</div>
<script src="https://unpkg.com/jquery@3.2.1/dist/jquery.min.js"></script>
<!-- 先引入 Vue -->
<script src="https://unpkg.com/vue@2.5.11/dist/vue.min.js"></script>
<!-- 引入组件库 -->
<script src="https://unpkg.com/element-ui@2.0.8/lib/index.js"></script>
<script>
    new Vue({
        data: {
            form: {
              name: '快付',
              mid: '',
              key: '',
              url: '',
              channel: []
            },
            list:[],
            rules: {
              mid: [
                { required: true, message: '请输入商户号', trigger: 'blur' },
              ],
              key: [
                { required: true, message: '请输入商户密钥', trigger: 'blur' }
              ],
              url: [
                { required: true, message: '请输入支付域名', trigger: 'blur' }
              ]
            }
        },
        methods: {
             onSubmit(formName) {
                _self = this;
                this.$refs[formName].validate((valid) => {
                  if (valid) {
                    $.ajax({
                        url:"index.php?save=ok",
                        type: "POST",
                        data: _self.form,
                        success: function(res) {
                            if(res == 'ok'){
                                alert('保存成功');
                                window.location.href="../";
                            }
                        }
                    });
                  } else {
                    console.log('error submit!!');
                    return false;
                  }
                });
              }
        },
        created: function () {
            _self = this;
            $.ajax({
                url:"index.php?info=ok",
                success: function(res){
                    _self.form.mid = res.mid;
                    _self.form.key = res.key;
                    _self.form.url = res.url;
                    _self.list = res.list;
                }
            });
        }
    }).$mount('#app');
</script>
</body>
</html>