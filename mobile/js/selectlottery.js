
(function($){
    $.fn.selectlottery=function(){
        var $this = $(this);
        $.ajax({
            method: "POST",
            url: "ajax.php",
            data: {
                action: "report",
                type: "list"
            },
            success:function(c){
                $this.find("li").click(function(){
                    $(this).addClass("active").siblings().removeClass("active");
                    var selectLosttery = $this.siblings("#lotteryList").find("select#selectLottery");
                    $id = $(this).attr("id");
                    selectLosttery.empty();
                    selectLosttery.append('<option value=""ng-selected="!GameType.Lottery">请选择游戏类型</option>');
                    for(var prop in c.msg.Lottery){
                        if($id && prop.length>4 && prop.substr(-3)==$id){
                            selectLosttery.append("<option value='"+prop+"' class='ng-binding'>"+c.msg.Lottery[prop]+"</option>")
                        }else if($id && prop.substr(-2) == $id){
                            selectLosttery.append("<option value='"+prop+"' class='ng-binding'>"+c.msg.Lottery[prop]+"</option>")
                        }else if($id && prop.substr(-4) == $id){
                            selectLosttery.append("<option value='"+prop+"' class='ng-binding'>"+c.msg.Lottery[prop]+"</option>")
                        }else if($(this).attr("class").indexOf(prop) != -1){
                            selectLosttery.append("<option value='"+prop+"' class='ng-binding'>"+c.msg.Lottery[prop]+"</option>")
                        }
                    }
                })
            }
        })
    }
})(jQuery)