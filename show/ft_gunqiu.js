// JavaScript Document
var dbs  = null;
var data = null;
var window_hight    =   0; //窗口高度
var window_lsm      =   0; //窗口联赛名
var blurHash = new Object();
var ptype_arr=new Array();
blurHash["pg_txt"] = "N";
var gtype = "re";
var lives = 'N';//默认 我的收藏
var sort = 'T';//默认排序方式 T 时间  C联盟
var ids = "";

function loaded(league,thispage,p){
    var league = encodeURI(league);
    $("#sel_sort").click(function(){
        divOnBlur(document.getElementById("show_sort"),document.getElementById("sel_sort"));
    });
    initDivBlur_PFunction(document.getElementById("show_sort"),document.getElementById("sel_sort"));

    ids = "";
    if(lives == "Y"){
        var love = top.myLove[top.w_type][gtype];
        if(!love){
            love = new Array();
        }
        
        if(love.length>0){
            ids = love.join(",");
        }
    }

    $.getJSON("ft_gunqiu_data.php?leaguename="+league+"&CurrPage="+thispage+"&ids="+ids+"&sort="+sort+"&callback=?",function(json){
        
        var pagecount = json.fy.p_page;
        var page = json.fy.page;
        var fenye = "";
        window_hight    =   json.dh;
        window_lsm      =   json.lsm;

        var idss = json.ids;
        if(league==""){ //没有联盟选择情况下重置
            if(lives == "Y"){
                top.myLove[top.w_type][gtype] = new Array();
                if(idss != ""){
                    top.myLove[top.w_type][gtype] = idss.split(',');
                }
            }else{
                var lm = new Array();
                lm = top.myLove[top.w_type][gtype];
                if(typeof top.myLove[top.w_type][gtype]=='object'){
                    top.myLove[top.w_type][gtype] = new Array();
                    for(var j=0;j<lm.length;j++){
                        if(idss.indexOf(lm[j])>=0){
                            top.myLove[top.w_type][gtype].push(lm[j]);
                        }

                    }
                }

            }
        }
        if(dbs !=null)
        {
            if(thispage==0 && p!='p')
            {   
                data = dbs;
                dbs  = json.db;  
            }else{
                dbs  = json.db;  
                data = dbs;
            }
        }else{
            dbs  = json.db;
            data = dbs;
        }
        var showtableData = document.getElementById('showtableData').textContent;
        
        if(dbs == null){
            var NoDataTR = document.getElementById('NoDataTR').textContent;
            showtableData = showtableData.replace("*showDataTR*",NoDataTR);

        }else{
            var lsm = '';
            var dataAll = "";

            for(var i=0; i<dbs.length; i++){
                var onelayer = document.getElementById('DataTR').textContent;

                //--------------判斷聯盟名稱列顯示或隱藏----------------
                if (""+myLeg[dbs[i]["Match_Name"]]=="undefined"){
                        myLeg[dbs[i]["Match_Name"]]=dbs[i]["Match_Name"];
                        myLeg[dbs[i]["Match_Name"]]=new Array();
                        myLeg[dbs[i]["Match_Name"]][0]=dbs[i]["Match_Date"]+dbs[i]["Match_ID"];
                }else{
                        myLeg[dbs[i]["Match_Name"]][myLeg[dbs[i]["Match_Name"]].length]=dbs[i]["Match_Date"]+dbs[i]["Match_ID"];
                }

                if(lsm == dbs[i]["Match_Name"]){
                    onelayer=onelayer.replace("*ST*"," style='display: none;'  id='LEG_"+dbs[i]["Match_Date"]+dbs[i]["Match_ID"]+"'");
                }else{
                    lsm = dbs[i]["Match_Name"];
                    onelayer=onelayer.replace("*ST*"," style='display: ;' title='选择 >> "+lsm+"' id='LEG_"+dbs[i]["Match_Date"]+dbs[i]["Match_ID"]+"'");
                }
                
                //---------------------------------------------------------------------
                
                
                //--------------判斷聯盟底下的賽事顯示或隱藏----------------
                if (NoshowLeg[dbs[i]["Match_Name"]]==-1){
                    onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
                    onelayer=onelayer.replace("*LegMark*","class='bet_game_league_down'"); //聯盟的小圖箭頭向下
                }else{
                    onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
                    onelayer=onelayer.replace("*LegMark*","class='bet_game_league'");  //聯盟的小圖箭頭向上
                }
                //---------------------------------------------------------------------
              
                onelayer=onelayer.replace(/\*LEG\*/gi,lsm);
                
                onelayer=onelayer.replace(/\*ID_STR\*/g,dbs[i]["Match_Date"]+dbs[i]["Match_ID"]);
                onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");
                onelayer=onelayer.replace("*TR_TOP*","class='bet_game_tr_top'");
                onelayer=onelayer.replace("*DIS_DARW*","");
                onelayer=onelayer.replace("*TR_NUM*","3");
                onelayer=onelayer.replace("*PTYPE_DIS_DARW*","");
                onelayer=onelayer.replace("*PTYPE_TR_NUM*","4");

                //子盤隱藏和局
                onelayer=onelayer.replace(/\*NODARW\*/g,"");

                 
                if(dbs[i]["Match_Master"].indexOf('[中]')>0){
                    onelayer=onelayer.replace("*DISPLAY_MIDFIELD*", "style='display:'");
                }else{
                    onelayer=onelayer.replace("*DISPLAY_MIDFIELD*", "style='display:none'");
                }
                 
                //时间
                var tmpset=dbs[i]["Match_retimeset"].split("^");
                tmpset[1]=escape2Html(tmpset[1]).replace("<font style=background-color=red>","").replace("</font>","");
                
                var showretime="";
                if(tmpset[0]=="Start"){
                    //showretime=tmpset[1];
                    //showretime="-";
                }else if(tmpset[0]=="MTIME"){
                    showretime=tmpset[1];
                }else{
                    var tmpHtime=tmpset[0];
                    var showstr=tmpset[0].split("H");
                    if(showstr[0]=="1")tmpHtime='上半场';
                    if(showstr[0]=="2")tmpHtime='下半场';

                    showretime=tmpHtime+" <font class='rb_color'>"+tmpset[1]+"'</font>";
                }

                onelayer=onelayer.replace("*DATETIME*",showretime); 

                //当前比分
                scoreH = (dbs[i]["Match_ScoreH"] != '')?createTTClass(dbs[i]["Match_score_h"],"bet_score_og"):createTTClass(dbs[i]["Match_score_h"],"bet_score");
                scoreC = (dbs[i]["Match_ScoreC"] != '')?createTTClass(dbs[i]["Match_score_c"],"bet_score_og"):createTTClass(dbs[i]["Match_score_c"],"bet_score");

                onelayer=onelayer.replace("*SCORE*",scoreH+" - "+scoreC);
                onelayer=onelayer.replace("*TR_TOP*","class='bet_game_tr_top'");

                if (dbs[i]["Match_redcard_h"]*1 > 0){
                    onelayer=onelayer.replace("*REDCARD_H*",dbs[i]["Match_redcard_h"]);
                    onelayer=onelayer.replace("*REDCARD_H_STYLE*","");
                }else{
                    onelayer=onelayer.replace("*REDCARD_H_STYLE*","style='display:none;'");
                }
                if (dbs[i]["Match_redcard_c"]*1 > 0){
                    onelayer=onelayer.replace("*REDCARD_C*",dbs[i]["Match_redcard_c"]);
                    onelayer=onelayer.replace("*REDCARD_C_STYLE*","");
                }else{
                    onelayer=onelayer.replace("*REDCARD_C_STYLE*","style='display:none;'");
                }

                onelayer=onelayer.replace("*PTYPE*","");
                onelayer=onelayer.replace("*TEAM_H*",TeamName(dbs[i]["Match_Master"]));
                onelayer=onelayer.replace("*TEAM_C*",TeamName(dbs[i]["Match_Guest"]));
                onelayer=onelayer.replace("*DRAW_STR*","和局");

                onelayer=onelayer.replace("*DIS_DARW*","");
                onelayer=onelayer.replace("*TR_NUM*","3");
                onelayer=onelayer.replace("*PTYPE_DIS_DARW*","");
                onelayer=onelayer.replace("*PTYPE_TR_NUM*","4");

                //------------------------------------------------
                //全場
                //獨贏
                if(dbs[i]["Match_BzM"]>0 && dbs[i]["Match_BzG"]>0){
                    var color_H = "bet_bg_color";
                    var color_C = "bet_bg_color";
                    var color_N = "bet_bg_color";
                    if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
                        color_H = pl_color(dbs[i]["Match_BzM"],data[i]["Match_BzM"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                        color_C = pl_color(dbs[i]["Match_BzG"],data[i]["Match_BzG"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                    }
                    var BzM= '<span id="MH'+dbs[i]["Match_ID"]+'" class="'+color_H+'"><span onclick="javascript:setbet(\'足球滚球\',\'独赢-'+dbs[i]["Match_Master"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_BzM\',0,1,\''+dbs[i]["Match_Master"]+'\');" title="'+TeamName(dbs[i]["Match_Master"])+'">'+formatNumber(dbs[i]["Match_BzM"],2)+'</span></span>';
                    var BzG= '<span id="MC'+dbs[i]["Match_ID"]+'" class="'+color_C+'"><span onclick="javascript:setbet(\'足球滚球\',\'独赢-'+dbs[i]["Match_Guest"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_BzG\',0,1,\''+dbs[i]["Match_Guest"]+'\');" title="'+TeamName(dbs[i]["Match_Guest"])+'">'+formatNumber(dbs[i]["Match_BzG"],2)+'</span></span>';
                    onelayer=onelayer.replace("*RATIO_MH*",BzM);
                    onelayer=onelayer.replace("*RATIO_MC*",BzG);

                    if (dbs[i]["Match_BzH"]==null || dbs[i]["Match_BzH"]-0.05<=0){
                        onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
                    }else{
                        if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
                            color_N = pl_color(dbs[i]["Match_BzH"],data[i]["Match_BzH"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                        }
                        var BzH= '<span id="MN'+dbs[i]["Match_ID"]+'" class="'+color_N+'"><span onclick="javascript:setbet(\'足球滚球\',\'独赢-和局\',\''+dbs[i]["Match_ID"]+'\',\'Match_BzH\',0,1,\'和局\');" title="和局">'+formatNumber(dbs[i]["Match_BzH"],2)+'</span></span>';
                        onelayer=onelayer.replace("*RATIO_MN*",BzH);
                    }
                }else{
                    onelayer=onelayer.replace("*RATIO_MH*","&nbsp;");
                    onelayer=onelayer.replace("*RATIO_MC*","&nbsp;");
                    onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
                }

                //让球
                if(dbs[i]["Match_Ho"]>0 && dbs[i]["Match_Ao"]>0){
                    if (dbs[i]["Match_ShowType"]=="H"){
                        onelayer=onelayer.replace("*CON_RH*",dbs[i]["Match_RGG"]);  /*讓球球頭*/
                        onelayer=onelayer.replace("*CON_RC*","");
                    }else{
                        onelayer=onelayer.replace("*CON_RH*","");
                        onelayer=onelayer.replace("*CON_RC*",dbs[i]["Match_RGG"]);
                    }

                    /*讓球賠率*/
                    var color_H = "bet_bg_color";
                    var color_C = "bet_bg_color";
                    if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
                        color_H = pl_color(dbs[i]["Match_Ho"],data[i]["Match_Ho"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                        color_C = pl_color(dbs[i]["Match_Ao"],data[i]["Match_Ao"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                    }
                    var Ho = '<span id="RH'+dbs[i]["Match_ID"]+'" class="'+color_H+'"><span title="'+dbs[i]["Match_Master"]+'" onclick="javascript:setbet(\'足球滚球\',\'让球-'+(dbs[i]["Match_ShowType"]=="H" ? "主让" :"客让")+dbs[i]["Match_RGG"]+"-"+dbs[i]["Match_Master"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_Ho\',1,1,\''+dbs[i]["Match_Master"]+'\');" >'+formatNumber(dbs[i]["Match_Ho"],2)+'</span></span>';
                    var Ao = '<span id="RC'+dbs[i]["Match_ID"]+'" class="'+color_C+'"><span title="'+dbs[i]["Match_Guest"]+'" onclick="javascript:setbet(\'足球滚球\',\'让球-'+(dbs[i]["Match_ShowType"]=="H" ? "主让" :"客让")+dbs[i]["Match_RGG"]+"-"+dbs[i]["Match_Guest"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_Ao\',1,1,\''+dbs[i]["Match_Guest"]+'\');" >'+formatNumber(dbs[i]["Match_Ao"],2)+'</span></span>';
                    
                    onelayer=onelayer.replace("*RATIO_RH*",Ho);/*讓球賠率*/
                    onelayer=onelayer.replace("*RATIO_RC*",Ao);
                }else{
                    onelayer=onelayer.replace("*CON_RH*","");
                    onelayer=onelayer.replace("*CON_RC*","");
                    onelayer=onelayer.replace("*RATIO_RH*","");/*讓球賠率*/
                    onelayer=onelayer.replace("*RATIO_RC*","");
                }

                //大小
                if(dbs[i]["Match_DxDpl"]>0 && dbs[i]["Match_DxXpl"]>0){
                    var CON_OUH = dbs[i]["Match_DxGG"].replace("O","");
                    var CON_OUC = dbs[i]["Match_DxGG1"].replace("U","");
                    onelayer=onelayer.replace("*CON_OUH*",CON_OUH);
                    onelayer=onelayer.replace("*CON_OUC*",CON_OUC);
                    onelayer=onelayer.replace("*TEXT_OUH*","大");
                    onelayer=onelayer.replace("*TEXT_OUC*","小");

                    var color_H = "bet_bg_color";
                    var color_C = "bet_bg_color";
                    if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
                        color_H = pl_color(dbs[i]["Match_DxDpl"],data[i]["Match_DxDpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                        color_C = pl_color(dbs[i]["Match_DxXpl"],data[i]["Match_DxXpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                    }
                    var DxDpl = '<span id="OUH'+dbs[i]["Match_ID"]+'" class="'+color_H+'"><span title="大" onclick="javascript:setbet(\'足球滚球\',\'大小-'+dbs[i]["Match_DxGG"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_DxDpl\',1,1,\''+dbs[i]["Match_DxGG"]+'\');" >'+formatNumber(dbs[i]["Match_DxDpl"],2)+'</span></span>';
                    var DxXpl = '<span id="OUC'+dbs[i]["Match_ID"]+'" class="'+color_C+'"><span title="小" onclick="javascript:setbet(\'足球滚球\',\'大小-'+dbs[i]["Match_DxGG1"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_DxXpl\',1,1,\''+dbs[i]["Match_DxGG1"]+'\');">'+formatNumber(dbs[i]["Match_DxXpl"],2)+'</span></span>';
                    onelayer=onelayer.replace("*RATIO_OUH*",DxDpl);/*大小賠率*/
                    onelayer=onelayer.replace("*RATIO_OUC*",DxXpl);
                }else{
                    onelayer=onelayer.replace("*CON_OUH*","");
                    onelayer=onelayer.replace("*CON_OUC*","");
                    onelayer=onelayer.replace("*TEXT_OUH*","");
                    onelayer=onelayer.replace("*TEXT_OUC*","");

                    onelayer=onelayer.replace("*RATIO_OUH*","");/*大小賠率*/
                    onelayer=onelayer.replace("*RATIO_OUC*","");
                }

                //单双

                if(dbs[i]["Match_DsDpl"]>0 && dbs[i]["Match_DsSpl"]>0){
                    onelayer=onelayer.replace("*TEXT_EOO*","单");
                    onelayer=onelayer.replace("*TEXT_EOE*","双");
                    var color_H = "bet_bg_color";
                    var color_C = "bet_bg_color";
                    if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
                        color_H = pl_color(dbs[i]["Match_DsDpl"],data[i]["Match_DsDpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                        color_C = pl_color(dbs[i]["Match_DsSpl"],data[i]["Match_DsSpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                    }
                    var EOO = '<span id="EOO'+dbs[i]["Match_ID"]+'" class="'+color_H+'"><span title="单" onclick="javascript:setbet(\'足球滚球\',\'单双-单\',\''+dbs[i]["Match_ID"]+'\',\'Match_DsDpl\',0,1,\'单\');">'+formatNumber(dbs[i]["Match_DsDpl"],2)+'</span></span>';
                    var EOE = '<span id="EOE'+dbs[i]["Match_ID"]+'" class="'+color_C+'"><span title="双" onclick="javascript:setbet(\'足球滚球\',\'单双-双\',\''+dbs[i]["Match_ID"]+'\',\'Match_DsSpl\',0,1,\'双\');">'+formatNumber(dbs[i]["Match_DsSpl"],2)+'</span></span>';
                    onelayer=onelayer.replace("*RATIO_EOO*",EOO);
                    onelayer=onelayer.replace("*RATIO_EOE*",EOE);
                }else{
                    onelayer=onelayer.replace("*TEXT_EOO*","");
                    onelayer=onelayer.replace("*TEXT_EOE*","");
                    onelayer=onelayer.replace("*RATIO_EOO*","");
                    onelayer=onelayer.replace("*RATIO_EOE*","");
                }

                //上半独赢
                if(dbs[i]["Match_Bmdy"]>0 && dbs[i]["Match_Bgdy"]>0){
                    var color_H = "bet_bg_color";
                    var color_C = "bet_bg_color";
                    var color_N = "bet_bg_color";
                    if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
                        color_H = pl_color(dbs[i]["Match_Bmdy"],data[i]["Match_Bmdy"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                        color_C = pl_color(dbs[i]["Match_Bgdy"],data[i]["Match_Bgdy"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                    }

                    var BzM= '<span id="HMH'+dbs[i]["Match_ID"]+'" class="'+color_H+'"><span onclick="javascript:setbet(\'足球上半场滚球\',\'独赢-'+dbs[i]["Match_Master"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_Bmdy\',0,1,\''+dbs[i]["Match_Master"]+'\');" title="'+TeamName(dbs[i]["Match_Master"])+'">'+formatNumber(dbs[i]["Match_Bmdy"],2)+'</span></span>';
                    var BzG= '<span id="HMC'+dbs[i]["Match_ID"]+'" class="'+color_C+'"><span onclick="javascript:setbet(\'足球上半场滚球\',\'独赢-'+dbs[i]["Match_Guest"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_Bgdy\',0,1,\''+dbs[i]["Match_Guest"]+'\');" title="'+TeamName(dbs[i]["Match_Guest"])+'">'+formatNumber(dbs[i]["Match_Bgdy"],2)+'</span></span>';
                    onelayer=onelayer.replace("*RATIO_HMH*",BzM);
                    onelayer=onelayer.replace("*RATIO_HMC*",BzG);

                    if (dbs[i]["Match_Bhdy"]==null || dbs[i]["Match_Bhdy"]-0.05<=0){
                        onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
                    }else{
                        /*if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
                            color_N = pl_color(dbs[i]["Match_Bhdy"],data[i]["Match_Bhdy"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                        }*/
                        var BzH= '<span id="HMN'+dbs[i]["Match_ID"]+'" class="'+color_N+'"><span onclick="javascript:setbet(\'足球上半场滚球\',\'独赢-和局\',\''+dbs[i]["Match_ID"]+'\',\'Match_Bhdy\',0,1,\'和局\');" title="和局">'+formatNumber(dbs[i]["Match_Bhdy"],2)+'</span></span>';
                        onelayer=onelayer.replace("*RATIO_HMN*",BzH);
                    }
                }else{
                    onelayer=onelayer.replace("*RATIO_HMH*","&nbsp;");
                    onelayer=onelayer.replace("*RATIO_HMC*","&nbsp;");
                    onelayer=onelayer.replace("*RATIO_HMN*","&nbsp;");
                }

                //上半让球
                if(dbs[i]["Match_BHo"]>0 && dbs[i]["Match_BAo"]>0){
                    if (dbs[i]["Match_Hr_ShowType"]=="H"){
                        onelayer=onelayer.replace("*CON_HRH*",dbs[i]["Match_BRpk"]);    /*讓球球頭*/
                        onelayer=onelayer.replace("*CON_HRC*","");
                    }else{
                        onelayer=onelayer.replace("*CON_HRH*","");
                        onelayer=onelayer.replace("*CON_HRC*",dbs[i]["Match_BRpk"]);
                    }

                    /*讓球賠率*/
                    var color_H = "bet_bg_color";
                    var color_C = "bet_bg_color";
                    if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
                        color_H = pl_color(dbs[i]["Match_BHo"],data[i]["Match_BHo"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                        color_C = pl_color(dbs[i]["Match_BAo"],data[i]["Match_BAo"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                    }
                    var Ho = '<span id="RH'+dbs[i]["Match_ID"]+'" class="'+color_H+'"><span title="'+dbs[i]["Match_Master"]+'" onclick="javascript:setbet(\'足球上半场滚球\',\'让球-'+(dbs[i]["Match_Hr_ShowType"]=="H" ? "主让" :"客让")+dbs[i]["Match_BRpk"]+"-"+dbs[i]["Match_Master"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_BHo\',1,1,\''+dbs[i]["Match_Master"]+'\');" >'+formatNumber(dbs[i]["Match_BHo"],2)+'</span></span>';
                    var Ao = '<span id="RC'+dbs[i]["Match_ID"]+'" class="'+color_C+'"><span title="'+dbs[i]["Match_Guest"]+'" onclick="javascript:setbet(\'足球上半场滚球\',\'让球-'+(dbs[i]["Match_Hr_ShowType"]=="H" ? "主让" :"客让")+dbs[i]["Match_BRpk"]+"-"+dbs[i]["Match_Guest"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_BAo\',1,1,\''+dbs[i]["Match_Guest"]+'\');" >'+formatNumber(dbs[i]["Match_BAo"],2)+'</span></span>';
                    
                    onelayer=onelayer.replace("*RATIO_HRH*",Ho);/*讓球賠率*/
                    onelayer=onelayer.replace("*RATIO_HRC*",Ao);
                }else{
                    onelayer=onelayer.replace("*CON_HRH*","");
                    onelayer=onelayer.replace("*CON_HRC*","");
                    onelayer=onelayer.replace("*RATIO_HRH*","");/*讓球賠率*/
                    onelayer=onelayer.replace("*RATIO_HRC*","");
                }

                //上半大小
                if(dbs[i]["Match_Bdpl"]>0 && dbs[i]["Match_Bxpl"]>0){
                    var CON_OUH = dbs[i]["Match_Bdxpk"].replace("O","");
                    var CON_OUC = dbs[i]["Match_Bdxpk2"].replace("U","");
                    onelayer=onelayer.replace("*CON_HOUH*",CON_OUH);
                    onelayer=onelayer.replace("*CON_HOUC*",CON_OUC);
                    onelayer=onelayer.replace("*TEXT_HOUH*","大");
                    onelayer=onelayer.replace("*TEXT_HOUC*","小");
                    var color_H = "bet_bg_color";
                    var color_C = "bet_bg_color";
                    if(i<data.length && data[i]["Match_ID"] == dbs[i]["Match_ID"]){
                        color_H = pl_color(dbs[i]["Match_Bdpl"],data[i]["Match_Bdpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                        color_C = pl_color(dbs[i]["Match_Bxpl"],data[i]["Match_Bxpl"],data[i]["Match_ID"],dbs[i]["Match_ID"]);
                    }
                    var DxDpl = '<span id="HOUH'+dbs[i]["Match_ID"]+'" class="'+color_H+'"><span title="大" onclick="javascript:setbet(\'足球上半场滚球\',\'大小-'+dbs[i]["Match_Bdxpk"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_Bdpl\',1,1,\''+dbs[i]["Match_Bdxpk"]+'\');" >'+formatNumber(dbs[i]["Match_Bdpl"],2)+'</span></span>';
                    var DxXpl = '<span id="HOUC'+dbs[i]["Match_ID"]+'" class="'+color_C+'"><span title="小" onclick="javascript:setbet(\'足球上半场滚球\',\'大小-'+dbs[i]["Match_Bdxpk2"]+'\',\''+dbs[i]["Match_ID"]+'\',\'Match_Bxpl\',1,1,\''+dbs[i]["Match_Bdxpk2"]+'\');">'+formatNumber(dbs[i]["Match_Bxpl"],2)+'</span></span>';
                    onelayer=onelayer.replace("*RATIO_HOUH*",DxDpl);/*大小賠率*/
                    onelayer=onelayer.replace("*RATIO_HOUC*",DxXpl);
                }else{
                    onelayer=onelayer.replace("*CON_HOUH*","");
                    onelayer=onelayer.replace("*CON_HOUC*","");
                    onelayer=onelayer.replace("*TEXT_HOUH*","");
                    onelayer=onelayer.replace("*TEXT_HOUC*","");

                    onelayer=onelayer.replace("*RATIO_HOUH*","");/*大小賠率*/
                    onelayer=onelayer.replace("*RATIO_HOUC*","");
                }

                //我的最愛
                var css = '';
                var _id = dbs[i]["Match_Date"]+dbs[i]["Match_ID"];
                if($.inArray(dbs[i]["Match_ID"].toString(), top.myLove[top.w_type][gtype])>=0){
                    css = 'style="display:;" class="bet_game_star_on" title="删除收藏" onclick="chkDelshowLoveI(this.id,\''+dbs[i]["Match_ID"]+'\')" ';
                    _id = _id+'_off';
                }else{
                    css = 'style="display: none;" class="bet_game_star_out" title="赛事收藏" onclick="addShowLoveI(this.id,\''+dbs[i]["Match_ID"]+'\')" ';
                }
                onelayer=onelayer.replace(/\*MYLOVE_ID\*/gi,"love"+_id);
                onelayer=onelayer.replace(/\*MYLOVE_ID_none\*/gi,"love"+_id+"_none");
                onelayer=onelayer.replace(/\*MYLOVE_CSS\*/gi,css);
                var show_type=_id.split("_");
                onelayer=onelayer.replace(/\*MYLOVE_CSS_none\*/gi,show_type[1]=="off"?"style='display: none;'":"");

                
                dataAll = dataAll+onelayer;
                
             }
             showtableData = showtableData.replace("*showDataTR*",dataAll);

        }
        chkOKshowLoveI();//赛事收藏
        $("#showtable").html(showtableData);

        //取消背景颜色
        setTimeout(function(){
            pl_color_off(); 
        },3000);

        
    });
}

