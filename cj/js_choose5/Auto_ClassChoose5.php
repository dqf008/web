<?php
function Klsf_Auto($num, $type){
    $zh = $num[0] + $num[1] + $num[2] + $num[3] + $num[4];
    if ($type == 1){
        return $zh;
    }
    if ($type == 2){
        if (32 <= $zh){
            return '总和大';
        }

        if ($zh <= 29){
            return '总和小';
        }

        if ($zh == 30 || $zh=31){
            return '总和和';
        }
    }

    if ($type == 3){
        if ($zh % 2 == 0){
            return '总和双';
        }else{
            return '总和单';
        }
    }
}
function Klsf_Lh($num1,$num2){
    if($num1 > $num2){
        return '龙';
    }else{
        return '虎';
    }
}
function Klsf_Ds($ball){
    if ($ball % 2 == 0){
        return '双';
    }else{
        return '单';
    }
}

function Klsf_Dx($ball){
    if (11 <= $ball){
        return '大';
    }else{
        return '小';
    }
}

?>