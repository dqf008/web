<?php if (!defined('PHPYOU'))
{
	exit('非法进入');
}
$result = $mydata2_db->query('select * from ka_kithe where n1<>0 order by id Desc LIMIT 1');
$image = $result->fetch();?><font color=ff0000><b>第<?=$image['nn'] ;?>期开奖结果</b></font>@@@<img src=images/num<?=$image['n1'] ;?>.gif>@@@<img src=images/num<?=$image['n2'] ;?>.gif>@@@<img src=images/num<?=$image['n3'] ;?>.gif>@@@<img src=images/num<?=$image['n4'] ;?>.gif>@@@<img src=images/num<?=$image['n5'] ;?>.gif>@@@<img src=images/num<?=$image['n6'] ;?>.gif>@@@<img src=images/num<?=$image['na'] ;?>.gif>###

