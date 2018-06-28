//限制只能输入1-9纯数字
function digitOnly($this) {
    var n = $($this);
    var r = /^\+?[1-9][0-9]*$/;
    if(!r.test(n.val())){
        n.val("");
    }
}