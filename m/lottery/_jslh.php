<?php defined('IN_LOT') || exit(); ?>
<link rel="stylesheet" href="../lotto/images/ball.css">
<div class="lhc-info" style="padding:5px;border:1px #d3d3d3 solid">
    <div style="font-size:12pt;">第<span style="color:#f00">--</span>期</div>
    <div class="mark_six" style="line-height:27px">
        <div class="ball_13">--</div>
        <div class="ball_28">--</div>
        <div class="ball_41">--</div>
        <div class="ball_13">--</div>
        <div class="ball_28">--</div>
        <div class="ball_41">--</div>
        <div class="ball_00">+</div>
        <div class="ball_41">--</div>
    </div>
    <div class="clearfix"></div>
    <div class="mark_six" style="line-height:27px">
        <div class="ball_50">--</div>
        <div class="ball_50">--</div>
        <div class="ball_50">--</div>
        <div class="ball_50">--</div>
        <div class="ball_50">--</div>
        <div class="ball_50">--</div>
        <div class="ball_00">+</div>
        <div class="ball_50">--</div>
    </div>
    <div class="clearfix"></div>
    <div style="font-size:12pt;">
        <p>第<span style="color:#f00">--</span>期</p>
        <p>距离封盘：--</p>
    </div>
</div>
<script type="text/javascript">
    var pankouflag = false;
    $(document).ready(function(){
        window.post = function(d, s){
            return $.ajax({
                type: "post",
                dataType: "json",
                url: "../../lot/ajax.php",
                contentType: "application/json",
                data: JSON.stringify(d),
                success: s
            })
        };
        return {
            now: 0,
            close: 0,
            open: 0,
            obj: [null, null],
            load: function(){
                var t = this;
                clearTimeout(t.obj[0]),
                window.post({action: "info", lotteryId: "jslh"}, function(d){
                    $(".lhc-info div:first > span").html(d.Obj.LotterNo),
                    $.each(d.Obj.PreResult, function(i, v){
                        $(".lhc-info div.mark_six:eq(0) div:not(.ball_00)").eq(i).html(v.number).removeAttr("class").addClass("ball_"+v.number),
                        $(".lhc-info div.mark_six:eq(1) div:not(.ball_00)").eq(i).html(v.sx)
                    }),
                    $(".lhc-info div:last > p:first > span").html(d.Obj.CurrentPeriod),
                    t.now = (new Date()).getTime(),
                    t.now>t.open&&(t.open = t.now+(parseInt(d.Obj.OpenCount)*1000),
                    t.close = t.now+(parseInt(d.Obj.CloseCount)*1000),
                    typeof(window.reload)!="undefined"&&window.reload()),
                    t.obj[0] = setTimeout(function(){
                        t.load()
                    }, 10000),
                    t.count()
                })
            },
            count: function(){
                var t = this;
                clearTimeout(t.obj[1]),
                pankouflag = (t.close-t.now)/1000>=1,
                t.now = (new Date()).getTime(),
                $(".lhc-info div:last > p:last").html((pankouflag?"距离封盘：":"距离开奖：")+t.time(pankouflag?t.close:t.open)),
                !pankouflag&&typeof(window.disabled)!="undefined"&&window.disabled(),
                t.now>=t.open ? t.load() : (t.obj[1] = setTimeout(function(){
                    t.count()
                }, 250))
            },
            time: function(v){
                var t = this, i, s;
                v = Math.floor(v/1000),
                v-= Math.floor(t.now/1000),
                i = Math.floor(v/60).toString(),
                s = Math.floor(v%60).toString();
                return v>0 ? ("00"+i).substring(i.length)+":"+("00"+s).substring(s.length) : "00:00"
            }
        }.load();
    });
</script>