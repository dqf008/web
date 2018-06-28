<style>
    .group_wrap {
    width: 100%;
    height: 34px;
        background-color: rgb(240, 237, 231);
    }

    .group_btn {
    font-size: 15px;
        width: 100px;
        height: 26px;
        display: inline-block;
        margin: 3px 0 0 3px;
        text-align: center;
        line-height: 28px;
    }

    .group_btn:hover {
    cursor: pointer;
    background-color: #a69b91;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .group_active {
    background-color: #a69b91;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }
</style>
<div class="group_wrap"></div>
<script>
    var nav_str = 'jslh#marksix';
    var nav_arr;
    var html = '';
    var trans_arr = [];
    trans_arr['jslh'] = ['极速六合', '/lot/?i=jslh'];
    trans_arr['marksix'] = ['六合彩', '/lot/?i=marksix'];

    if (nav_str.indexOf('#')) {
        nav_arr = nav_str.split('#');
    } else {
        nav_arr = [nav_str];
    }
    for (var i in nav_arr) {
    html += "<span class='group_btn' id='nav_" + nav_arr[i] + "' onclick='window.location.href=\"" + trans_arr[nav_arr[i]][1] + "\";'>" + trans_arr[nav_arr[i]][0] + "</span>";

}
    $('.group_wrap').append(html);
    $('#nav_marksix').addClass('group_active');
</script>