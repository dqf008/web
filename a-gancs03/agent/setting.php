<?php
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('dlgl');

$file = realpath('../../cache/').'/agent.conf.php';
$config = [];
file_exists($file)&&$config = include($file);
if(!empty($_POST)&&isset($_POST['action'])&&$_POST['action']=='save'){
    $keys = ['Skin', 'AgentLogo', 'HotLine', 'ServiceUrl', 'ServiceQQ', 'WeChatQrCode', 'ServiceRule', 'Tips', 'ValidMember', 'GameCount', 'AgentCount', 'AvgCheckout', 'NewMember'];
    foreach($keys as $key){
        if(isset($_POST[$key])&&!empty($_POST[$key])){
            $_POST[$key] = trim(strip_tags($_POST[$key]));
            if($key=='Skin') {
                $_POST[$key] = in_array($_POST[$key], ["gold", "blue"])?$_POST[$key]:'red';
            }else if($key=='ServiceQQ'||$key=='ServiceRule'||$key=='Tips'){
                $_POST[$key] = str_replace("\r", "\n", $_POST[$key]);
                $_POST[$key] = preg_replace('/\n+/', "\n", $_POST[$key]);
                $_POST[$key] = explode("\n", $_POST[$key]);
            }
        }else{
            $_POST[$key] = '';
        }
        $config[$key] = $_POST[$key];
    }
    file_put_contents($file, '<?php'.PHP_EOL.'return unserialize(\''.serialize($config).'\');');
    admin::insert_log($_SESSION['adminid'], '修改了代理系统设置信息');
    message('保存成功！');
    exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Welcome</title>
    <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" />
    <style type="text/css">
        .menu_curr {color:#FF0;font-weight:bold}
        .menu_com {color:#FFF;font-weight:bold}
        .sub_curr {color:#f00;font-weight:bold}
        .sub_com {color:#333;font-weight:bold}
        .selected {background-color:#aee0f7}
    </style>
    <script type="text/javascript" charset="utf-8" src="/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="../js/layer/layer.js"></script>
    <script type="text/javascript">
        $(document.body).ready(function(){
            var openUpload = function(){
                return layer.open({
                    type: 2,
                    shadeClose: true,
                    fix: true,
                    skin: 'layui-layer-lan',
                    title: "图片上传",
                    content: "../mobile/images.php",
                    area: ['400px', '120px'],
                    shift: 0,
                    scrollbar: false
                });
            };
            window.onMessage = function(){};
            $(".set-image input[type=button]").on("click", function () {
                var e = $(this), i;
                !e.data("reset")?(i = openUpload(), window.onMessage = function(image){
                    e.siblings("span.img").html('<input type="hidden" name="'+e.data("name")+'" value="'+image+'"><img src="'+image+'" style="max-height:200px">');
                    layer.close(i)
                }):e.siblings("span.img").html('未设置');

            });
        });
    </script>
</head>
<body>
<div id="pageMain">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td valign="top">
                <form action="setting.php" method="POST">
                    <input type="hidden" name="action" value="save" />
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                        <tr>
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="2"><strong>代理系统设置</strong></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">电脑端模板：</td>
                            <td align="left" bgcolor="#FFFFFF">
                                <select name="Skin">
                                    <option value="red">红色模板</option>
                                    <option value="gold"<?php echo isset($config['Skin'])&&$config['Skin']=='gold'?' selected="true"':''; ?>>黄色模板</option>
                                    <option value="blue"<?php echo isset($config['Skin'])&&$config['Skin']=='blue'?' selected="true"':''; ?>>蓝色模板</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">电脑端LOGO：</td>
                            <td align="left" bgcolor="#FFFFFF" class="set-image"><span class="img"><?php echo !isset($config['AgentLogo'])||empty($config['AgentLogo'])?'未设置':'<input type="hidden" name="AgentLogo" value="'.$config['AgentLogo'].'"><img src="'.$config['AgentLogo'].'" style="max-height:80px">'; ?></span><br /><input type="button" value="设置新图片" data-name="AgentLogo"></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">客服热线：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" class="textfield" size="40" name="HotLine" value="<?php echo isset($config['HotLine'])?$config['HotLine']:''; ?>" /></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">在线客服链接：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" class="textfield" size="40" name="ServiceUrl" value="<?php echo isset($config['ServiceUrl'])?$config['ServiceUrl']:''; ?>" /></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">客服QQ：</td>
                            <td align="left" bgcolor="#FFFFFF"><textarea style="width:300px;height:110px;resize:none" name="ServiceQQ"><?php echo isset($config['ServiceQQ'])?implode(PHP_EOL, $config['ServiceQQ']):''; ?></textarea> * 一行一个</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">微信二维码：</td>
                            <td align="left" bgcolor="#FFFFFF" class="set-image"><span class="img"><?php echo !isset($config['WeChatQrCode'])||empty($config['WeChatQrCode'])?'未设置':'<input type="hidden" name="WeChatQrCode" value="'.$config['WeChatQrCode'].'"><img src="'.$config['WeChatQrCode'].'" style="max-height:100px">'; ?></span><br /><input type="button" value="取消设置" data-reset="true">&nbsp;<input type="button" value="设置新图片" data-name="WeChatQrCode"></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">服务条款：</td>
                            <td align="left" bgcolor="#FFFFFF"><textarea style="width:300px;height:110px;resize:none" name="ServiceRule"><?php echo isset($config['ServiceRule'])?implode(PHP_EOL, $config['ServiceRule']):''; ?></textarea> * 一行一条</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">代理佣金简要提示：</td>
                            <td align="left" bgcolor="#FFFFFF"><textarea style="width:300px;height:110px;resize:none" name="Tips"><?php echo isset($config['Tips'])?implode(PHP_EOL, $config['Tips']):''; ?></textarea> * 电脑端代理佣金上端提示文字，最多三行</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">有效直属会员：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" class="textfield" size="8" name="ValidMember" value="<?php echo isset($config['ValidMember'])?$config['ValidMember']:''; ?>" /> 天 <span style="color:red">“有效直属会员”指设定天数内有进行有效存款的会员，0为不限制</span></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">有效直属会员特别说明：</td>
                            <td align="left" bgcolor="#FFFFFF" style="color:red">1.系统统计数据前将对直属会员进行判断，不属于有效直属会员的记录将被忽略（即不被统计并且不被保存到统计数据）；<br />2.修改后代理报表不能即时更新，需要等待系统重新生成报表数据（仅最近30天统计数据）</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">游戏数量：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" class="textfield" size="8" name="GameCount" value="<?php echo isset($config['GameCount'])?$config['GameCount']:''; ?>" /> 种 * 显示效果，无实际作用</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">代理数量：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" class="textfield" size="8" name="AgentCount" value="<?php echo isset($config['AgentCount'])?$config['AgentCount']:''; ?>" /> 位 * 显示效果，无实际作用</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">平均出款：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" class="textfield" size="8" name="AvgCheckout" value="<?php echo isset($config['AvgCheckout'])?$config['AvgCheckout']:''; ?>" /> 元 * 显示效果，无实际作用</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF">新注册会员：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" class="textfield" size="8" name="NewMember" value="<?php echo isset($config['NewMember'])?$config['NewMember']:''; ?>" /> 位 * 显示效果，无实际作用</td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#FFFFFF">&nbsp;</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="submit" class="submit80" value="保存" /></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</div>
</body>
</html>