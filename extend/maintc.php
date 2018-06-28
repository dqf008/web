<style>:root{--color:#D99A22}.ele-notice-mask-wrap {position: absolute;top: 0;left: 0;z-index: 1002;width: 100%;height: 100%;background-color: transparent;}#js-notice-pop {z-index:1005;position: absolute;width: 1010px;color: #222;overflow: hidden;background-color: #F8F8F8;box-shadow: 0 0 25px rgba(0,0,0,.3);border-radius: 5px;}#js-notice-pop object {display: block;}#js-notice-pop .ele-notice-title {position: relative;color: #D99A22;color: var(--color);height: 50px;line-height: 50px;font-size: 30px;padding: 0 50px 0 15px;font-weight: normal;background-color: #FFF;border-top: solid 3px #D99A22;border-top-color:var(--color);margin: 0;}#js-notice-pop .ele-notice-title i {position: absolute;right: 25px;/*color: #EAD1AC;*/cursor: pointer;font-size: 22px;    font-family: Helvetica, sans-serif;font-weight: bold;}#ele-notice-inner {height: 510px;border-top: solid 1px #EEE;}#ele-notice-sidemenu {position: relative;float: left;width: 300px;height: 100%;font-size: 15px;overflow: auto;background-color: #F2F2EA;}#js-notice-pop #ele-notice-sidemenu ul {list-style-type: none;padding: 0;margin: 0;width:100%;}#ele-notice-sidemenu li:after {display: block;height: 1px;content: "";background-color: #DFDFDF;border-top: solid 1px #FFF;}#ele-notice-sidemenu .ele-notice-menu {position: relative;height: 48px;line-height: 48px;color: #666;cursor: pointer;font-size: 15px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;padding: 0 10px 0 40px;}#ele-notice-sidemenu .ele-notice-menu-active,#ele-notice-sidemenu .ele-notice-menu:hover {color: #FFF;background-color: #D99A22;background-color:var(--color)}#ele-notice-sidemenu .ele-notice-menu-active:before,#ele-notice-sidemenu .ele-notice-menu:hover:before {display: none;}.ele-notice-icon {position: absolute;top: 17px;left: 13px;width: 16px;height: 16px;content: "";background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAgCAYAAAAbifjMAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAAWdEVYdENyZWF0aW9uIFRpbWUAMDYvMDUvMTfNrIaKAAABT0lEQVRIie2UMU7DQBBF30ZuUWKlpKHnDCm2RQpt2nQp6DgBF0BCSBTpOANKKD1FLkDBCagT4UCJxKewHZyQeNdUFHxp5PWs/szO7J91WZaNgDugTzusgIsEmALdlmTKhNOkRj4HFpHkAfAAdJOac+G9z2PYZjar1smeTQX4qfc+NzMAOjEZm/DjBEAa4KxDAV4DAVJg06u/VcLAzGYxV2lmw2rtsizLaVbiO3AF3AIfu6fpABMKXR/CEXANPO34V8DEScLMXMMp+mX2s5rvBHjx3stJIeEVMLMxcFMmSqteRV+j9/4eOAUetzYkjSQt1R5LSSMnKXQLTVg7fTfhN+8B9QBbGg/AAZ+wv4kKWK/8cihAK/y/B0BNWUOpmI0IG1YkJOUByb5JupSU7NnL28zC887/ZhagUFbr9wCIqreyca3cXuVvEwBJx5Lm9QBfT7i0a7ld0jsAAAAASUVORK5CYII=) 0 0 no-repeat;}#ele-notice-sidemenu .ele-notice-menu-active .ele-notice-icon,#ele-notice-sidemenu .ele-notice-menu:hover .ele-notice-icon {background-position: 0 100%;}.ele-notice-content-wrap {position: relative;float: left;width: 710px;height: 510px;}.ele-notice-content-wrap:before {position: absolute;top: 0;left: 0;display: block;width: 1px;height: 100%;content: "";background-color: #DFDFDF;border-left: solid 1px #FFF;}.ele-notice-content {position: absolute;top: 0;left: 5px;width: 700px;height: 540px;opacity: 0;-webkit-transition: opacity .3s;-moz-transition: opacity .3s;-ms-transition: opacity .3s;-o-transition: opacity .3s;transition: opacity .3s;overflow: auto;padding-top: 5px;}.ele-notice-content-current {z-index: 2;display: block;opacity: 1;}.ele-notice-mobile-content {display: none;}#js-notice-subtitle {color: #CB8C30;color:var(--color);font-size: 18px;font-weight: bold;margin-bottom: 20px;height:20px;line-height:20px;}#ele-notice-bottom {height: 40px;border-top: solid 1px #EEE;padding: 18px 19px 0 0;}.ele-notice-checkbox {float: right;color: #828282;}.ele-notice-checkbox input {vertical-align: middle;margin-right: 5px;}#js-notice-subcontent{word-wrap: break-word;}.ele-notice-content-wrap:after {position: absolute;top: 505px;left: 2px;display: block;width: 100%;height: 23px;z-index: 10;content: "";background-color: #f8f8f8;}</style>
<div id="js-notice-mask-wrap" class="ele-notice-mask-wrap" style="display:none;">
    <div id="js-notice-pop">
        <h1 class="ele-notice-title"><span>平台公告</span><i id="js-noticle-close">X</i></h1>
        <div id="ele-notice-inner" class="ele-notice-inner clearfix">
            <div id="ele-notice-sidemenu"><ul></ul></div>
            <div id="ele-notice-content-wrap" class="ele-notice-content-wrap">
                <div class="ele-notice-content ele-notice-content-current">
                    <!--div id="js-notice-subtitle"></div-->                                         
                    <div id="js-notice-subcontent"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


    (function(){
        var notice = $('#js-notice-pop'),
            recurrence = 'once',
            noticeContent = $('#ele-notice-content-wrap'),
            contentWidth = parseInt(700 + 30),
            noticeWidth = contentWidth,
            listWidth = 300,
            setting,
            positionX,
            positionY;

        <?php if(file_exists($_SERVER['DOCUMENT_ROOT'].'/cache/tcmini')):?>
        
        <?php endif;?>

        document.body.style.setProperty('--color', '#7F583F');
        $.getJSON("/api/?/tclist",function(result){
            if(result.data.list.length > 0 && result.data.time>=0){
                init(result.data);
            }
        });
        function init(data){
            if(data.mini == '1'){
                $('#ele-notice-sidemenu').hide();
                $('#js-notice-pop').css('width','710px');
                $('#js-notice-subtitle').hide();
                //$('#ele-notice-inner').css('height','530px');
                //$('#ele-notice-content-wrap').css('height','530px');
                listWidth = 0;
            }
			if(data.color) document.body.style.setProperty('--color', data.color);
            $('.ele-notice-title>span').html(data.title);
            if(data.time>0){
                setTimeout(function(){
                    $('#js-noticle-close').click();
                },data.time);
            }
            var tclist = data.list;
            $.each(tclist,function(i){
                var tit = $('<div class="ele-notice-menu" title="'+tclist[i].title+'" data-id="'+tclist[i].id+'"><span class="ele-notice-icon"></span>'+tclist[i].title+'</div>');
                var content = $('<div class="ele-notice-mobile-content">'+tclist[i].content+'</div>');
                var li = $("<li></li>").append(tit).append(content);
                $("#ele-notice-sidemenu>ul").append(li);  
            })
            $("#ele-notice-sidemenu").on('click', 'li', function(){                
                $("#js-notice-subtitle").html($(this).find("div.ele-notice-menu").attr('title'));
                var content = $(this).find("div.ele-notice-mobile-content").html();
                var _self = this;
                if(content == "undefined" || content == ""){
                    $("#js-notice-subcontent").html('加载中。。。');
                    var id = $(this).find('.ele-notice-menu').attr('data-id');
                    $.getJSON("/api/?/tcinfo/"+id,function(result){
                        content = result.data;
                        $("#js-notice-subcontent").html(content);
                        $(_self).find("div.ele-notice-mobile-content").html(content);
                    });
                }else{
                    $("#js-notice-subcontent").html(content);
                }
                $("#ele-notice-sidemenu .ele-notice-menu-active").removeClass("ele-notice-menu-active");
                $(this).find("div.ele-notice-menu").addClass("ele-notice-menu-active");
            });     
            $("#ele-notice-sidemenu").find("div.ele-notice-menu:eq(0)").click();  
            showTc();
        }

        function showTc(){
            $('#js-notice-mask-wrap').css({width: $('body').width(),height: $('body').height()}).fadeIn(300);
            $('#js-notice-mask-wrap').height($('body').height()).fadeIn(300);
            if ($('#ele-notice-sidemenu').length === 1) {noticeWidth = parseInt(contentWidth + listWidth);}
            /* 彈跳視窗設定 */
            positionX = Math.floor(($(window).width() - noticeWidth)/2),
            positionY = Math.floor(($(window).height() - notice.height())/2);
            if (positionY < 0) { positionY = 0;}
            setting = {'top': positionY,'left': positionX};
            if (window.innerWidth <= noticeWidth) {setting = {'top': positionY,'left': 0};}
            notice.css(setting);
            $('#js-noticle-close').click(function(){$('#js-notice-mask-wrap').fadeOut();});
            //$('#js-notice-mask-wrap').click(function(){$('#js-notice-mask-wrap').fadeOut();});
            $(window).resize(function(){
                if ($('#js-notice-mask-wrap').is(':visible')) {
                    positionX = Math.floor(($(window).width() - noticeWidth)/2),
                    positionY = Math.floor(($(window).height() - notice.height())/2);
                    if (positionY < 0) { positionY = 0;}
                    $('#js-notice-mask-wrap').css({width: $('body').width(), height: $('body').height()});
                    /*if (window.innerWidth <= noticeWidth) {
                        notice.css({'top': positionY,'left': 0 });
                        $('.ele-notice-menu-active').next('.ele-notice-mobile-content').addClass('ele-notice-content-current');
                        $('.ele-notice-menu-active').next('.ele-notice-mobile-content').slideDown();
                        return;
                    }*/
                    notice.css({'top': positionY,'left': positionX});
                    $('.ele-notice-mobile-content').removeClass('ele-notice-content-current');
                    $('.ele-notice-mobile-content').slideUp();
                }
            });
        }        
    })();
</script>