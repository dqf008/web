<?php 
require_once dirname(__FILE__) . '/conjunction.php';
$nana = 1;
$result = $mydata2_db->query('select * from ka_kithe order by nn desc LIMIT 1');
$row = $result->fetch();
$id = $row['id'];
$nn = $row['nn'];
$nd = $row['nd'];
$zfbdate = $row['zfbdate'];
$zfbdate1 = $row['zfbdate1'];
$kitm1 = $row['kitm1'];
$kizt1 = $row['kizt1'];
$kizm1 = $row['kizm1'];
$kizm61 = $row['kizm61'];
$kigg1 = $row['kigg1'];
$kilm1 = $row['kilm1'];
$kisx1 = $row['kisx1'];
$kibb1 = $row['kibb1'];
$kiws1 = $row['kiws1'];
$nana = $row['na'];
if ($row['zfb'] == 0){
?> 
<button onClick="javascript:location.href='index.php?action=top&ids=特码&fen=fen&fid=1';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm1 STYLE='color:ff0000;'>特码已封盘</span></button>&nbsp;<button onClick="javascript:location.href='index.php?action=top&ids=正码&fen=fen&fid=1';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:ff0000;'>正码已封盘</span></button>
<? }else{

if ($row['kitm']==0){
?>

<button onClick="javascript:location.href='index.php?action=top&ids=特码&fen=fen&fid=1';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm1 STYLE='color:ff0000;'>特码已封盘</span></button>&nbsp;
<? }else{?><button onClick="javascript:location.href='index.php?action=top&ids=特码&fen=fen&fid=0';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm1 STYLE='color:0000ff;'>特码已开盘</span></button>&nbsp;<? }
if ($row['kizt']==0  && $row['kizm']==0  && $row['kibb']==0  && $row['kiws']==0  && $row['kizm6']==0  && $row['kisx']==0  && $row['kigg']==0  && $row['kilm']==0){
?>
<button onClick="javascript:location.href='index.php?action=top&ids=正码&fen=fen&fid=1';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:ff0000;'>正码已封盘</span></button>
<? }else{?>
<button onClick="javascript:location.href='index.php?action=top&ids=正码&fen=fen&fid=0';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:0000ff;'>正码已开盘</span></button>
<? }?>

<? }
if(file_exists('../../cache/lot_marksix.php')){
    $_marksix = include('../../cache/lot_marksix.php');
    !isset($_marksix['auto_close'])&&$_marksix['auto_close'] = 900;
}
if(isset($_marksix['auto_open'])){
?>&nbsp;<button onclick="window.location.href='index.php?action=top&amp;auto=open&amp;enable=false';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:0000ff;'>已启用自动开盘</span></button>&nbsp;<button onclick="var auto_close = prompt('依照官方停止投注时间（21:15）进行加减，单位：秒，例如21:30封盘，则填入900，21:00封盘，则填入-900，建议最高不超过900秒（21:30分）', <?php echo $_marksix['auto_close']; ?>);if(auto_close!=undefined&amp;&amp;auto_close!=''){window.location.href='index.php?action=top&amp;auto=time&amp;time='+auto_close}"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:0000ff;'>设置封盘时间</span></button><?
    if(isset($_marksix['auto_check'])){
    ?>&nbsp;<button onclick="window.location.href='index.php?action=top&amp;auto=check&amp;enable=false';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:0000ff;'>已启用自动结算</span></button><?
    }else{
    ?>&nbsp;<button onclick="window.location.href='index.php?action=top&amp;auto=check&amp;enable=true';"  class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:ff0000;'>已停用自动结算</span></button><?
    }
}else{
?>&nbsp;<button onclick="if(confirm('继续开启将清除已预设期号，是否继续？')){window.location.href='index.php?action=top&amp;auto=open&amp;enable=true'}" class="but_c1" onMouseOut="this.className='but_c1'" onMouseOver="this.className='but_c1M'" style="height:22" ;><SPAN id=rtm2 STYLE='color:ff0000;'>已停用自动开盘</span></button><?
}
