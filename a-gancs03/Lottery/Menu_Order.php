<?php include_once 'A_Menu_Order.php'; ?>
<table width="100%" id="second_menu_ssc" border="0" align="center" cellpadding="5" cellspacing="1" class="font12"
       bgcolor="#798EB9">
    <tr>
        <td align="center" bgcolor="#3C4D82" style="color:#FFF">
            <a id="ssc011" href="Order.php?js=0" class="ssc_curr">重庆时时彩</a>  -
            <a id="ssc012" href="Order_tjssc.php?js=0" class="ssc_com">天津时时彩</a>  -
            <a id="ssc013" href="Order_xjssc.php?js=0" class="ssc_com">新疆时时彩</a>
        </td>
    </tr>
</table>
<table width="100%" id="second_menu_choose5" border="0" align="center" cellpadding="5" cellspacing="1" class="font12"
       bgcolor="#798EB9">
    <tr>
        <td align="center" bgcolor="#3C4D82" style="color:#FFF">
            <a id="ssc021" href="Order_choose5.php?lottery_type=gdchoose5&js=0" class="ssc_curr">广东11选5</a>  -
            <a id="ssc022" href="Order_choose5.php?lottery_type=sdchoose5&js=0" class="ssc_com">山东11选5</a>  -
            <a id="ssc023" href="Order_choose5.php?lottery_type=fjchoose5&js=0" class="ssc_com">福建11选5</a>  -
            <a id="ssc024" href="Order_choose5.php?lottery_type=bjchoose5&js=0" class="ssc_com">北京11选5</a>  -
            <a id="ssc025" href="Order_choose5.php?lottery_type=ahchoose5&js=0" class="ssc_com">安徽11选5</a>
        </td>
    </tr>
</table>

<table width="100%" id="second_menu_klsf" border="0" align="center" cellpadding="5" cellspacing="1" class="font12"
       bgcolor="#798EB9">
    <tr>
        <td align="center" bgcolor="#3C4D82" style="color:#FFF">
            <a id="ssc031" href="Order3.php?lottery_type=gdkl10&js=0" class="ssc_curr">广东快乐10分</a>  -
            <a id="ssc032" href="Order3.php?lottery_type=cqkl10&js=0" class="ssc_com">重庆快乐10分</a>  -
            <a id="ssc033" href="Order3.php?lottery_type=tjkl10&js=0" class="ssc_com">天津快乐10分</a>  -
            <a id="ssc034" href="Order3.php?lottery_type=hnkl10&js=0" class="ssc_com">湖南快乐10分</a>  -
            <a id="ssc035" href="Order3.php?lottery_type=sxkl10&js=0" class="ssc_com">山西快乐10分</a>  -
            <a id="ssc036" href="Order3.php?lottery_type=ynkl10&js=0" class="ssc_com">云南快乐10分</a>
        </td>
    </tr>
</table>
  
  <script type="text/javascript">
      var curr_url = document.URL.toLowerCase();
      $("#ssc01").removeClass();
      $("#ssc011").removeClass();
      $("#ssc012").removeClass();
      $("#ssc013").removeClass();
      $("#ssc02").removeClass();
      $("#ssc021").removeClass();
      $("#ssc022").removeClass();
      $("#ssc023").removeClass();
      $("#ssc024").removeClass();
      $("#ssc025").removeClass();
      $("#ssc03").removeClass();
      $("#ssc031").removeClass();
      $("#ssc032").removeClass();
      $("#ssc033").removeClass();
      $("#ssc034").removeClass();
      $("#ssc035").removeClass();
      $("#ssc036").removeClass();
      $("#ssc04").removeClass();
      $("#ssc05").removeClass();
      $("#second_menu_ssc").hide();
      $("#second_menu_choose5").hide();
      $("#second_menu_klsf").hide();
      if (curr_url.indexOf("order.php") != -1) {
          $("#ssc01").addClass("ssc_curr");
          $("#ssc011").addClass("ssc_curr");
          $("#ssc012").addClass("ssc_com");
          $("#ssc013").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_ssc").show();
      } else if (curr_url.indexOf('order_tjssc.php') != -1) {
          $("#ssc01").addClass("ssc_curr");
          $("#ssc011").addClass("ssc_com");
          $("#ssc012").addClass("ssc_curr");
          $("#ssc013").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_ssc").show();
      } else if (curr_url.indexOf('order_xjssc.php') != -1) {
          $("#ssc01").addClass("ssc_curr");
          $("#ssc011").addClass("ssc_com");
          $("#ssc012").addClass("ssc_com");
          $("#ssc013").addClass("ssc_curr");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_ssc").show();
      } else if (curr_url.indexOf("order3.php?lottery_type=gdkl10") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_curr");
          $("#ssc031").addClass("ssc_curr");
          $("#ssc032").addClass("ssc_com");
          $("#ssc033").addClass("ssc_com");
          $("#ssc034").addClass("ssc_com");
          $("#ssc035").addClass("ssc_com");
          $("#ssc036").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_klsf").show();
      } else if (curr_url.indexOf("order3.php?lottery_type=cqkl10") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_curr");
          $("#ssc031").addClass("ssc_com");
          $("#ssc032").addClass("ssc_curr");
          $("#ssc033").addClass("ssc_com");
          $("#ssc034").addClass("ssc_com");
          $("#ssc035").addClass("ssc_com");
          $("#ssc036").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_klsf").show();
      } else if (curr_url.indexOf("order3.php?lottery_type=tjkl10") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_curr");
          $("#ssc031").addClass("ssc_com");
          $("#ssc032").addClass("ssc_com");
          $("#ssc033").addClass("ssc_curr");
          $("#ssc034").addClass("ssc_com");
          $("#ssc035").addClass("ssc_com");
          $("#ssc036").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_klsf").show();
      } else if (curr_url.indexOf("order3.php?lottery_type=hnkl10") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_curr");
          $("#ssc031").addClass("ssc_com");
          $("#ssc032").addClass("ssc_com");
          $("#ssc033").addClass("ssc_com");
          $("#ssc034").addClass("ssc_curr");
          $("#ssc035").addClass("ssc_com");
          $("#ssc036").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_klsf").show();
      } else if (curr_url.indexOf("order3.php?lottery_type=sxkl10") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_curr");
          $("#ssc031").addClass("ssc_com");
          $("#ssc032").addClass("ssc_com");
          $("#ssc033").addClass("ssc_com");
          $("#ssc034").addClass("ssc_com");
          $("#ssc035").addClass("ssc_curr");
          $("#ssc036").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_klsf").show();
      } else if (curr_url.indexOf("order3.php?lottery_type=ynkl10") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_curr");
          $("#ssc031").addClass("ssc_com");
          $("#ssc032").addClass("ssc_com");
          $("#ssc033").addClass("ssc_com");
          $("#ssc034").addClass("ssc_com");
          $("#ssc035").addClass("ssc_com");
          $("#ssc036").addClass("ssc_curr");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_klsf").show();
      } else if (curr_url.indexOf("order4.php") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_curr");
          $("#ssc05").addClass("ssc_com");
      } else if (curr_url.indexOf("order8.php") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_curr");
      } else if (curr_url.indexOf("order_choose5.php?lottery_type=gdchoose5") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_curr");
          $("#ssc021").addClass("ssc_curr");
          $("#ssc022").addClass("ssc_com");
          $("#ssc023").addClass("ssc_com");
          $("#ssc024").addClass("ssc_com");
          $("#ssc025").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_choose5").show();
      } else if (curr_url.indexOf("order_choose5.php?lottery_type=sdchoose5") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_curr");
          $("#ssc021").addClass("ssc_com");
          $("#ssc022").addClass("ssc_curr");
          $("#ssc023").addClass("ssc_com");
          $("#ssc024").addClass("ssc_com");
          $("#ssc025").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_choose5").show();
      } else if (curr_url.indexOf("order_choose5.php?lottery_type=fjchoose5") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_curr");
          $("#ssc021").addClass("ssc_com");
          $("#ssc022").addClass("ssc_com");
          $("#ssc023").addClass("ssc_curr");
          $("#ssc024").addClass("ssc_com");
          $("#ssc025").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_choose5").show();
      } else if (curr_url.indexOf("order_choose5.php?lottery_type=bjchoose5") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_curr");
          $("#ssc021").addClass("ssc_com");
          $("#ssc022").addClass("ssc_com");
          $("#ssc023").addClass("ssc_com");
          $("#ssc024").addClass("ssc_curr");
          $("#ssc025").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_choose5").show();
      } else if (curr_url.indexOf("order_choose5.php?lottery_type=ahchoose5") != -1) {
          $("#ssc01").addClass("ssc_com");
          $("#ssc02").addClass("ssc_curr");
          $("#ssc021").addClass("ssc_com");
          $("#ssc022").addClass("ssc_com");
          $("#ssc023").addClass("ssc_com");
          $("#ssc024").addClass("ssc_com");
          $("#ssc025").addClass("ssc_curr");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_choose5").show();
      } else {
          $("#ssc01").addClass("ssc_curr");
          $("#ssc011").addClass("ssc_curr");
          $("#ssc012").addClass("ssc_com");
          $("#ssc013").addClass("ssc_com");
          $("#ssc02").addClass("ssc_com");
          $("#ssc03").addClass("ssc_com");
          $("#ssc04").addClass("ssc_com");
          $("#ssc05").addClass("ssc_com");
          $("#second_menu_ssc").show();
      }
  </script>