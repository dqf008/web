<?php 
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
check_quanxian('xtgl');
$disabled = array();
$cachefile = '../../cache/egame.php';
file_exists($cachefile)&&$disabled = include($cachefile);
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['is_disabled'])&&is_array($_POST['is_disabled'])){
        foreach($_POST['is_disabled'] as $val){
            if(isset($disabled[$val])){
                unset($disabled[$val]);
            }
        }
    }
    if(isset($_POST['disabled'])&&is_array($_POST['disabled'])){
        foreach($_POST['disabled'] as $val){
            $disabled[$val] = 1;
        }
    }
    file_put_contents($cachefile, '<?php'.PHP_EOL.'return unserialize(\''.serialize($disabled).'\');');
    message('保存成功！');
    exit;
}
$baseUri = 'http://egame.agin7223.com/js/family/%s.json';
$pid = array('XIN', 'MG', 'PT', /*'NYX', 'PNG', 'TTG', */'ENDO');
$gametype = isset($_GET['gametype'])&&in_array($_GET['gametype'], $pid)?$_GET['gametype']:$pid[0];
$gamename = isset($_GET['gamename'])?$_GET['gamename']:'';
$gamelist = array('game' => array(), 'lastest' => 0);
$cachefile = '../../cache/egame_'.$gametype.'.php';
file_exists($cachefile)&&$gamelist = include($cachefile);
if($gamelist['lastest']+43200<time()){
    $opts = array(
       'http' => array(
            'method' => 'GET',
            'header' => "Accept: */*".
                        //"Accept-Encoding: gzip".
                        "Accept-Language: zh-CN".
                        "Host: egame.agin7223.com".
                        "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36",
        )
    );
    $cxContext = stream_context_create($opts);
    if($rows = file_get_contents(sprintf($baseUri, $gametype), false, $cxContext)){
        if($rows = json_decode($rows, true)){
            $rows['new'] = array('game' => array(), 'lastest' => time());
            foreach($rows['game'] as $val){
                $rows['new']['game'][$val['id']] = array(
                    'gametype' => str_replace(array('"', '\''), array('&quot;', '&apos;'), $val['gametype']),
                    'zh' => str_replace(array('"', '\''), array('&quot;', '&apos;'), $val['zh']),
                    'en' => str_replace(array('"', '\''), array('&quot;', '&apos;'), $val['en']),
                    'tr' => str_replace(array('"', '\''), array('&quot;', '&apos;'), $val['tr']),
                );
            }
            $gamelist = $rows['new'];
            file_put_contents($cachefile, '<?php'.PHP_EOL.'return unserialize(\''.serialize($rows['new']).'\');');
        }
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
      <title>Welcome</title> 
      <link rel="stylesheet" href="../images/css/admin_style_1.css" type="text/css" media="all" /> 
      <script type="text/javascript" charset="utf-8" src="/js/jquery.js" ></script> 
      <script language="JavaScript" src="/js/calendar.js"></script> 
  </head> 
  <body> 
  <div id="pageMain"> 
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="font12" style="border:1px solid #798EB9;"> 
          <form name="form1" method="get" action="">
          <tr bgcolor="#FFFFFF"> 
          <td align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;
             <select name="gametype" id="gametype"> 
<?php foreach($pid as $val){ ?>              <option value="<?php echo $val.($gametype==$val?'" selected="true':''); ?>"><?php echo $val; ?>电子游戏</option>
<?php } ?>            </select> 
            &nbsp;&nbsp;游戏名称：<input name="gamename" type="text" id="gamename" value="<?php echo $gamename; ?>" size="15">
            <input name="action" id="action" type="hidden" value="1">
                  &nbsp;<input name="find" type="submit" id="find" value="搜索"/> 
                  &nbsp;<span style="color:red">* 列表最后更新时间：<?php echo $gamelist['lastest']>0?date('Y-m-d H:i:s', $gamelist['lastest']):'更新失败'; ?>（12小时后可更新）</span>
              </td> 
          </tr> 
          </form> 
      </table>
      <form name="form1" method="post" action="">

    <table width="100%" border="0" cellpadding="5" cellspacing="1" class="font12" style="margin-top:5px;line-height:20px;" bgcolor="#798EB9"> 
          <tr align="center" style="background:#3C4D82;color:#ffffff;"> 
              <td></td> 
              <td>GameType</td> 
              <td>英文名称</td> 
              <td>简中名称</td> 
              <td>繁中名称</td> 
              <td>游戏状态</td> 
          </tr>
<?php
foreach($gamelist['game'] as $key=>$val){
    if($gamename==''||substr_count($val['en'], $gamename)>0||substr_count($val['zh'], $gamename)>0||substr_count($val['tr'], $gamename)>0){
        $is_disabled = isset($disabled[$val['gametype']]);
?>            <tr align="center" <?php if($is_disabled){ ?>style="background-color:#aee0f7;"<?php }else{ ?>onMouseOver="this.style.backgroundColor='#EBEBEB'" onMouseOut="this.style.backgroundColor='#ffffff'" style="background-color:#ffffff;"<?php } ?> onclick="$(this).find('input').attr('checked', !$(this).find('input').is(':checked'))"> 
                 <td><input type="checkbox" name="disabled[]" value="<?php echo $val['gametype']; ?>"<?php if($is_disabled){ ?> checked="true"<?php }else{ ?><?php } ?>><?php if($is_disabled){ ?><input type="hidden" name="is_disabled[]" value="<?php echo $val['gametype']; ?>" checked="true"><?php } ?></td> 
                 <td><?php echo $key; ?></td> 
                 <td><?php echo $val['en']; ?></td> 
                 <td><?php echo $val['zh']; ?></td> 
                 <td><?php echo $val['tr']; ?></td> 
                 <td><?php if($is_disabled){ ?>已禁止<?php }else{ ?>正常<?php } ?></td> 
            </tr>
<?php }} ?>
          <tr style="background:#ffffff"> 
              <td align="center"><a href="javascript:;" onclick="$('input[type=checkbox]').attr('checked', true)">全选</a> / <a href="javascript:;" onclick="$('input[type=checkbox]').each(function(){$(this).attr('checked', !$(this).is(':checked'))})">反选</a></td> 
              <td colspan="5"><input type="submit" value="保存"></td> 
          </tr>
    </table></form>
    </div> 
  </div> 
  </body> 
  </html>