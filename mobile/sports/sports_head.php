 <!----tab-----> 
<li class="ui-li-static ui-body-inherit ui-first-child"> 
  <div data-role="controlgroup" data-type="horizontal" class="ui-controlgroup ui-controlgroup-horizontal ui-corner-all" style="width:235px;float:left;"> 
	  <a id="ds_tab" href="javascript:void(0);" data-ajax="false" data-role="button" data-mini="true" data-corners="false" data-shadow="false"<?=$sporttab=='ds_tab' ? 'style="color:#f60;"' : '';?> class="ui-link ui-btn ui-mini ui-first-child" role="button">单式投注</a> 
	  <a id="cg_tab" href="javascript:void(0);" data-ajax="false" data-role="button" data-mini="true" data-corners="false" data-shadow="false"<?=$sporttab=='cg_tab' ? 'style="color:#f60;"' : '';?> class="ui-link ui-btn ui-mini" role="button">串关投注</a> 
	  <a id="gq_tab"  href="javascript:void(0);" data-ajax="false" data-role="button" data-mini="true" data-corners="false" data-shadow="false"<?=$sporttab=='gq_tab' ? 'style="color:#f60;"' : '';?> class="ui-link ui-btn ui-mini ui-last-child" role="button">滚球投注</a> 
  </div>
<?php 
$array_temp = explode('_', $sportpage);
if ($array_temp[0] != 'result'){
?>
  <div data-role="controlgroup" data-type="horizontal" class="ui-controlgroup ui-controlgroup-horizontal ui-corner-all"  style="width:90px;float:right;"> 
	  <a href="javascript:re_load();" data-ajax="false" data-role="button" data-mini="true" data-corners="false" data-shadow="false" class="ui-link ui-btn ui-mini ui-first-child ui-last-child" role="button">刷新<span id="sporttime"><?=$sporttime;?></span></a> 
  </div>
<?php }?> 
</li> 
<script type="text/javascript"> 
function select_ds_tab(){ 
  $("#ds_tab").css("color","#f60");
  $("#cg_tab").css("color","");
  $("#gq_tab").css("color","");
  $("#ds_div").css("display","");
  $("#cg_div").css("display","none");
  $("#gq_div").css("display","none");
} 
function select_cg_tab(){ 
  $("#ds_tab").css("color","");
  $("#cg_tab").css("color","#f60");
  $("#gq_tab").css("color","");
  $("#ds_div").css("display","none");
  $("#cg_div").css("display","");
  $("#gq_div").css("display","none");
} 
function select_gq_tab(){ 
  $("#ds_tab").css("color","");
  $("#cg_tab").css("color","");
  $("#gq_tab").css("color","#f60");
  $("#ds_div").css("display","none");
  $("#cg_div").css("display","none");
  $("#gq_div").css("display","");
} 

var sportpage = '<?=$sportpage;?>';

if(sportpage=="index"){ 
  $("#ds_tab").click(function(){ 
	  select_ds_tab();
  });
  $("#cg_tab").click(function(){ 
	  select_cg_tab();
  });
  $("#gq_tab").click(function(){ 
	  select_gq_tab();
  });
}else{ 
  $("#ds_tab").click(function(){ 
	  window.open("index.php?sporttab=ds_tab", "_self");
  });
  $("#cg_tab").click(function(){ 
	  window.open("index.php?sporttab=cg_tab", "_self");
  });
  $("#gq_tab").click(function(){ 
	  window.open("index.php?sporttab=gq_tab", "_self");
  });
} 

function re_load(){ 
  if(sportpage=="index"){ 
	  index_load();
  }else{ 
	  var aaaaa = $('#aaaaa').val();
	  var league = $('#league').val();
	  loaded(league,aaaaa,"0") 
  } 
  window.clearTimeout(forbeginrefresh);
  sporttime =<?=$sporttime;?>;
  sporttime -= 1;
  $('#sporttime').html(sporttime);
  forbeginrefresh = setTimeout("beginrefresh()",1000);
} 

var sporttime =<?=$sporttime;?>;
var forbeginrefresh = '';
function beginrefresh() { 
  if (sporttime==1) { 
	  re_load();
  } else { 
	  sporttime -= 1;
	  $('#sporttime').html(sporttime);
	  forbeginrefresh = setTimeout("beginrefresh()",1000);
  } 
} 
beginrefresh();
</script>
<?php 
$array_temp = explode('_', $sportpage);
if (($array_temp[0] != 'cg') && ($sporttab != 'cg_tab')){
	$_SESSION['cg_for_message'] = NULL;
}
?>