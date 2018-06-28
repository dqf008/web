<?php
include __DIR__ . '/../class/Db.class.php';
$hotTypePath = $_SERVER['DOCUMENT_ROOT'].'/cache/hotType.php';
$db = new DB();
$hotList = array();
$sql = 'select * from webinfo where code="promotions" order by id desc';
$list = $db->query($sql);
foreach($list as $rows){
    $info = unserialize($rows['content']);
    $rows['images'] = str_replace('<p></p>','',str_replace('<p><br>','<p>',str_replace('<br></p>','</p>',$info[0])));
    $rows['sort'] = $info[2];
    $rows['content'] = $info[1];
    $rows['type'] = $info[3];
    $hotList[] = $rows;
}
usort($hotList, function($a, $b){
    $a = (int)$a['sort'];
    $b = (int)$b['sort'];
    if ($a == $b) return 0;
    return ($a > $b) ? -1 : 1;
});
if(file_exists($hotTypePath)){
    $hotTypes = json_decode(file_get_contents($hotTypePath), true);
}else{
    $hotTypes = [
        ["title"=>"真人活动"],
        ['title'=>'电子活动'],
        ['title'=>'彩票活动'],
        ['title'=>'历史活动']
    ];
    file_put_contents($hotTypePath, json_encode($hotTypes));
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/wangeditor@2.1.23/dist/css/wangEditor.min.css">
<style type="text/css">
    .wangEditor-container {
        position: relative;
        background-color: transparent;
        border: none;
    }
    html,body{ padding:0;  margin:0;color:#FFF;}
    .wangEditor-container,.MemberExclusive,.small,.wangEditor-txt{box-sizing: border-box}
    .wangEditor-container{width:100%;height:auto;padding:1%;min-height: 1000px}
    .wangEditor-txt{display:none;text-align:center;margin:5px auto;width:100%}
    .wangEditor-container .small{width:100%;height:150px;margin: 0 auto;margin-top:5px;overflow:hidden}
    .wangEditor-container .small a{display:block;width:100%;height:150px;margin: 0 auto;overflow:hidden;background-repeat:no-repeat;background-position:left top}
    .menu {font-size: 20px;margin: 10px 0 20px;<?=file_exists($_SERVER['DOCUMENT_ROOT'].'/cache/hottype')?'':'display: none;'?>}
    .menu span {cursor: pointer;display: inline-block;padding: 0 10px;}
    .menu .on {color:red;font-weight: bold}
</style>
<link href="hot.css" rel="stylesheet"/>
<body>
<div class="wangEditor-container">
    <div class="menu">
        <span class="on">所有活动</span><?php foreach($hotTypes as $v):?><span><?=$v['title']?></span><?php endforeach;?>
    </div>
    <?php foreach($hotList as $hot):?>
        <div class="MemberExclusive" type="<?=$hot['type']?>">
            <div class="small" style="cursor:pointer"><?=$hot['images']?></div>
            <div class="wangEditor-txt"><?=$hot['content']?></div>
        </div>
    <?php endforeach; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pym.js@1.3.2/dist/pym.v1.min.js"></script>
<script type="text/javascript">
    var pymChild = new pym.Child();
    $(".MemberExclusive .small").click(function(){
        if($(this).siblings(".wangEditor-txt").is(":hidden")){
            $(this).parent().siblings(".MemberExclusive").children(".wangEditor-txt").slideUp("fast");
            $(this).siblings(".wangEditor-txt").slideDown("fast", function(){
                pymChild.sendMessage('height', getHeight());
            });
        }else{
            $(this).siblings(".wangEditor-txt").slideUp("fast", function () {
            pymChild.sendMessage('height', getHeight());
            });
        }
    });
    $('.menu span').click(function(){
        $($(this).siblings()).removeClass('on');
        $(this).addClass('on');
        var type = $(this).html();
        if(type == '所有活动'){
            $('.MemberExclusive').show();
        }else{
            $('.MemberExclusive[type='+type+']').show();
            $('.MemberExclusive[type!='+type+']').hide();
        }
        $(".MemberExclusive .wangEditor-txt").hide();
        pymChild.sendMessage('height', getHeight());
    })
    function getHeight(){
        var height = $('.wangEditor-container').height()+30;
        if(height<1000) return 1000;
        return height;
    }
</script>
</body>