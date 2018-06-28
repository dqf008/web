$(".gn_main_cont").html($("#HZ_wf").html());
var ETHDX_ARRAY = new Array();//定义二同号单选组合数组 用于计算
var ORDER_LIST = new Array();//注数数组
var cpdata;
var bet = {};

var betTime = 0;
var jskj = 0;
var checktm = 0;
var awardIssuse = null;
var awardSeconds = 0;
var canOrder = true;
var timeData = null;
var firstEnter = true;
var cpdata = null;
var TmpbetTime = 0;
var tm;
var nowqihao = null;

var _ALL_TIMER_;

/*
//玩法切换
*/
/*
//玩法切换
*/
$("#play-tab > li").click(function () {
    var lottery_code = $(this).attr('lottery_code');
    $(this).addClass("active").siblings("li").removeClass("active");
    $(".gn_main_cont").html($("#" + lottery_code + '_wf').html());
    $("#choice_zhu").text(0);
})
//清空投注列表
$('.empty_orders').click(function () {
    $('#order_table').find('tr').remove();
    $('.ball_cont').find('.ball_number').removeClass('curr');
    $('#f_gameOrder_lotterys_num').text('0');
    $('#f_gameOrder_amount').text('0');
    ORDER_LIST = [];
})

/*
//|组合tr订单
//绑定选号[单击选号]
*/
$(document).on("click", ".ball_number", function () {

    var theStatue = $(this).hasClass("curr");

    $(this).addClass("curr");
    var ball_type = $(this).attr('ball-type');
    var ball_number = $(this).attr('ball-number');
    var peilv = $(this).attr('peilv');
    var ball_txt = $(this).text();
    var typetxt = $("#play-tab li[lottery_code='" + ball_type + "']").text();
    var tr = '';
    var pl = '';
    if (ball_type != 'HZ' && ball_type != '3THTX' && ball_type != '3LHTX') {
        if (!theStatue) {
            $(this).addClass("curr");
        } else {
            $(this).removeClass("curr");
        }
    }
    var peilv = 0;
    switch (ball_type) {
        case 'HZ'://和值
            pl = ball_type + '_' + ball_number;
            peilv = $(this).attr('peilv');
            tr = zuhetr(typetxt, ball_type, ball_number, ball_txt, peilv, 1);
            $("#order_table").prepend(tr);
            break;
        case '3THTX'://三同号通选
            peilv = $("#" + ball_type).attr('peilv');
            tr = zuhetr(typetxt, ball_type, ball_number, ball_txt, peilv, 1);
            $("#order_table").prepend(tr);
            break;
        case '3THDX'://三同号单选
            var i = 0;
            ball_number = '';
            ball_txt = '';
            $("#3THDX .ball_number").each(function () {
                if ($(this).hasClass("curr")) {
                    i++;
                    ball_number += $(this).attr('ball-number') + ',';
                    ball_txt += $(this).text() + ',';
                }
            })
            $("#choice_zhu").text(i);
            break;
        case '3BTH'://三不同号
            var i = 0, j = 0;
            $("#3BTH .ball_number").each(function () {
                if ($(this).hasClass("curr")) {
                    i++;
                }
            });
            switch (i) {
                case 3:
                    j = 1;
                    break;
                case 4:
                    j = 4;
                    break;
                case 5:
                    j = 10;
                    break;
                case 6:
                    j = 20;
                    break;
            }
            $("#choice_zhu").text(j);
            break;
        case '3LHTX'://三连号通选
            peilv = $("#" + ball_type).attr('peilv');
            tr = zuhetr(typetxt, ball_type, ball_number, ball_txt, peilv, 1);
            $("#order_table").prepend(tr);
            break;
        case '3LHDX':
            var i = 0;
            ball_number = '';
            ball_txt = '';
            $("#3LHDX .ball_number").each(function () {
                if ($(this).hasClass("curr")) {
                    i++;
                    ball_number += $(this).attr('ball-number') + ',';
                    ball_txt += $(this).text() + ',';
                }
            })
            $("#choice_zhu").text(i);
            break;
        case '2THFX'://二同号复选
            var i = 0;
            ball_number = '';
            ball_txt = '';
            $("#2THFX .ball_number").each(function () {
                if ($(this).hasClass("curr")) {
                    i++;
                }
            })
            $("#choice_zhu").text(i);
            break;
        case '2THDX'://二同号单选
            var i = 0, j = 0, fnumber;
            var ethdx = new Array(), ethdx1 = new Array();
            $("#2THDX .ethdx_btn").each(function () {
                if ($(this).hasClass("curr")) {
                    ethdx[i] = $(this).attr('ball-number');
                    fnumber = ethdx[i].substr(0, 1);

                    i++;
                }
            });
            $("#2THDX .ethdx_btn1").each(function () {
                if ($(this).hasClass("curr")) {
                    ethdx1[j] = $(this).attr('ball-number');
                    fnumber = ethdx1[j] + '' + ethdx1[j];
                    j++;
                }
            });
            ETHDX_ARRAY = objPL(ethdx, ethdx1);
            $("#choice_zhu").text(ETHDX_ARRAY.length);
            break;
        case '2BTH'://二不同号
            var i = 0, j = 0;
            $("#2BTH .ball_number").each(function () {
                if ($(this).hasClass("curr")) {
                    i++;
                }
            });
            switch (i) {
                case 2:
                    j = 1;
                    break;
                case 3:
                    j = 3;
                    break;
                case 4:
                    j = 6;
                    break;
                case 5:
                    j = 10;
                    break;
                case 6:
                    j = 15;
                    break;
            }
            $("#choice_zhu").text(j);
            break;
    }
    $('.each_price').keyup();
    $('.each_price').blur();
});
$(document).on("click", ".ethdx_btn", function () {
    var i = 0, j = 0, fnumber;
    var ethdx = new Array(), ethdx1 = new Array();
    $("#2THDX .ethdx_btn").each(function () {
        if ($(this).hasClass("curr")) {
            ethdx[i] = $(this).attr('ball-number');
            fnumber = ethdx[i].substr(0, 1);
            if ($("#2THDX .ethdx_btn1[ball-number='" + fnumber + "']").hasClass("curr")) {
                $("#2THDX .ethdx_btn1[ball-number='" + fnumber + "']").removeClass("curr");
            }
            ;
            i++;
        }
    });
})
$(document).on("click", ".ethdx_btn1", function () {
    var i = 0, j = 0, fnumber;
    var ethdx = new Array(), ethdx1 = new Array();
    $("#2THDX .ethdx_btn1").each(function () {
        if ($(this).hasClass("curr")) {
            ethdx1[j] = $(this).attr('ball-number');
            fnumber = ethdx1[j] + '' + ethdx1[j];
            if ($("#2THDX .ethdx_btn[ball-number='" + fnumber + "']").hasClass("curr")) {
                $("#2THDX .ethdx_btn[ball-number='" + fnumber + "']").removeClass("curr");
            }
            ;
            j++;
        }
    });
})

/*
** 数组计算组合
** 用于二同号单选
*/
function objPL(a, b) {
    var array = new Array();
    var n = 0;
    var str = '';
    //a和b的排列组合个数就是两者相乘（双层循环）
    for (var i = 0; i < a.length; i++) {
        for (var j = 0; j < b.length; j++) {
            str = a[i] + b[j];
            if (str.substr(0, 1) != str.substr(-1)) {
                array[n] = a[i] + b[j];
                n++;
            }
        }
    }
    return array;
}

$("#choice_comfire_btn").click(function () {
    if ($(".gn_main_cont #3THDX").length == 1) {//三同号单选
        get_choice_comfire('3THDX', 1);
    } else if ($(".gn_main_cont #3THTX").length == 1) {//三同号通选
        get_choice_comfire('3THTX', 1);
    } else if ($(".gn_main_cont #3BTH").length == 1) {//三不同号
        get_choice_comfire('3BTH', 3);
    } else if ($(".gn_main_cont #3LHDX").length == 1) {//三连号单选
        get_choice_comfire('3LHDX', 1);
    } else if ($(".gn_main_cont #2THFX").length == 1) {//二同号复选
        get_choice_comfire('2THFX', 1);
    } else if ($(".gn_main_cont #2BTH").length == 1) {//二不同号
        get_choice_comfire('2BTH', 2);
    } else if ($(".gn_main_cont #2THDX").length == 1) {//二不同号单选
        var ball_type = "2THDX", typetxt, ball_number = '', ball_txt = '';
        typetxt = '';
        var ethdx = new Array(), ethdx1 = new Array();
        $("#2THDX .ethdx_btn").each(function () {
            if ($(this).hasClass("curr")) {
                ball_number += $(this).text() + ',';
            }
        });
        $("#2THDX .ethdx_btn1").each(function () {
            if ($(this).hasClass("curr")) {
                ball_number += $(this).text() + ',';
            }
        });
        typetxt = $("#play-tab li[lottery_code='" + ball_type + "']").text();
        var peilv =$("#" + ball_type).attr('peilv');
        var tr = zuhetr(typetxt, ball_type, ball_number, ball_number, peilv, $("#choice_zhu").text());
        if ($('#choice_zhu').text() != '0') {
            $("#order_table").prepend(tr);
            $("#2THDX .ball_number").removeClass("curr");
        } else {
            tip('选择的投注号码不完整！');
            return false;
        }
        $('.each_price').keyup();
        $('.each_price').blur();
    }
    $('#choice_zhu').text('0');
});

function get_choice_comfire(id, mincount) {
    var ball_type, typetxt, ball_number = '', ball_txt = '';
    var i = 0;
    $("#" + id + " .ball_number").each(function () {
        if ($(this).hasClass("curr")) {
            ball_number += $(this).attr('ball-number') + ',';
            ball_txt += $(this).text() + ',';
            ball_type = $(this).attr('ball-type');
            typetxt = $("#play-tab li[lottery_code='" + ball_type + "']").text();
            i++;
        }
    });
    if (i < mincount) {
        alert('号码选择不完整，请重新选择！');
        return false;
    }
    var peilv = $("#" + id).attr("peilv");
    var tr = zuhetr(typetxt, ball_type, ball_number, ball_txt, peilv, $("#choice_zhu").text());
    $("#order_table").prepend(tr);
    $("#" + id + " .ball_number").removeClass("curr");
    $('.each_price').keyup();
    $('.each_price').blur();
}


function tip(content, icon) {
    if (!icon) icon = 'warning';
    art.dialog({
        icon: icon,
        id: 'testID2',
        content: content,
        lock: true,
        cancelVal: '关闭',
        cancel: true
    });
}

function zuhetr(typetxt, type, number, txt, peilv, zhushu) {

    if (number.substr(-1) == ',') {
        number = number.substring(0, number.length - 1);
    }
    if (txt.substr(-1) == ',') {
        txt = txt.substring(0, txt.length - 1);
    }
    //ORDER_LIST[order_code] = order_code;
    var order_code = type + '_' + number;
    var node = $("tr[order_code='" + order_code + "']");
    var ysum = 10;
    if (node.length >= 1) {
        var str_name = '#order_table tr[order_code="' + type + '_' + number + '"]';
        var before_sum = $(str_name).find('.each_price').val();
        var integer = parseInt(before_sum) + 1;
        $(str_name).find('.each_price').val(integer);
        // var bet = order_code+'_'+peilv+'_'+integer;
        // ORDER_LIST.remove(order_code);
        // ORDER_LIST.push(bet);
    } else {
        //更新方案注数
        var lotterys_num = Number($("#f_gameOrder_lotterys_num").text()) + Number(zhushu);
        // var bet = order_code+'_'+peilv+'_'+(lotterys_num);
        ORDER_LIST.push(order_code);
        var tr = '';
        tr += '<tr order_code="' + order_code +'"  lotterys_num="' + lotterys_num + '" type_code="' + type + '" peilv="' + peilv + '",>';
        tr += '<td>';
        tr += '<i class="order_type">[' + typetxt + ']' + txt + '</i>';
        tr += '<i class="peilv" style="display: none">' + peilv + '</i>';
        tr += '<i class="zhushu" style="display: none">' + zhushu + '</i>';
        tr += '<i class="ysum" style="display: none">' + ysum + '</i>';
        tr += '<i class="hidden_typetext" style="display: none">' + typetxt + '</i>';
        tr += '<i class="hidden_type" style="display: none">' + type + '</i>';
        tr += '<i class="hidden_txt" style="display: none">' + txt + '</i>';
        tr += '</td>';
        tr += '<td>';
        tr += '<span class="order_zhushu">总共<i class="order_num c_red">' + zhushu + '</i>注</span>';
        tr += '</td>';
        tr += '<td>';
        tr += '<i class="order_price">每注<input type="text" value="' + ysum + '" class="each_price" onafterpaste="formatIntVal(this)" onkeyup="formatIntVal(this)" onblur="changetotalprice();">元</i>';
        tr += '</td>';
        tr += '<td>';
        tr += '<i class="c_3">&nbsp;<span class="hide_this">每注可赢金额：<i class="order_money c_red" style="color: red;">0.00</i>元</span></i>';
        tr += '</td>';
        tr += '<td>';
        tr += '<i class="c_org l_cancel" onclick="aremovecurr(this);">删除</i>';
        tr += '</td>';
        tr += '</tr>';


        $("#f_gameOrder_lotterys_num").text(lotterys_num);
    }

    return tr;
};

function aremovecurr(obj) {
    removetr(obj);
    str = $(obj).parent().parent().attr('order_code').slice(3);
    $('.ball_cont a').each(function () {
        if ($(this).attr('ball-number') == str) {
            $(this).removeClass('curr');
        }
    })
}

function removetr(obj) {
    //更新方案注数
    var oldLotterysNum =Number($("#f_gameOrder_lotterys_num").text());
    var lotterys_num = oldLotterysNum - Number($(obj).parents('tr').find('.order_num').text());
    $("#f_gameOrder_lotterys_num").text(lotterys_num);
    var order_code = $(obj).parents('tr').attr('order_code');
    var peilv = $(obj).parents('tr').attr('peilv');
    var lotterys_num = $(obj).parents('tr').attr('lotterys_num');
    // var orderCodes = order_code.split('_');
    ORDER_LIST.remove(order_code);
    $(obj).parents('tr').remove();
    //更新方案总价格
    changetotalprice();
}

function formatIntVal(obj) {
    obj.value = obj.value.replace(/\D+/g, '');
    showGetPrice(obj, obj.value);
}

function formatPrice(val) {
    val = Number(val);
    val = val.toFixed(1);
    return val;
};

function showGetPrice(obj, val) {
    var odds = $(obj).parents('tr').attr('peilv');
    var bingoPrice = accMul(val, odds);
    //alert(accMul(val,odds));
    $(obj).parents('tr').find(".order_money").text(bingoPrice);
    $(obj).parents('tr').find(".hide_this").css({'display': 'inline'});
    return false;
};
$("input").blur(function () {
    $("input").css("background-color", "#D6D6FF");
});

function accMul(arg1, arg2) {
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try {
        m += s1.split(".")[1].length
    } catch (e) {
    }
    try {
        m += s2.split(".")[1].length
    } catch (e) {
    }
    return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m)
}

function changetotalprice() {
    var totalprice = 0;
    $("#order_table tr").each(function () {
        totalprice += Number($(this).find('.each_price').val()) * Number($(this).find('.order_num').text());
    })
    $("#f_gameOrder_amount").text(totalprice);
}

function checkSingleBuy(obj) {

};

$("#f_submit_order").click(function () {
    if (ORDER_LIST.length <= 0) {
        alert('请选择投注号码');
        return false;
    }
    var bet = new Array();
    var price, order_str = '', price_str = '',peilv=0;
    var pricenum = 0;//有金额的注单数量
    for (i = 0; i < ORDER_LIST.length; i++) {
        var orderCode = ORDER_LIST[i].split('_');
        price = $("#order_table tr[order_code='" + ORDER_LIST[i] + "']").find("input.each_price").val();
        peilv =$("#order_table tr[order_code='" + ORDER_LIST[i] + "']").find(".peilv").text();
        bet = setBet(orderCode,price,peilv,bet);

        if (Number(price) >= 1) {
            order_str += ORDER_LIST[i] + ';'
            price_str += Number(price) + ';'
            pricenum++;
        }
    }
    if (bet.length < 1) {
        alert('请至少选择一注投注号码！');
        return false;
    }
    sendorder(bet);

});
function setBet(orderCode,price,peilv,bet) {

    var content = orderCode[1];
    switch (orderCode[0]){
        case 'HZ':
            var hz ={
                '3':'101',
                '4':'102',
                '5':'103',
                '6':'104',
                '7':'105',
                '8':'106',
                '9':'107',
                '10':'108',
                '11':'109',
                '12':'110',
                '13':'111',
                '14':'112',
                '15':'113',
                '16':'114',
                '17':'115',
                '18':'116',
                '大':'117',
                '小':'118',
                '单':'119',
                '双':'120',
                '大单':'121',
                '大双':'122',
                '小单':'123',
                '小双':'124',
            };
            bet.push({'Id':hz[content],'BetContext':content,'Lines':peilv,'Money':price});
            break;
        case '3THTX':
            bet.push({'Id':'501','BetContext':orderCode[1],'Lines':peilv, 'Money':price});
            break;
        case '3THDX':
        case '3LHDX':
        case '2THFX':
            var id;
            if(orderCode[0]=='3THDX'){
                id = '502';
            }else if(orderCode[0]=='3LHDX'){
                id = '402';
            }else if(orderCode[0]=='2THFX'){
                id = '301';
            }
            var betContent = content.split(',');
            for(var i=0;i<betContent.length;i++){
                bet.push({'Id':id,'BetContext':betContent[i],'Lines':peilv,'Money':price});
            }
            break;
        case '3LHTX':
            bet.push({'Id':'403','BetContext':content,'Lines':peilv,'Money':price});
            break;
        case '2THDX':
            var content1= content.split(',');
            var ball1=new Array(),ball2 =new Array();
            for (var i=0;i < content1.length;i++){
                if(content1[i].length==2){
                    ball1.push(content1[i]);
                }
                if(content1[i].length==1){
                    ball2.push(content1[i]);
                }
            }
            for (var j=0;j< ball1.length;j++){
                for (var k=0;k<ball2.length;k++){
                    betContent = ball1[j]+ball2[k];
                    bet.push({'Id':'302','BetContext':betContent,'Lines':peilv,'Money':price});
                }
            }
            break;
        case '3BTH':
        case '2BTH':
            var id,count=2;
            if(orderCode[0]=='3BTH'){
                count =3;
                id='401';
            }else if(orderCode[0]=='2BTH'){
                count=2;
                id='201';
            }
            var realContent = content.split(',');
            realContent=realContent.perm(count);
            for(var i=0;i<realContent.length;i++){
                bet.push({'Id':id, 'BetContext':realContent[i].join(''),'Lines':peilv, 'Money':price});
            }
            break;

    }
    return bet;
}
/*投注订单提交*/
function sendorder(bet) {

    var lotteryType = $("#current-lottery-type").text();
    var qihao      = $('#current-issue').text();
    var length =qihao.length;
    qihao = qihao.substr(0,length-1);
    var closeTime = $("#close-timer").text();
    if(closeTime =='00:00'){
        alert('已封盘，禁止投注');
        return false;
    }
    if(!qihao){
        alert('投注期号不能为空');
        return false;
    }
    var params = {
      'action':'bet',
      'qiHao':qihao,
      'lotteryId':lotteryType,
      'betParameters':bet
    };
    $.ajax({
        type: 'post',
        url: './ajax.php',
        data: JSON.stringify(params),
        cache: false,
        dataType: 'json',
        contentType:'application/json;charset=utf-8',
        success: function (data) {
            if(data.msg=='投注成功'){
                alert(qihao+'期'+data.msg);
            }else{
                alert(data.msg);
            }
            $('#order_table').find('tr').remove();
            $('.ball_cont').find('.ball_number').removeClass('curr');
            $('#f_gameOrder_lotterys_num').text('0');
            $('#f_gameOrder_amount').text('0');
            ORDER_LIST = [];
            parent.parent.$('body,html').animate({scrollTop:0});
            $.ajax({
                type: 'post',
                url: './ajax.php',
                data: JSON.stringify({'action':'info','lotteryId':lotteryType,'numberPostion':""}),
                cache: false,
                dataType: 'json',
                contentType:'application/json;charset=utf-8',
                success:function () {

                }
            })
        }
    });
}
function pad(num, n) {
    var len = num.toString().length;
    while (len < n) {
        num = "0" + num;
        len++;
    }
    return num;
}
!Array.prototype.perm && (Array.prototype.perm = function (a) {
    var b, c, d = this, e = new Array(a), f = function (a, b, c) {
        var d, e = [], g = [];
        for ("undefined" == typeof c && (c = 0), "undefined" == typeof b && (b = 0); c < a[b].length; c++) if (g = "undefined" == typeof a[b + 1] ? [] : f(a, b + 1, c), g.length > 0) for (d = 0; d < g.length; d++) g[d].unshift(a[b][c]), e.push(g[d]); else e.push([a[b][c]]);
        return e
    };
    for (b = 0; a > b; b++) for (e[b] = new Array(d.length >= a ? d.length - a + 1 : 0), c = 0; c < e[b].length; c++) e[b][c] = d[b + c];
    return d.length >= a ? f(e) : !1
});

Array.prototype.indexOf = function (val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == val) return i;
    }
    return -1;
};
Array.prototype.remove = function (val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};

