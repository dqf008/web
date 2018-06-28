<?php !defined('IN_LOT')&&die('Access Denied'); ?>
        </div>
        <object style="height:0;width:0;overflow:hidden" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="0" height="0" id="asound" align="absmiddle">
            <param name="allowScriptAccess" value="sameDomain">
            <param name="movie" value="static/other/asound.swf?v=20161011">
            <param name="quality" value="high">
            <embed src="static/other/asound.swf?v=20161011" quality="high" width="0" height="0" name="asound" align="absmiddle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
        </object>
        <script type="text/javascript">
            $(document.body).ready(function(){
                var i = null;
                window.location.href.indexOf("rule=true")>=0&&(i = setInterval(function(){
                    $(".ui-popup").size()>0 ? clearInterval(i) : $(".icon-rule").parent().trigger("click")
                }, 100))
            })
            var $id,$lottery,$host,$host1,$url;
            $id      = $(".group_wrap .group_active").attr("id");
            $lottery = $id.substr(4);
            $host1   = "http://kj.igame007.net/";
            $host    = $host1+"html/";
            if($lottery == "pk10"){
                $url = $host+"PK10/pk10kai.html";
            }else if($lottery == "jssc"){
                $url = $host+"jisusaiche/pk10kai.html";
            }else if($lottery == "xyft"){
                $url = $host+"xingyft/pk10kai.html";
            }else if($lottery == "cqssc"){
                $url = $host+"shishicai_cq/ssc_index.html";
            }else if($lottery == "tjssc"){
                $url = $host+"shishicai_tj/ssc_index.htm";
            }else if($lottery == "xjssc"){
                $url = $host+"shishicai_xj/ssc_index.htm";
            }else if($lottery == "jsssc"){
                $url = $host+"shishicai_jisu/ssc_index.html";
            }else if($lottery == "jsk3"){
                $url = $host+"kuai3_jiangsu/kuai3_index.html";
            }else if($lottery == "fjk3"){
                $url = $host+"kuai3_fujian/kuai3_index.html";
            }else if($lottery == "gxk3"){
                $url = $host+"kuai3_guangxi/kuai3_index.html";
            }else if($lottery == "ahk3"){
                $url = $host+"kuai3_anhui/kuai3_index.html";
            }else if($lottery == "shk3"){
                $url = $host+"kuai3_shanghai/kuai3_index.html";
            }else if($lottery == "hbk3"){
                $url = $host+"kuai3_hubei/kuai3_index.html";
            }else if($lottery == "hebk3"){
                $url = $host+"kuai3_hebei/kuai3_index.html";
            }else if($lottery == "jlk3"){
                $url = $host+"kuai3_jiling/kuai3_index.html";
            }else if($lottery == "gzk3"){
                $url = $host+"kuai3_guizhou/kuai3_index.html";
            }else if($lottery == "bjk3"){
                $url = $host+"kuai3_beijing/kuai3_index.html";
            }else if($lottery == "gsk3"){
                $url = $host+"kuai3_gansu/kuai3_index.html";
            }else if($lottery == "nmgk3"){
                $url = $host+"kuai3_neimenggu/kuai3_index.html";
            }else if($lottery == "jxk3"){
                $url = $host+"kuai3_jiangxi/kuai3_index.html";
            }else if($lottery == "ffk3"){
                $url = $host+"kuai3_fenfen/kuai3_index.html";
            }else if($lottery == "sfk3"){
                $url = $host+"kuai3_chaoji/kuai3_index.html";
            }else if($lottery == "wfk3"){
                $url = $host+"kuai3_haoyun/kuai3_index.html";
            }else if($lottery == "pcdd"){
                $url = $host+"PC_egxy28/PC_egxy28index.html";
            }else if($lottery == "kl8"){
                $url = $host+"beijinkl8/bjkl8_index.html";
            }else if($lottery == "jslh"){
                $url = $host+"jslh/index.html";
            }else if($lottery == "marksix"){
                $url = $host1+"MarkSix/";
            }else if($lottery == "gdkl10"){
                $url = $host+"klsf/klsf_index.html";
            }else if($lottery == "cqkl10"){
                $url = $host+"klsf_chongqing/klsf_index.html";
            }else if($lottery == "tjkl10"){
                $url = $host+"klsf_tianjin/klsf_index.html";
            }else if($lottery == "hnkl10"){
                $url = $host+"klsf_hunan/klsf_index.html";
            }else if($lottery == "sxkl10"){
                $url = $host+"klsf_shanxi/klsf_index.html";
            }else if($lottery == "ynkl10"){
                $url = $host+"klsf_yunnan/klsf_index.html";
            }else if($lottery == "gdchoose5"){
                $url = $host+"shiyix5_gd/index.html";
            }else if($lottery == "sdchoose5"){
                $url = $host+"shiyix5_sd/index.html";
            }else if($lottery == "fjchoose5"){
                $url = $host+"shiyix5_fj/index.html";
            }else if($lottery == "bjchoose5"){
                $url = $host+"shiyix5_bj/index.html";
            }else if($lottery == "ahchoose5"){
                $url = $host+"shiyix5_anhui/index.html";
            }else if($lottery == "qxc"){
                $url = $host+"tc7xc/index.html";
            }else if($lottery == "shssl"){
                $url = $host+"shssl/ssl_index.html";
            }else if($lottery == "pl3"){
                $url = $host+"tcpl3/index.html";
            }else if($lottery == "3d"){
                $url = $host+"fc3D/index.html";
            }
            $("#nav a.openUrl").click(function(){
                $(this).attr("href",$url)
            })
        </script>

    </body>
</html>