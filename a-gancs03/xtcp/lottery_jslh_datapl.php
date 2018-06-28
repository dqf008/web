<?php 
header('Content-Type:text/html;charset=utf-8');
include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('cpgl');
check_quanxian('cpkj');
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
    <script type="text/javascript" charset="utf-8" src="/js/calendar.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".font12:first").on("click", "input[type=button]", function(){
                var t = $(this), e = t.closest(".font12"), v = e.find("input[type=text]"), l = e.siblings(".font12"), z = function(t, s){
                    return t = t.toString(), s = s.toString(), t.length>=s.length ? t : (s+t).substring(t.length)
                };
                switch(t.data("action")){
                    case "start":
                        var q = v.eq(0).val(), s = v.eq(1).val(), f = function(){
                            l.find("tr").not(":first, :hidden").remove(),
                            $(".loading").show().find("div").css("width", "0"),
                            l.show(),
                            v.attr("disabled", true),
                            t.data("i", 0).data("action", "continue").trigger("click")
                        };
                        !q.match(/^[1-9]\d{10}$/)||parseInt(q.substring(8))>960||parseInt(q.substring(8))<1 ? alert("请正确填写彩票期号") : (!s.match(/^[1-9]\d*$/)||parseInt(s)<1||parseInt(s)>9600 ? alert("请设定添加期数，最少 1 期，最多 9600 期") : f());
                    break;
                    case "pause":
                        t.val("继续").data("action", "continue");
                    break;
                    case "continue":
                        var q = v.eq(0).val(), s = v.eq(1).val(), r = new Date(), i = parseInt(t.data("i")), y = q.substring(0, 4), m = parseInt(q.substring(4, 6))-1, d = q.substring(6, 8), n = parseInt(q.substring(8)), f = function(){
                            var x;
                            n+i>960&&(r.setDate(parseInt(r.getDate())+Math.floor((n+i)/960), n-= 960*Math.floor((n+i)/960))),
                            y = z(r.getFullYear(), "0000"),
                            y+= z(r.getMonth()+1, "00"),
                            y+= z(r.getDate(), "00"),
                            y+= z(n+i, "000"),
                            i+1>s ? (alert("批量添加完成"), t.siblings("input").trigger("click")) : t.data("action")=="pause"&&(
                            x = m.clone().show(),
                            x.find("td:first").html(y),
                            m.after(x),
                            t.siblings("span").html("当前进度: "+(i+1)+"/"+s),
                            $(".loading").find("div").css("width", ((i+1)/s*100)+"%"),
                            $.post("lottery_jslh_data.php", {action: "random", qishu: y, history: true}, function(d){
                                if(d["status"]=="success"){
                                    $.each(d["msg"][0], function(i, v){
                                        x.find("td[data-type]").eq(i).html("<img src=\"../lotto/images/num"+v+".gif\" />")
                                    }),
                                    x.find("td:last p:last").html(d["msg"][1]),
                                    $.post("lottery_jslh_data.php", {action: "save", qishu: y, opencode: d["msg"][0]}, function(d){
                                        if(d["status"]=="success"){
                                            x.find("td:last p:first").html("添加成功")
                                        }else{
                                            x.find("td:last p:first").html(typeof(d["msg"])!="undefined"?d["msg"]:"系统错误").css("color", "red")
                                            // , t.siblings("input").trigger("click")
                                        }
                                        i++,
                                        t.data("i", i),
                                        f()
                                    }, "json")
                                }else{
                                    x.find("td:last p:first").html(typeof(d["msg"])!="undefined"?d["msg"]:"系统错误").css("color", "red")
                                    // , t.siblings("input").trigger("click")
                                }
                            }, "json"))
                        };
                        r.setFullYear(y, m, d),
                        m = l.find("tr:first").next(),
                        t.val("暂停").data("action", "pause"),
                        f();
                    break;
                    case "stop":
                        $(".loading").hide(),
                        v.attr("disabled", false),
                        t.siblings("input").val("开始").data("action", "start"),
                        t.siblings("span").html("");
                    break;
                }
            })
        });
    </script>
</head>
<body>
    <div id="pageMain">
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
                <td valign="top">
                    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="font12" bgcolor="#798EB9">
                        <tr>
                            <td align="center" bgcolor="#3C4D82" style="color:#FFF" colspan="2">
                                <a id="ssc01" href="lottery_jssc_data.php" class="menu_com">极速赛车</a> -
                                <a id="ssc02" href="lottery_jsssc_data.php" class="menu_com">极速时时彩</a> -
                                <a id="ssc03" href="lottery_jslh_data.php" class="menu_curr">极速六合</a> -
                                <a id="ssc04" href="lottery_ffk3_data.php" class="menu_com">分分快3</a> -
                                <a id="ssc05" href="lottery_sfk3_data.php" class="menu_com">超级快3</a> -
                                <a id="ssc06" href="lottery_wfk3_data.php" class="menu_com">好运快3</a>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">开始期号：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" /></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#F0FFFF" width="100">添加期数：</td>
                            <td align="left" bgcolor="#FFFFFF"><input type="text" size="5" /> 期 <span style="color:red">最多 9600 期，超出请多次进行添加</span></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#FFFFFF" width="100">&nbsp;</td>
                            <td align="left" bgcolor="#FFFFFF">
                                <input type="button" class="submit80" value="开始" data-action="start" />
                                <input type="button" class="submit80" value="停止" data-action="stop" />
                                <span></span>
                            </td>
                        </tr>
                        <tr style="display:none" class="loading">
                            <td align="right" colspan="2" style="background-color:#fff;height:3px;padding:0"><div style="background-color:#fc9c34;height:3px;width:0;line-height:3px;float:left"></div></td>
                        </tr>
                    </table>
                    <table border="0" align="center" cellspacing="1" cellpadding="5" width="100%" class="font12" style="margin-top:5px;display:none" bgcolor="#798EB9">
                        <tr style="background-color:#3C4D82;color:#FFF">
                            <td height="22" align="center"><strong>期数</strong></td>
                            <td height="22" align="center"><strong>正码1</strong></td>
                            <td height="22" align="center"><strong>正码2</strong></td>
                            <td height="22" align="center"><strong>正码3</strong></td>
                            <td height="22" align="center"><strong>正码4</strong></td>
                            <td height="22" align="center"><strong>正码5</strong></td>
                            <td height="22" align="center"><strong>正码6</strong></td>
                            <td height="22" align="center"><strong>特码</strong></td>
                            <td height="22" align="center"><strong>状态/统计</strong></td>
                        </tr>
                        <tr onmouseover="this.style.backgroundColor='#EBEBEB'" onmouseout="this.style.backgroundColor='#ffffff'" style="background-color:#FFFFFF;line-height:20px;display:none">
                            <td align="center"></td>
                            <td align="center" data-type="ball">--</td>
                            <td align="center" data-type="ball">--</td>
                            <td align="center" data-type="ball">--</td>
                            <td align="center" data-type="ball">--</td>
                            <td align="center" data-type="ball">--</td>
                            <td align="center" data-type="ball">--</td>
                            <td align="center" data-type="ball">--</td>
                            <td align="center">
                                <p>正在处理</p>
                                <p>暂无数据</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>