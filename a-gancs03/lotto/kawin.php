<?php if (!defined('PHPYOU_VER'))
{
	exit('非法进入');
}?>
  <link rel="stylesheet" href="images/xp.css" type="text/css"> 
  <script language="javascript" type="text/javascript" src="js_admin.js"></script> 
   

  <SCRIPT language=JAVASCRIPT> 
  if(self == top) {location = '/';} 
  if(window.location.host!=top.location.host){top.location=window.location;} 
  </SCRIPT> 

  <div align="center"> 
    <table width="100%" border="0" cellspacing="0" cellpadding="5"> 
      <tr class="tbtitle"> 
        <td width="29%"><?php require_once '1top.php';?></td> 
        <td width="34%">&nbsp;</td> 
        <td width="37%">&nbsp;</td> 
      </tr> 
      <tr > 
        <td height="5" colspan="3"></td> 
      </tr> 
    </table> 
    <table width="99%" border="1" cellpadding="5" cellspacing="1" bordercolor="f1f1f1"> 
      <tr> 
        <td bordercolor="cccccc" bgcolor="#FDF4CA">第<?=$_GET['kithe'];?>期开奖结算</td> 
      </tr> 
      <tr> 
        <td bordercolor="cccccc"><table width="90%" border="0" cellspacing="0" cellpadding="5" align="center" class="about"> 
          <tr> 
            <td><?php if ($_GET['kithe'] != '')
{
	$store_kithe = $_GET['kithe'];
	if (time() - intval($_SESSION['count' . $store_kithe]) <= 30)
	{?> <script type='text/javascript'>alert('为了防止结算错误，30秒之内不允许重复操作');history.back();</script><?php exit();
	}
	$_SESSION['count' . $store_kithe] = time();
	$params = array(':nn' => $_GET['kithe']);
	$resultbb = $mydata2_db->prepare('select * from ka_kithe where nn=:nn order by id desc LIMIT 1');
	$resultbb->execute($params);
	$row = $resultbb->fetch();
	$kithe = $row['nn'];
	$na = $row['na'];
	$n1 = $row['n1'];
	$n2 = $row['n2'];
	$n3 = $row['n3'];
	$n4 = $row['n4'];
	$n5 = $row['n5'];
	$n6 = $row['n6'];
	$sxsx = $row['sx'];
	$params = array(':kithe' => $kithe, ':class3' => $na);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'特码\' and class3=:class3');
	$stmt->execute($params);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'特码\' and bm<>0 and class3<>:class3  and class3<>\'单\' and class3<>\'双\' and class3<>\'大\' and class3<>\'小\' and class3<>\'合单\' and class3<>\'合双\'and class3<>\'红波\' and class3<>\'蓝波\' and class3<>\'绿波\'  ');
	$stmt->execute($params);
	$result1cc = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and class3=:class3');
	$result1cc->execute($params);
	$Rs5 = @($result1cc->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 特码结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if ($na % 2 == 1)
	{
		$class3 = '单';
		$class31 = '双';
	}
	else
	{
		$class31 = '单';
		$class3 = '双';
	}
	if ($na == 49)
	{
		$params = array(':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'特码\' and (class3=\'单\' or class3=\'双\') ');
		$stmt->execute($params);
		$result1dd = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and (class3=\'单\' or class3=\'双\')');
		$result1dd->execute($params);
		$Rs5 = @($result1dd->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	else
	{
		$params = array(':kithe' => $kithe, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $class31);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'特码\' and bm<>0 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $class3);
		$result1ee = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$result1ee->execute($params);
		$Rs5 = @($result1ee->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	if ($zwin != 0)
	{?> 特码单双结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if (25 <= $na)
	{
		$class3 = '大';
		$class31 = '小';
	}
	else
	{
		$class31 = '大';
		$class3 = '小';
	}
	if ($na == 49)
	{
		$params = array(':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'特码\' and (class3=\'大\' or class3=\'小\') ');
		$stmt->execute($params);
		$result1ff = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and (class3=\'大\' or class3=\'小\')');
		$result1ff->execute($params);
		$Rs5 = @($result1ff->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	else
	{
		$params = array(':kithe' => $kithe, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $class31);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'特码\' and bm<>0 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $class3);
		$result1gg = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$result1gg->execute($params);
		$Rs5 = @($result1gg->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	if ($zwin != 0)
	{?> 特码大小结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if ((($na % 10) + intval($na / 10)) % 2 == 0)
	{
		$class3 = '合双';
		$class31 = '合单';
	}
	else
	{
		$class31 = '合双';
		$class3 = '合单';
	}
	if ($na == 49)
	{
		$params = array(':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'特码\' and (class3=\'合单\' or class3=\'合双\') ');
		$stmt->execute($params);
		$result1vv = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and (class3=\'合单\' or class3=\'合双\')');
		$result1vv->execute($params);
		$Rs5 = @($result1vv->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	else
	{
		$params = array(':kithe' => $kithe, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $class31);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'特码\' and bm<>0 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	if ($zwin != 0)
	{?> 特码合单合双结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$class3 = ka_Color_s($na);
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'特码\' and bm<>0 and  (class3=\'红波\' or class3=\'蓝波\' or class3=\'绿波\')');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $class3);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'特码\' and class3=:class3');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $class3);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and class3=:class3');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 特码波色结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	if (($sxsx == '狗') || ($sxsx == '猪') || ($sxsx == '鸡') || ($sxsx == '羊') || ($sxsx == '马') || ($sxsx == '牛'))
	{
		$psx = '家禽';
		$psx1 = '野兽';
	}
	else
	{
		$psx = '野兽';
		$psx1 = '家禽';
	}
	if ($na == 49)
	{
		$params = array(':kithe' => $kithe, ':psx' => $psx, ':psx1' => $psx1);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'特码\'  and ( class3=:psx or  class3=:psx1 ) ');
		$stmt->execute($params);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\'  and ( class3=:psx or  class3=:psx1 )');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
	}
	else
	{
		$params = array(':kithe' => $kithe, ':psx1' => $psx1);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'特码\' and  class3=:psx1 and bm<>0 ');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':psx' => $psx);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'特码\'  and class3=:psx ');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':psx' => $psx);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\'  and class3=:psx');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
	}
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 家禽/野兽结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$wdwx0 = $na % 10;
	if (4 < $wdwx0)
	{
		$class3 = '尾大';
		$class31 = '尾小';
	}
	else
	{
		$class31 = '尾大';
		$class3 = '尾小';
	}
	if ($na == 49)
	{
		$params = array(':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'特码\'  and (class3=\'尾大\' or class3=\'尾小\')');
		$stmt->execute($params);
		$result1ff = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and (class3=\'尾大\' or class3=\'尾小\')');
		$result1ff->execute($params);
		$Rs5 = @($result1ff->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	else
	{
		$params = array(':kithe' => $kithe, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $class31);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'特码\' and bm<>0 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $class3);
		$result1gg = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$result1gg->execute($params);
		$Rs5 = @($result1gg->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	if ($zwin != 0)
	{?> 尾大尾小结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if ($na < 25)
	{
		if ($na % 2 == 1)
		{
			$ddxd = '小单';
			$ddxd1 = '小双';
		}
		else
		{
			$ddxd1 = '小单';
			$ddxd = '小双';
		}
	}
	else if ($na % 2 == 1)
	{
		$ddxd = '大单';
		$ddxd1 = '大双';
	}
	else
	{
		$ddxd1 = '大单';
		$ddxd = '大双';
	}
	if ($na < 50)
	{
		$params = array(':kithe' => $kithe, ':class3' => $ddxd);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $ddxd1);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'特码\' and bm<>0 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $ddxd);
		$resulddxd = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'特码\' and class3=:class3');
		$resulddxd->execute($params);
		$Rs5 = @($resulddxd->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
		if ($zwin != 0)
		{?> 大小单双结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	}
	$i = 1;
	for (;$i <= 6;$i++)
	{
		if ($i == 1)
		{
			$class2 = '正1特';
			$tmtm = $n1;
		}
		if ($i == 2)
		{
			$class2 = '正2特';
			$tmtm = $n2;
		}
		if ($i == 3)
		{
			$class2 = '正3特';
			$tmtm = $n3;
		}
		if ($i == 4)
		{
			$class2 = '正4特';
			$tmtm = $n4;
		}
		if ($i == 5)
		{
			$class2 = '正5特';
			$tmtm = $n5;
		}
		if ($i == 6)
		{
			$class2 = '正6特';
			$tmtm = $n6;
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $tmtm);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
		$stmt->execute($params);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正特\' and class2=:class2 and bm<>0 and class3<>:class3 and class3<>\'单\' and class3<>\'双\' and class3<>\'大\' and class3<>\'小\' and class3<>\'合单\' and class3<>\'合双\'and class3<>\'红波\' and class3<>\'蓝波\' and class3<>\'绿波\'  ');
		$stmt->execute($params);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		if ($tmtm % 2 == 1)
		{
			$class3 = '单';
			$class31 = '双';
		}
		else
		{
			$class31 = '单';
			$class3 = '双';
		}
		if ($tmtm == 49)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'正特\' and class2=:class2 and (class3=\'单\' or class3=\'双\') ');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe);
			$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and (class3=\'单\' or class3=\'双\')');
			$result1->execute($params);
			$Rs5 = @($result1->fetch());
			if ($Rs5 != '')
			{
				$zwin = $Rs5['re'];
			}
			else
			{
				$zwin = 0;
			}
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正特\' and class2=:class2 and bm<>0 and class3=:class3');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
			$result1->execute($params);
			$Rs5 = @($result1->fetch());
			if ($Rs5 != '')
			{
				$zwin = $Rs5['re'];
			}
			else
			{
				$zwin = 0;
			}
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>单双结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		if (25 <= $tmtm)
		{
			$class3 = '大';
			$class31 = '小';
		}
		else
		{
			$class31 = '大';
			$class3 = '小';
		}
		if ($tmtm == 49)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'正特\' and class2=:class2 and (class3=\'大\' or class3=\'小\') ');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe);
			$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and (class3=\'大\' or class3=\'小\')');
			$result1->execute($params);
			$Rs5 = @($result1->fetch());
			if ($Rs5 != '')
			{
				$zwin = $Rs5['re'];
			}
			else
			{
				$zwin = 0;
			}
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正特\' and class2=:class2 and bm<>0 and class3=:class3');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
			$result1->execute($params);
			$Rs5 = @($result1->fetch());
			if ($Rs5 != '')
			{
				$zwin = $Rs5['re'];
			}
			else
			{
				$zwin = 0;
			}
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>大小结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		if ((($tmtm % 10) + intval($tmtm / 10)) % 2 == 0)
		{
			$class3 = '合双';
			$class31 = '合单';
		}
		else
		{
			$class31 = '合双';
			$class3 = '合单';
		}
		if ($tmtm == 49)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'正特\' and class2=:class2 and (class3=\'合单\' or class3=\'合双\') ');
			$stmt->execute($params);
			$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and class2=:class2 and (class3=\'合单\' or class3=\'合双\')');
			$result1->execute($params);
			$Rs5 = @($result1->fetch());
			if ($Rs5 != '')
			{
				$zwin = $Rs5['re'];
			}
			else
			{
				$zwin = 0;
			}
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正特\' and class2=:class2 and bm<>0 and class3=:class3');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
			$result1->execute($params);
			$Rs5 = @($result1->fetch());
			if ($Rs5 != '')
			{
				$zwin = $Rs5['re'];
			}
			else
			{
				$zwin = 0;
			}
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>合单合双结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		if (6 < (($tmtm % 10) + intval($tmtm / 10)))
		{
			$class3 = '合大';
			$class31 = '合小';
		}
		else
		{
			$class31 = '合大';
			$class3 = '合小';
		}
		if ($tmtm == 49)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'正特\' and class2=:class2 and (class3=\'合大\' or class3=\'合小\') ');
			$stmt->execute($params);
			$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and class2=:class2 and (class3=\'合大\' or class3=\'合小\')');
			$result1->execute($params);
			$Rs5 = @($result1->fetch());
			if ($Rs5 != '')
			{
				$zwin = $Rs5['re'];
			}
			else
			{
				$zwin = 0;
			}
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正特\' and class2=:class2 and bm<>0 and class3=:class3');
			$stmt->execute($params);
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
			$result1->execute($params);
			$Rs5 = @($result1->fetch());
			if ($Rs5 != '')
			{
				$zwin = $Rs5['re'];
			}
			else
			{
				$zwin = 0;
			}
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>合大合小结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		$class3 = ka_Color_s($tmtm);
		$params = array(':kithe' => $kithe, ':class2' => $class2);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正特\' and class2=:class2 and bm<>0 and  (class3=\'红波\' or class3=\'蓝波\' or class3=\'绿波\') ');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>波色结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	}
	$i = 1;
	for (;$i <= 6;$i++)
	{
		if ($i == 1)
		{
			$class2 = '正码1';
			$tmtm = $n1;
		}
		if ($i == 2)
		{
			$class2 = '正码2';
			$tmtm = $n2;
		}
		if ($i == 3)
		{
			$class2 = '正码3';
			$tmtm = $n3;
		}
		if ($i == 4)
		{
			$class2 = '正码4';
			$tmtm = $n4;
		}
		if ($i == 5)
		{
			$class2 = '正码5';
			$tmtm = $n5;
		}
		if ($i == 6)
		{
			$class2 = '正码6';
			$tmtm = $n6;
		}
		if ($tmtm % 2 == 1)
		{
			$class3 = '单';
			$class31 = '双';
		}
		else
		{
			$class31 = '单';
			$class3 = '双';
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and bm<>0 and class3=:class3');
		$stmt->execute($params);
		if ($tmtm == 49)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and (class3=\'单\' or class3=\'双\')');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>单双结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		if (25 <= $tmtm)
		{
			$class3 = '大';
			$class31 = '小';
		}
		else
		{
			$class31 = '大';
			$class3 = '小';
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and bm<>0 and class3=:class3');
		$stmt->execute($params);
		if ($tmtm == 49)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and (class3=\'大\' or class3=\'小\')');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>大小结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		if (6 < (($tmtm % 10) + intval($tmtm / 10)))
		{
			$class3 = '合大';
			$class31 = '合小';
		}
		else
		{
			$class31 = '合大';
			$class3 = '合小';
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and bm<>0 and class3=:class3');
		$stmt->execute($params);
		if ($tmtm == 49)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and (class3=\'合大\' or class3=\'合小\')');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>合大合小结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		if ((($tmtm % 10) + intval($tmtm / 10)) % 2 == 1)
		{
			$class3 = '合单';
			$class31 = '合双';
		}
		else
		{
			$class31 = '合单';
			$class3 = '合双';
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and bm<>0 and class3=:class3');
		$stmt->execute($params);
		if ($tmtm == 49)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and (class3=\'合单\' or class3=\'合双\')');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>合单合双结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		if (4 < ($tmtm % 10))
		{
			$class3 = '尾大';
			$class31 = '尾小';
		}
		else
		{
			$class31 = '尾大';
			$class3 = '尾小';
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and bm<>0 and class3=:class3');
		$stmt->execute($params);
		if ($tmtm == 49)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and (class3=\'尾大\' or class3=\'尾小\')');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>尾大尾小结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
		$class3 = ka_Color_s($tmtm);
		$params = array(':kithe' => $kithe, ':class2' => $class2);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and bm<>0 and  (class3=\'红波\' or class3=\'蓝波\' or class3=\'绿波\') ');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正1-6\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
		if ($zwin != 0)
		{
 echo $class2 ;?>波色结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	}
	$class2 = '正码';
	$params = array(':kithe' => $kithe, ':n1' => $n1, ':n2' => $n2, ':n3' => $n3, ':n4' => $n4, ':n5' => $n5, ':n6' => $n6);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正码\' and  (class3=:n1 or class3=:n2  or class3=:n3 or class3=:n4  or class3=:n5  or class3=:n6) ');
	$stmt->execute($params);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正码\' and   bm<>0 and class3<>:n1 and class3<>:n2 and class3<>:n3 and class3<>:n4  and class3<>:n5  and class3<>:n6 and class3<>\'总单\' and class3<>\'总双\' and class3<>\'总大\' and class3<>\'总小\' ');
	$stmt->execute($params);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正码\'  and (class3=:n1 or class3=:n2  or class3=:n3 or class3=:n4  or class3=:n5  or class3=:n6)');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{
 echo $class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$sum_number = $n1 + $n2 + $n3 + $n4 + $n5 + $n6 + $na;
	$class2 = '正码';
	if ($sum_number % 2 == 1)
	{
		$class3 = '总单';
		$class31 = '总双';
	}
	else
	{
		$class31 = '总单';
		$class3 = '总双';
	}
	$params = array(':kithe' => $kithe, ':class3' => $class3);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正码\'  and class3=:class3');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $class31);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正码\'  and bm<>0 and class3=:class3');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $class3);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正码\'  and class3=:class3');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{
 echo $class2 ;?>总单总双结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$class2 = '正码';
	if ($sum_number <= 174)
	{
		$class3 = '总小';
		$class31 = '总大';
	}
	else
	{
		$class31 = '总小';
		$class3 = '总大';
	}
	$params = array(':kithe' => $kithe, ':class3' => $class3);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正码\'  and class3=:class3');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $class31);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正码\'  and bm<>0 and class3=:class3');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $class3);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正码\'  and class3=:class3');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{
 echo $class2 ;?>总大总小结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$class2 = '三全中';
	$zwin = 0;
	$params = array(':kithe' => $kithe);
	$result = $mydata2_db->prepare('Select distinct(class3),class1,class2 from ka_tan where class1=\'连码\' and class2=\'三全中\' and Kithe=:kithe');
	$result->execute($params);
	$t = 0;
	while ($image = $result->fetch())
	{
		$number5 = 0;
		$class3 = $image['class3'];
		$numberxz = explode(',', $class3);
		$ss1 = count($numberxz);
		$i = 0;
		for (;$i <= $ss1;$i++)
		{
			if ('#' . $numberxz[$i] == '#' . $n1)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n2)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n3)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n4)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n5)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n6)
			{
				$number5++;
			}
		}
		if (2 < $number5)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin += $Rs5['re'];
		}
	}
	if ($zwin != 0)
	{?> 连码<?=$class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	$class2 = '三中二';
	$zwin = 0;
	$params = array(':kithe' => $kithe);
	$result = $mydata2_db->prepare('Select distinct(class3),class1,class2 from ka_tan where class1=\'连码\' and class2=\'三中二\' and Kithe=:kithe');
	$result->execute($params);
	$t = 0;
	while ($image = @($result->fetch()))
	{
		$number5 = 0;
		$class3 = $image['class3'];
		$numberxz = explode(',', $class3);
		$ss1 = count($numberxz);
		$i = 0;
		for (;$i <= $ss1;$i++)
		{
			if ('#' . $numberxz[$i] == '#' . $n1)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n2)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n3)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n4)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n5)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n6)
			{
				$number5++;
			}
		}
		if (2 < $number5)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		else if ($number5 == 2)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin += $Rs5['re'];
		}
	}
	if ($zwin != 0)
	{?> 连码<?=$class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	$class2 = '二全中';
	$zwin = 0;
	$params = array(':kithe' => $kithe);
	$result = $mydata2_db->prepare('Select distinct(class3),class1,class2 from ka_tan where class1=\'连码\' and class2=\'二全中\' and Kithe=:kithe');
	$result->execute($params);
	$t = 0;
	while ($image = @($result->fetch()))
	{
		$number5 = 0;
		$class3 = $image['class3'];
		$numberxz = explode(',', $class3);
		$ss1 = count($numberxz);
		$i = 0;
		for (;$i <= $ss1;$i++)
		{
			if ('#' . $numberxz[$i] == '#' . $n1)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n2)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n3)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n4)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n5)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n6)
			{
				$number5++;
			}
		}
		if (1 < $number5)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin += $Rs5['re'];
		}
	}
	if ($zwin != 0)
	{?> 连码<?=$class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	$class2 = '二中特';
	$zwin = 0;
	$params = array(':kithe' => $kithe);
	$result = $mydata2_db->prepare('Select distinct(class3),class1,class2 from ka_tan where class1=\'连码\' and class2=\'二中特\' and Kithe=:kithe');
	$result->execute($params);
	$t = 0;
	while ($image = @($result->fetch()))
	{
		$number5 = 0;
		$number4 = 0;
		$class3 = $image['class3'];
		$numberxz = explode(',', $class3);
		$ss1 = count($numberxz);
		$i = 0;
		for (;$i <= $ss1;$i++)
		{
			if ('#' . $numberxz[$i] == '#' . $n1)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n2)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n3)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n4)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n5)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n6)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $na)
			{
				$number4++;
			}
		}
		if (1 < $number5)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		else if (($number4 == 1) && ($number5 == 1))
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin += $Rs5['re'];
		}
	}
	if ($zwin != 0)
	{?> 连码<?=$class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	$class2 = '特串';
	$zwin = 0;
	$params = array(':kithe' => $kithe);
	$result = $mydata2_db->prepare('Select distinct(class3),class1,class2 from ka_tan where class1=\'连码\' and class2=\'特串\' and Kithe=:kithe');
	$result->execute($params);
	$t = 0;
	while ($image = $result->fetch())
	{
		$number5 = 0;
		$number4 = 0;
		$class3 = $image['class3'];
		$numberxz = explode(',', $class3);
		$ss1 = count($numberxz);
		$i = 0;
		for (;$i <= $ss1;$i++)
		{
			if ('#' . $numberxz[$i] == '#' . $n1)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n2)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n3)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n4)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n5)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n6)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $na)
			{
				$number4++;
			}
		}
		if (($number4 == 1) && ($number5 == 1))
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin += $Rs5['re'];
		}
	}
	if ($zwin != 0)
	{?> 连码<?=$class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	$class2 = '四中一';
	$zwin = 0;
	$params = array(':kithe' => $kithe);
	$result = $mydata2_db->prepare('Select distinct(class3),class1,class2 from ka_tan where class1=\'连码\' and class2=\'四中一\' and Kithe=:kithe');
	$result->execute($params);
	$t = 0;
	while ($image = $result->fetch())
	{
		$number5 = 0;
		$class3 = $image['class3'];
		$numberxz = explode(',', $class3);
		$ss1 = count($numberxz);
		$i = 0;
		for (;$i < $ss1;$i++)
		{
			if ('#' . $numberxz[$i] == '#' . $n1)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n2)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n3)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n4)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n5)
			{
				$number5++;
			}
			if ('#' . $numberxz[$i] == '#' . $n6)
			{
				$number5++;
			}
		}
		if (0 < $number5)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'连码\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin += $Rs5['re'];
		}
	}
	if ($zwin != 0)
	{?> 连码<?=$class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	$class2 = '过关';
	$zwin = 0;
	$params = array(':kithe' => $kithe);
	$result55 = $mydata2_db->prepare('Select distinct(class3),class1,class2 from ka_tan where class1=\'过关\' and Kithe=:kithe');
	$result55->execute($params);
	while ($image = $result55->fetch())
	{
		$number5 = 0;
		$number4 = 0;
		$class3 = $image['class3'];
		$class2 = $image['class2'];
		$class33 = explode(',', $class3);
		$class22 = explode(',', $class2);
		$ss1 = count($class33);
		$ss2 = count($class22);
		$k = 0;
		$result = 0;
		$result2 = 1;
		$forflag = 0;
		$i = 0;
		for (;$i < ($ss2 - 1);
		$i++)
		{
			if ($class22[$i] == '正码1')
			{
				$tmtm = $n1;
			}
			if ($class22[$i] == '正码2')
			{
				$tmtm = $n2;
			}
			if ($class22[$i] == '正码3')
			{
				$tmtm = $n3;
			}
			if ($class22[$i] == '正码4')
			{
				$tmtm = $n4;
			}
			if ($class22[$i] == '正码5')
			{
				$tmtm = $n5;
			}
			if ($class22[$i] == '正码6')
			{
				$tmtm = $n6;
			}
			$result = 0;
			switch ($class33[$k])
			{
				case '大': if (25 <= $tmtm)
				{
					$result = 1;
				}
				break;
				case '小': if ($tmtm < 25)
				{
					$result = 1;
				}
				break;
				case '单': if ($tmtm % 2 == 1)
				{
					$result = 1;
				}
				break;
				case '双': if ($tmtm % 2 == 0)
				{
					$result = 1;
				}
				break;
				case '红波': if (ka_Color_s($tmtm) == '红波')
				{
					$result = 1;
				}
				break;
				case '蓝波': if (ka_Color_s($tmtm) == '蓝波')
				{
					$result = 1;
				}
				break;
				case '绿波': if (ka_Color_s($tmtm) == '绿波')
				{
					$result = 1;
				}
				break;
				default: $result = 0;
				break;
			}
			if ($result == 0)
			{
				$result2 = 0;
			}
			$k += 2;
			$forflag++;
		}
		if ($forflag == 0)
		{
			$result2 = 0;
		}
		if ($result2 == 1)
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'过关\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		else
		{
			$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'过关\' and class2=:class2 and class3=:class3');
			$stmt->execute($params);
		}
		$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class3);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'过关\' and class2=:class2 and class3=:class3');
		$result1->execute($params);
		$Rs5 = $result1->fetch();
		if ($Rs5 != '')
		{
			$zwin += $Rs5['re'];
		}
	}
	if ($zwin != 0)
	{?> 过关结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><hr><?php }
	$class2 = '半波';
	$class3 = ka_Color_s($na);
	if ($class3 == '红波')
	{
		if (25 <= $na)
		{
			$class31 = '红大';
		}
		else
		{
			$class31 = '红小';
		}
		if ($na % 2 == 1)
		{
			$class32 = '红单';
		}
		else
		{
			$class32 = '红双';
		}
		if ((($na % 10) + intval($na / 10)) % 2 == 1)
		{
			$class33 = '红合单';
		}
		else
		{
			$class33 = '红合双';
		}
	}
	if ($class3 == '绿波')
	{
		if (25 <= $na)
		{
			$class31 = '绿大';
		}
		else
		{
			$class31 = '绿小';
		}
		if ($na % 2 == 1)
		{
			$class32 = '绿单';
		}
		else
		{
			$class32 = '绿双';
		}
		if ((($na % 10) + intval($na / 10)) % 2 == 1)
		{
			$class33 = '绿合单';
		}
		else
		{
			$class33 = '绿合双';
		}
	}
	if ($class3 == '蓝波')
	{
		if (25 <= $na)
		{
			$class31 = '蓝大';
		}
		else
		{
			$class31 = '蓝小';
		}
		if ($na % 2 == 1)
		{
			$class32 = '蓝单';
		}
		else
		{
			$class32 = '蓝双';
		}
		if ((($na % 10) + intval($na / 10)) % 2 == 1)
		{
			$class33 = '蓝合单';
		}
		else
		{
			$class33 = '蓝合双';
		}
	}
	$params = array(':kithe' => $kithe, ':class2' => $class2);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'半波\' and class2=:class2 and bm<>0 ');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class2' => $class2, ':class33' => $class33, ':class31' => $class31, ':class32' => $class32);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'半波\' and class2=:class2 and (class3=:class33 or class3=:class31 or class3=:class32) ');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class2' => $class2, ':class33' => $class33, ':class31' => $class31, ':class32' => $class32);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'半波\' and class2=:class2 and (class3=:class33 or class3=:class31 or class3=:class32)');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{
 echo $class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$class2 = '半半波';
	$class3 = ka_Color_s($na);
	if ($class3 == '红波')
	{
		if (25 <= $na)
		{
			if ($na % 2 == 1)
			{
				$class31 = '红大单';
			}
			else
			{
				$class31 = '红大双';
			}
		}
		else if ($na % 2 == 1)
		{
			$class31 = '红小单';
		}
		else
		{
			$class31 = '红小双';
		}
	}
	if ($class3 == '绿波')
	{
		if (25 <= $na)
		{
			if ($na % 2 == 1)
			{
				$class31 = '绿大单';
			}
			else
			{
				$class31 = '绿大双';
			}
		}
		else if ($na % 2 == 1)
		{
			$class31 = '绿小单';
		}
		else
		{
			$class31 = '绿小双';
		}
	}
	if ($class3 == '蓝波')
	{
		if (25 <= $na)
		{
			if ($na % 2 == 1)
			{
				$class31 = '蓝大单';
			}
			else
			{
				$class31 = '蓝大双';
			}
		}
		else if ($na % 2 == 1)
		{
			$class31 = '蓝小单';
		}
		else
		{
			$class31 = '蓝小双';
		}
	}
	$params = array(':kithe' => $kithe, ':class2' => $class2);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'半半波\' and class2=:class2 and bm<>0 ');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'半半波\' and class2=:class2 and class3=:class3');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class2' => $class2, ':class3' => $class31);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'半半波\' and class2=:class2 and class3=:class3');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{
 echo $class2 ;?>结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if ($na < 10)
	{
		$naa = '0' . $na;
	}
	else
	{
		$naa = $na;
	}
	$sxsx = Get_sx_Color($naa);
	$params = array(':kithe' => $kithe, ':class3' => $sxsx);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'生肖\' and class2=\'特肖\' and class3=:class3');
	$stmt->execute($params);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'生肖\' and class2=\'特肖\' and bm<>0 and class3<>:class3   ');
	$stmt->execute($params);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'生肖\' and class2=\'特肖\' and class3=:class3');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 特肖结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if ($na < 10)
	{
		$naa = '0' . $na;
	}
	else
	{
		$naa = $na;
	}
	$sxsx = Get_sx_Color($naa);
	if ($na == 49)
	{
		$params = array(':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'生肖\' and (class2=\'二肖\'  or class2=\'三肖\'  or class2=\'四肖\' or class2=\'五肖\'  or class2=\'六肖\' or class2=\'七肖\'  or class2=\'八肖\' or class2=\'九肖\'  or class2=\'十肖\' or class2=\'十一肖\' ) ');
		$stmt->execute($params);
		$result1dd = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'生肖\' and (class2=\'二肖\'  or class2=\'三肖\'  or class2=\'四肖\' or class2=\'五肖\'  or class2=\'六肖\'  or class2=\'七肖\'  or class2=\'八肖\' or class2=\'九肖\'  or class2=\'十肖\' or class2=\'十一肖\' )');
		$result1dd->execute($params);
		$Rs5 = $result1dd->fetch();
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	else
	{
		$params = array(':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'生肖\' and (class2=\'二肖\'  or class2=\'三肖\'  or class2=\'四肖\' or class2=\'五肖\'  or class2=\'六肖\'  or class2=\'七肖\'  or class2=\'八肖\' or class2=\'九肖\'  or class2=\'十肖\' or class2=\'十一肖\' ) and bm<>0 ');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => '%' . $sxsx . '%');
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'生肖\' and (class2=\'二肖\'  or class2=\'三肖\'  or class2=\'四肖\' or class2=\'五肖\'  or class2=\'六肖\'  or class2=\'七肖\'  or class2=\'八肖\' or class2=\'九肖\'  or class2=\'十肖\' or class2=\'十一肖\' ) and class3 LIKE :class3 ');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => '%' . $sxsx . '%');
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'生肖\' and (class2=\'二肖\'  or class2=\'三肖\'  or class2=\'四肖\' or class2=\'五肖\'  or class2=\'六肖\'  or class2=\'七肖\'  or class2=\'八肖\' or class2=\'九肖\'  or class2=\'十肖\' or class2=\'十一肖\') and class3 LIKE :class3 ');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	if ($zwin != 0)
	{?> 合肖结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if ($na < 10)
	{
		$naa = '0' . $na;
		$sxsx0 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $na;
		$sxsx0 = Get_sx_Color($naa);
	}
	if ($n1 < 10)
	{
		$naa = '0' . $n1;
		$sxsx1 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n1;
		$sxsx1 = Get_sx_Color($naa);
	}
	if ($n2 < 10)
	{
		$naa = '0' . $n2;
		$sxsx2 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n2;
		$sxsx2 = Get_sx_Color($naa);
	}
	if ($n3 < 10)
	{
		$naa = '0' . $n3;
		$sxsx3 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n3;
		$sxsx3 = Get_sx_Color($naa);
	}
	if ($n4 < 10)
	{
		$naa = '0' . $n4;
		$sxsx4 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n4;
		$sxsx4 = Get_sx_Color($naa);
	}
	if ($n5 < 10)
	{
		$naa = '0' . $n5;
		$sxsx5 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n5;
		$sxsx5 = Get_sx_Color($naa);
	}
	if ($n6 < 10)
	{
		$naa = '0' . $n6;
		$sxsx6 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n6;
		$sxsx6 = Get_sx_Color($naa);
	}
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'生肖\' and class2=\'一肖\' and bm<>0 ');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':sxsx0' => $sxsx0, ':sxsx1' => $sxsx1, ':sxsx2' => $sxsx2, ':sxsx3' => $sxsx3, ':sxsx4' => $sxsx4, ':sxsx5' => $sxsx5, ':sxsx6' => $sxsx6);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'生肖\' and class2=\'一肖\' and (class3=:sxsx0 or class3=:sxsx1 or class3=:sxsx2 or class3=:sxsx3 or class3=:sxsx4 or class3=:sxsx5 or class3=:sxsx6  )');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':sxsx0' => $sxsx0, ':sxsx1' => $sxsx1, ':sxsx2' => $sxsx2, ':sxsx3' => $sxsx3, ':sxsx4' => $sxsx4, ':sxsx5' => $sxsx5, ':sxsx6' => $sxsx6);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'生肖\' and class2=\'一肖\' and (class3=:sxsx0 or class3=:sxsx1 or class3=:sxsx2 or class3=:sxsx3 or class3=:sxsx4 or class3=:sxsx5 or class3=:sxsx6)');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 一肖结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if ($n1 < 10)
	{
		$naa = '0' . $n1;
		$sxsx1 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n1;
		$sxsx1 = Get_sx_Color($naa);
	}
	if ($n2 < 10)
	{
		$naa = '0' . $n2;
		$sxsx2 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n2;
		$sxsx2 = Get_sx_Color($naa);
	}
	if ($n3 < 10)
	{
		$naa = '0' . $n3;
		$sxsx3 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n3;
		$sxsx3 = Get_sx_Color($naa);
	}
	if ($n4 < 10)
	{
		$naa = '0' . $n4;
		$sxsx4 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n4;
		$sxsx4 = Get_sx_Color($naa);
	}
	if ($n5 < 10)
	{
		$naa = '0' . $n5;
		$sxsx5 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n5;
		$sxsx5 = Get_sx_Color($naa);
	}
	if ($n6 < 10)
	{
		$naa = '0' . $n6;
		$sxsx6 = Get_sx_Color($naa);
	}
	else
	{
		$naa = $n6;
		$sxsx6 = Get_sx_Color($naa);
	}
	if ($sxsx1 == '鼠')
	{
		$sss['鼠'] = $sss['鼠'] + 1;
	}
	if ($sxsx1 == '虎')
	{
		$sss['虎'] = $sss['虎'] + 1;
	}
	if ($sxsx1 == '龙')
	{
		$sss['龙'] = $sss['龙'] + 1;
	}
	if ($sxsx1 == '马')
	{
		$sss['马'] = $sss['马'] + 1;
	}
	if ($sxsx1 == '猴')
	{
		$sss['猴'] = $sss['猴'] + 1;
	}
	if ($sxsx1 == '狗')
	{
		$sss['狗'] = $sss['狗'] + 1;
	}
	if ($sxsx1 == '牛')
	{
		$sss['牛'] = $sss['牛'] + 1;
	}
	if ($sxsx1 == '兔')
	{
		$sss['兔'] = $sss['兔'] + 1;
	}
	if ($sxsx1 == '蛇')
	{
		$sss['蛇'] = $sss['蛇'] + 1;
	}
	if ($sxsx1 == '羊')
	{
		$sss['羊'] = $sss['羊'] + 1;
	}
	if ($sxsx1 == '鸡')
	{
		$sss['鸡'] = $sss['鸡'] + 1;
	}
	if ($sxsx1 == '猪')
	{
		$sss['猪'] = $sss['猪'] + 1;
	}
	if ($sxsx2 == '鼠')
	{
		$sss['鼠'] = $sss['鼠'] + 1;
	}
	if ($sxsx2 == '虎')
	{
		$sss['虎'] = $sss['虎'] + 1;
	}
	if ($sxsx2 == '龙')
	{
		$sss['龙'] = $sss['龙'] + 1;
	}
	if ($sxsx2 == '马')
	{
		$sss['马'] = $sss['马'] + 1;
	}
	if ($sxsx2 == '猴')
	{
		$sss['猴'] = $sss['猴'] + 1;
	}
	if ($sxsx2 == '狗')
	{
		$sss['狗'] = $sss['狗'] + 1;
	}
	if ($sxsx2 == '牛')
	{
		$sss['牛'] = $sss['牛'] + 1;
	}
	if ($sxsx2 == '兔')
	{
		$sss['兔'] = $sss['兔'] + 1;
	}
	if ($sxsx2 == '蛇')
	{
		$sss['蛇'] = $sss['蛇'] + 1;
	}
	if ($sxsx2 == '羊')
	{
		$sss['羊'] = $sss['羊'] + 1;
	}
	if ($sxsx2 == '鸡')
	{
		$sss['鸡'] = $sss['鸡'] + 1;
	}
	if ($sxsx2 == '猪')
	{
		$sss['猪'] = $sss['猪'] + 1;
	}
	if ($sxsx3 == '鼠')
	{
		$sss['鼠'] = $sss['鼠'] + 1;
	}
	if ($sxsx3 == '虎')
	{
		$sss['虎'] = $sss['虎'] + 1;
	}
	if ($sxsx3 == '龙')
	{
		$sss['龙'] = $sss['龙'] + 1;
	}
	if ($sxsx3 == '马')
	{
		$sss['马'] = $sss['马'] + 1;
	}
	if ($sxsx3 == '猴')
	{
		$sss['猴'] = $sss['猴'] + 1;
	}
	if ($sxsx3 == '狗')
	{
		$sss['狗'] = $sss['狗'] + 1;
	}
	if ($sxsx3 == '牛')
	{
		$sss['牛'] = $sss['牛'] + 1;
	}
	if ($sxsx3 == '兔')
	{
		$sss['兔'] = $sss['兔'] + 1;
	}
	if ($sxsx3 == '蛇')
	{
		$sss['蛇'] = $sss['蛇'] + 1;
	}
	if ($sxsx3 == '羊')
	{
		$sss['羊'] = $sss['羊'] + 1;
	}
	if ($sxsx3 == '鸡')
	{
		$sss['鸡'] = $sss['鸡'] + 1;
	}
	if ($sxsx3 == '猪')
	{
		$sss['猪'] = $sss['猪'] + 1;
	}
	if ($sxsx4 == '鼠')
	{
		$sss['鼠'] = $sss['鼠'] + 1;
	}
	if ($sxsx4 == '虎')
	{
		$sss['虎'] = $sss['虎'] + 1;
	}
	if ($sxsx4 == '龙')
	{
		$sss['龙'] = $sss['龙'] + 1;
	}
	if ($sxsx4 == '马')
	{
		$sss['马'] = $sss['马'] + 1;
	}
	if ($sxsx4 == '猴')
	{
		$sss['猴'] = $sss['猴'] + 1;
	}
	if ($sxsx4 == '狗')
	{
		$sss['狗'] = $sss['狗'] + 1;
	}
	if ($sxsx4 == '牛')
	{
		$sss['牛'] = $sss['牛'] + 1;
	}
	if ($sxsx4 == '兔')
	{
		$sss['兔'] = $sss['兔'] + 1;
	}
	if ($sxsx4 == '蛇')
	{
		$sss['蛇'] = $sss['蛇'] + 1;
	}
	if ($sxsx4 == '羊')
	{
		$sss['羊'] = $sss['羊'] + 1;
	}
	if ($sxsx4 == '鸡')
	{
		$sss['鸡'] = $sss['鸡'] + 1;
	}
	if ($sxsx4 == '猪')
	{
		$sss['猪'] = $sss['猪'] + 1;
	}
	if ($sxsx5 == '鼠')
	{
		$sss['鼠'] = $sss['鼠'] + 1;
	}
	if ($sxsx5 == '虎')
	{
		$sss['虎'] = $sss['虎'] + 1;
	}
	if ($sxsx5 == '龙')
	{
		$sss['龙'] = $sss['龙'] + 1;
	}
	if ($sxsx5 == '马')
	{
		$sss['马'] = $sss['马'] + 1;
	}
	if ($sxsx5 == '猴')
	{
		$sss['猴'] = $sss['猴'] + 1;
	}
	if ($sxsx5 == '狗')
	{
		$sss['狗'] = $sss['狗'] + 1;
	}
	if ($sxsx5 == '牛')
	{
		$sss['牛'] = $sss['牛'] + 1;
	}
	if ($sxsx5 == '兔')
	{
		$sss['兔'] = $sss['兔'] + 1;
	}
	if ($sxsx5 == '蛇')
	{
		$sss['蛇'] = $sss['蛇'] + 1;
	}
	if ($sxsx5 == '羊')
	{
		$sss['羊'] = $sss['羊'] + 1;
	}
	if ($sxsx5 == '鸡')
	{
		$sss['鸡'] = $sss['鸡'] + 1;
	}
	if ($sxsx5 == '猪')
	{
		$sss['猪'] = $sss['猪'] + 1;
	}
	if ($sxsx6 == '鼠')
	{
		$sss['鼠'] = $sss['鼠'] + 1;
	}
	if ($sxsx6 == '虎')
	{
		$sss['虎'] = $sss['虎'] + 1;
	}
	if ($sxsx6 == '龙')
	{
		$sss['龙'] = $sss['龙'] + 1;
	}
	if ($sxsx6 == '马')
	{
		$sss['马'] = $sss['马'] + 1;
	}
	if ($sxsx6 == '猴')
	{
		$sss['猴'] = $sss['猴'] + 1;
	}
	if ($sxsx6 == '狗')
	{
		$sss['狗'] = $sss['狗'] + 1;
	}
	if ($sxsx6 == '牛')
	{
		$sss['牛'] = $sss['牛'] + 1;
	}
	if ($sxsx6 == '兔')
	{
		$sss['兔'] = $sss['兔'] + 1;
	}
	if ($sxsx6 == '蛇')
	{
		$sss['蛇'] = $sss['蛇'] + 1;
	}
	if ($sxsx6 == '羊')
	{
		$sss['羊'] = $sss['羊'] + 1;
	}
	if ($sxsx6 == '鸡')
	{
		$sss['鸡'] = $sss['鸡'] + 1;
	}
	if ($sxsx6 == '猪')
	{
		$sss['猪'] = $sss['猪'] + 1;
	}
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set rate2=rate where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and bm=0 ');
	$stmt->execute($params);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and bm<>0 ');
	$stmt->execute($params);
	if (0 < $sss['鼠'])
	{
		$params = array(':rate' => $sss['鼠'], ':rate2' => $sss['鼠'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'鼠\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['虎'])
	{
		$params = array(':rate' => $sss['虎'], ':rate2' => $sss['虎'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'虎\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['龙'])
	{
		$params = array(':rate' => $sss['龙'], ':rate2' => $sss['龙'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'龙\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['马'])
	{
		$params = array(':rate' => $sss['马'], ':rate2' => $sss['马'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'马\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['猴'])
	{
		$params = array(':rate' => $sss['猴'], ':rate2' => $sss['猴'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'猴\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['狗'])
	{
		$params = array(':rate' => $sss['狗'], ':rate2' => $sss['狗'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'狗\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['牛'])
	{
		$params = array(':rate' => $sss['牛'], ':rate2' => $sss['牛'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'牛\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['兔'])
	{
		$params = array(':rate' => $sss['兔'], ':rate2' => $sss['兔'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'兔\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['蛇'])
	{
		$params = array(':rate' => $sss['蛇'], ':rate2' => $sss['蛇'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'蛇\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['羊'])
	{
		$params = array(':rate' => $sss['羊'], ':rate2' => $sss['羊'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'羊\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['鸡'])
	{
		$params = array(':rate' => $sss['鸡'], ':rate2' => $sss['鸡'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'鸡\' ');
		$stmt->execute($params);
	}
	if (0 < $sss['猪'])
	{
		$params = array(':rate' => $sss['猪'], ':rate2' => $sss['猪'], ':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1,rate=rate2*:rate-(:rate2-1) where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'猪\' ');
		$stmt->execute($params);
	}
 echo $sss['牛'] ;?><br><?php if (($sss['牛'] == 1) && (($n1 == '49') || ($n2 == '49') || ($n3 == '49') || ($n4 == '49') || ($n5 == '49') || ($n6 == '49')))
	{
		$params = array(':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and class3=\'牛\'');
		$stmt->execute($params);
	}
	$www = '';
	if (0 < $sss['鼠'])
	{
		$www .= ' or class3=\'鼠\' ';
	}
	if (0 < $sss['虎'])
	{
		$www .= ' or class3=\'虎\' ';
	}
	if (0 < $sss['龙'])
	{
		$www .= ' or class3=\'龙\' ';
	}
	if (0 < $sss['马'])
	{
		$www .= ' or class3=\'马\' ';
	}
	if (0 < $sss['猴'])
	{
		$www .= ' or class3=\'猴\' ';
	}
	if (0 < $sss['狗'])
	{
		$www .= ' or class3=\'狗\' ';
	}
	if (0 < $sss['牛'])
	{
		$www .= ' or class3=\'牛\' ';
	}
	if (0 < $sss['兔'])
	{
		$www .= ' or class3=\'兔\' ';
	}
	if (0 < $sss['蛇'])
	{
		$www .= ' or class3=\'蛇\' ';
	}
	if (0 < $sss['羊'])
	{
		$www .= ' or class3=\'羊\' ';
	}
	if (0 < $sss['鸡'])
	{
		$www .= ' or class3=\'鸡\' ';
	}
	if (0 < $sss['猪'])
	{
		$www .= ' or class3=\'猪\' ';
	}
	$params = array(':kithe' => $kithe);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正肖\' and class2=\'正肖\' and (1=1 ' . $www . ')');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 正肖结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$wsws0 = floor($na / 10);
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'头数\' and class2=\'头数\' and bm<>0 ');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $wsws0);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'头数\' and class2=\'头数\' and class3=:class3');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $wsws0);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'头数\' and class2=\'头数\' and class3=:class3');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 特码头数结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$wsws0 = $na % 10;
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'尾数\' and class2=\'尾数\' and bm<>0 ');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $wsws0);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'尾数\' and class2=\'尾数\' and class3=:class3');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $wsws0);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'尾数\' and class2=\'尾数\' and class3=:class3');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 特码尾数结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$wsws0 = $na % 10;
	$wsws1 = $n1 % 10;
	$wsws2 = $n2 % 10;
	$wsws3 = $n3 % 10;
	$wsws4 = $n4 % 10;
	$wsws5 = $n5 % 10;
	$wsws6 = $n6 % 10;
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'正特尾数\' and class2=\'正特尾数\' and bm<>0 ');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':wsws0' => $wsws0, ':wsws1' => $wsws1, ':wsws2' => $wsws2, ':wsws3' => $wsws3, ':wsws4' => $wsws4, ':wsws5' => $wsws5, ':wsws6' => $wsws6);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'正特尾数\' and class2=\'正特尾数\' and (class3=:wsws0 or class3=:wsws1 or class3=:wsws2 or class3=:wsws3 or class3=:wsws4 or class3=:wsws5 or class3=:wsws6  )');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':wsws0' => $wsws0, ':wsws1' => $wsws1, ':wsws2' => $wsws2, ':wsws3' => $wsws3, ':wsws4' => $wsws4, ':wsws5' => $wsws5, ':wsws6' => $wsws6);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'正特尾数\' and class2=\'正特尾数\' and (class3=:wsws0 or class3=:wsws1 or class3=:wsws2 or class3=:wsws3 or class3=:wsws4 or class3=:wsws5 or class3=:wsws6) ');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 正特尾数结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$wsws0 = ka_Color_s($na);
	$wsws1 = ka_Color_s($n1);
	$wsws2 = ka_Color_s($n2);
	$wsws3 = ka_Color_s($n3);
	$wsws4 = ka_Color_s($n4);
	$wsws5 = ka_Color_s($n5);
	$wsws6 = ka_Color_s($n6);
	$hongbo_na = 0;
	$lvbo_na = 0;
	$lanbo_na = 0;
	$hongbo = 0;
	$lvbo = 0;
	$lanbo = 0;
	$hongbo_z = 0;
	$lvbo_z = 0;
	$lanbo_z = 0;
	if ($wsws0 == '红波')
	{
		$hongbo_na = $hongbo_na + 1.5;
	}
	else if ($wsws0 == '绿波')
	{
		$lvbo_na = $lvbo_na + 1.5;
	}
	else if ($wsws0 == '蓝波')
	{
		$lanbo_na = $lanbo_na + 1.5;
	}
	if ($wsws1 == '红波')
	{
		$hongbo = $hongbo + 1;
	}
	else if ($wsws1 == '绿波')
	{
		$lvbo = $lvbo + 1;
	}
	else if ($wsws1 == '蓝波')
	{
		$lanbo = $lanbo + 1;
	}
	if ($wsws2 == '红波')
	{
		$hongbo = $hongbo + 1;
	}
	else if ($wsws2 == '绿波')
	{
		$lvbo = $lvbo + 1;
	}
	else if ($wsws2 == '蓝波')
	{
		$lanbo = $lanbo + 1;
	}
	if ($wsws3 == '红波')
	{
		$hongbo = $hongbo + 1;
	}
	else if ($wsws3 == '绿波')
	{
		$lvbo = $lvbo + 1;
	}
	else if ($wsws3 == '蓝波')
	{
		$lanbo = $lanbo + 1;
	}
	if ($wsws4 == '红波')
	{
		$hongbo = $hongbo + 1;
	}
	else if ($wsws4 == '绿波')
	{
		$lvbo = $lvbo + 1;
	}
	else if ($wsws4 == '蓝波')
	{
		$lanbo = $lanbo + 1;
	}
	if ($wsws5 == '红波')
	{
		$hongbo = $hongbo + 1;
	}
	else if ($wsws5 == '绿波')
	{
		$lvbo = $lvbo + 1;
	}
	else if ($wsws5 == '蓝波')
	{
		$lanbo = $lanbo + 1;
	}
	if ($wsws6 == '红波')
	{
		$hongbo = $hongbo + 1;
	}
	else if ($wsws6 == '绿波')
	{
		$lvbo = $lvbo + 1;
	}
	else if ($wsws6 == '蓝波')
	{
		$lanbo = $lanbo + 1;
	}
	$hongbo_z = $hongbo_na + $hongbo;
	$lvbo_z = $lvbo_na + $lvbo;
	$lanbo_z = $lanbo_na + $lanbo;
	if (($lvbo_z < $hongbo_z) && ($lanbo_z < $hongbo_z))
	{
		$qsbgo = '红波';
	}
	if (($hongbo_z < $lvbo_z) && ($lanbo_z < $lvbo_z))
	{
		$qsbgo = '绿波';
	}
	if (($hongbo_z < $lanbo_z) && ($lvbo_z < $lanbo_z))
	{
		$qsbgo = '蓝波';
	}
	if (($hongbo_z == 3) && ($lvbo_z == 3) && ($wsws0 == '蓝波'))
	{
		$qsbgo = '合局';
	}
	if (($lvbo_z == 3) && ($lanbo_z == 3) && ($wsws0 == '红波'))
	{
		$qsbgo = '合局';
	}
	if (($hongbo_z == 3) && ($lanbo_z == 3) && ($wsws0 == '绿波'))
	{
		$qsbgo = '合局';
	}
	if ($qsbgo == '合局')
	{
		$params = array(':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'七色波\' and class2=\'七色波\' and bm<>0 ');
		$stmt->execute($params);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=2 where kithe=:kithe and class1=\'七色波\' and class2=\'七色波\' and class3<>\'合局\'');
		$stmt->execute($params);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'七色波\' and class2=\'七色波\' and class3=\'合局\'');
		$stmt->execute($params);
		$result1dd = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'七色波\' and class2=\'七色波\' and class3=\'合局\'');
		$result1dd->execute($params);
		$Rs5 = @($result1dd->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	else
	{
		$params = array(':kithe' => $kithe);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'七色波\' and class2=\'七色波\' and bm<>0 ');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $qsbgo);
		$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'七色波\' and class2=\'七色波\' and class3=:class3 ');
		$stmt->execute($params);
		$params = array(':kithe' => $kithe, ':class3' => $qsbgo);
		$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'七色波\' and class2=\'七色波\' and class3 =:class3 ');
		$result1->execute($params);
		$Rs5 = @($result1->fetch());
		if ($Rs5 != '')
		{
			$zwin = $Rs5['re'];
		}
		else
		{
			$zwin = 0;
		}
	}
	if ($zwin != 0)
	{?> 七色波结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if ($na < 10)
	{
		$wxwx = '0' . $na;
	}
	else
	{
		$wxwx = $na;
	}
	$wxwxwx = get_wxwx_color($wxwx);
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'五行\' and class2=\'五行\' and bm<>0 ');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $wxwxwx);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'五行\' and class2=\'五行\' and class3=:class3 ');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe, ':class3' => $wxwxwx);
	$result1 = $mydata2_db->prepare('Select sum(sum_m) as sum_m,count(*) as re from ka_tan where kithe=:kithe and class1=\'五行\' and class2=\'五行\' and class3=:class3');
	$result1->execute($params);
	$Rs5 = @($result1->fetch());
	if ($Rs5 != '')
	{
		$zwin = $Rs5['re'];
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 五行结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where kithe=:kithe and class1=\'全不中\'');
	$stmt->execute($params);
	$result1kk = $mydata2_db->prepare('select class3,id from ka_tan where kithe=:kithe and class1=\'全不中\'');
	$result1kk->execute($params);
	explode(',', $class3);
	$zhengshu = array();
	$i = 1;
	for (;$i <= 49;$i++)
	{
		array_push($zhengshu, '#' . $i . '');
	}
	while ($image = $result1kk->fetch())
	{
		$class3 = $image[0];
		$tanid = $image[1];
		$numberxz = explode(',', $class3);
		$ss1 = count($numberxz);
		$i = 0;
		for (;$i < $ss1;$i++)
		{
			if (('#' . $numberxz[$i] == '#' . $na) || ('#' . $numberxz[$i] == '#' . $n1) || ('#' . $numberxz[$i] == '#' . $n2) || ('#' . $numberxz[$i] == '#' . $n3) || ('#' . $numberxz[$i] == '#' . $n4) || ('#' . $numberxz[$i] == '#' . $n5) || ('#' . $numberxz[$i] == '#' . $n6) || !in_array('#' . $numberxz[$i], $zhengshu))
			{
				$params = array(':id' => $tanid);
				$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where id=:id');
				$stmt->execute($params);
			}
		}
	}
	$params = array(':kithe' => $kithe);
	$zxbz = $mydata2_db->prepare('select * from ka_tan where kithe=:kithe and class1=\'全不中\' and bm=1');
	$zxbz->execute($params);
	$re = @($zxbz->rowCount());
	if ($Rs5 != '')
	{
		$zwin = $re;
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 全不中结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	if (intval($n1) < 10)
	{
		$n1 = '0' . $n1;
	}
	if (intval($n2) < 10)
	{
		$n2 = '0' . $n2;
	}
	if (intval($n3) < 10)
	{
		$n3 = '0' . $n3;
	}
	if (intval($n4) < 10)
	{
		$n4 = '0' . $n4;
	}
	if (intval($n5) < 10)
	{
		$n5 = '0' . $n5;
	}
	if (intval($n6) < 10)
	{
		$n6 = '0' . $n6;
	}
	if (intval($na) < 10)
	{
		$na = '0' . $na;
	}
	$lx_sx1 = Get_sx_Color($n1);
	$lx_sx2 = Get_sx_Color($n2);
	$lx_sx3 = Get_sx_Color($n3);
	$lx_sx4 = Get_sx_Color($n4);
	$lx_sx5 = Get_sx_Color($n5);
	$lx_sx6 = Get_sx_Color($n6);
	$lx_sx7 = Get_sx_Color($na);
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'生肖连\'');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe);
	$result = $mydata2_db->prepare('Select id,class2,class3  from ka_tan where kithe=:kithe and class1=\'生肖连\'');
	$result->execute($params);
	while ($image = $result->fetch())
	{
		$Rs_id = $image['id'];
		$class2 = $image['class2'];
		$class3 = $image['class3'];
		$numberxz = explode(',', $class3);
		$cont = 0;
		$ss1 = count($numberxz);
		$i = 0;
		for (;$i < $ss1;$i++)
		{
			if (($lx_sx1 == $numberxz[$i]) || ($lx_sx2 == $numberxz[$i]) || ($lx_sx3 == $numberxz[$i]) || ($lx_sx4 == $numberxz[$i]) || ($lx_sx5 == $numberxz[$i]) || ($lx_sx6 == $numberxz[$i]) || ($lx_sx7 == $numberxz[$i]))
			{
				$cont += 1;
				continue;
				goto label5263;
			}
			label5263: }
		if (($cont == $ss1) && (($class2 == '二肖连中') || ($class2 == '三肖连中') || ($class2 == '四肖连中') || ($class2 == '五肖连中')))
		{
			$params = array(':id' => $Rs_id);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where id=:id');
			$stmt->execute($params);
		}
		if (($cont == 0) && (($class2 == '二肖连不中') || ($class2 == '三肖连不中') || ($class2 == '四肖连不中')))
		{
			$params = array(':id' => $Rs_id);
			$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where id=:id');
			$stmt->execute($params);
		}
	}
	$params = array(':kithe' => $kithe);
	$lxbz = $mydata2_db->prepare('select * from ka_tan where kithe=:kithe and class1=\'生肖连\' and bm=1');
	$lxbz->execute($params);
	$re = @($lxbz->rowCount());
	if ($Rs5 != '')
	{
		$zwin = $re;
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 生肖连结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
	$params = array(':kithe' => $kithe);
	$stmt = $mydata2_db->prepare('update ka_tan set bm=0 where kithe=:kithe and class1=\'尾数连\'');
	$stmt->execute($params);
	$params = array(':kithe' => $kithe);
	$result = $mydata2_db->prepare('Select id,class2,class3  from ka_tan where kithe=:kithe and class1=\'尾数连\'');
	$result->execute($params);
	while ($image = $result->fetch())
	{
		$Rs_id = $image['id'];
		$class2 = $image['class2'];
		$class3 = $image['class3'];
		$numberxz = explode(',', $class3);
		$cont = 0;
		$ss1 = count($numberxz);
		$is_feifa = 0;
		$i = 0;
		for (;$i < $ss1;$i++)
		{
			if (('#' . substr($n1, -1) == '#' . $numberxz[$i]) || ('#' . substr($n2, -1) == '#' . $numberxz[$i]) || ('#' . substr($n3, -1) == '#' . $numberxz[$i]) || ('#' . substr($n4, -1) == '#' . $numberxz[$i]) || ('#' . substr($n5, -1) == '#' . $numberxz[$i]) || ('#' . substr($n6, -1) == '#' . $numberxz[$i]) || ('#' . substr($na, -1) == '#' . $numberxz[$i]))
			{
				$cont += 1;
				continue;
				goto label5453;
			}
			label5453: $arrd = array('#0', '#1', '#2', '#3', '#4', '#5', '#6', '#7', '#8', '#9');
			if (!in_array('#' . $numberxz[$i], $arrd))
			{
				$is_feifa = 1;
				break;
			}
		}
		if ($is_feifa == 0)
		{
			if (($cont == $ss1) && (($class2 == '二尾连中') || ($class2 == '三尾连中') || ($class2 == '四尾连中')))
			{
				$params = array(':id' => $Rs_id);
				$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where id=:id');
				$stmt->execute($params);
			}
			if (($cont == 0) && (($class2 == '二尾连不中') || ($class2 == '三尾连不中') || ($class2 == '四尾连不中')))
			{
				$params = array(':id' => $Rs_id);
				$stmt = $mydata2_db->prepare('update ka_tan set bm=1 where id=:id');
				$stmt->execute($params);
			}
		}
	}
	$params = array(':kithe' => $kithe);
	$lxbz = $mydata2_db->prepare('select * from ka_tan where kithe=:kithe and class1=\'尾数连\' and bm=1');
	$lxbz->execute($params);
	$re = @($lxbz->rowCount());
	if ($Rs5 != '')
	{
		$zwin = $re;
	}
	else
	{
		$zwin = 0;
	}
	if ($zwin != 0)
	{?> 尾数连结算成功：<font color=ff6600><?=$zwin ;?>注</font><br><?php }
}?> <font color=ff0000>第<?=$kithe ;?>期结算成功</font><?php $params = array(':kithe' => $_GET['kithe']);
$stmt = $mydata2_db->prepare('select count(*) from ka_tan where checked=1 and kithe=:kithe');
$stmt->execute($params);
$recordNum = $stmt->fetchColumn();
if (0 < $recordNum)
{?> <script type='text/javascript'>alert('不能结算,请相关管理人员！');history.back();</script><?php exit();
}
$stmt = $mydata1_db->prepare('delete from mydata1_db.ka_jiesuan_temp');
$stmt->execute();
$params = array(':kithe' => $_GET['kithe']);
$sql = 'insert into mydata1_db.ka_jiesuan_temp' . "\r\n" . '    select username,kithe,' . "\r\n" . '    round(sum(if(bm=1,sum_m*rate,if(bm=2,sum_m,0))),2) as paicai,' . "\r\n" . '    round(sum(if(bm=2,0,sum_m*abs(user_ds)/100)),2) as tuishui,' . "\r\n" . '    0' . "\r\n" . '    from mydata2_db.ka_tan ' . "\r\n" . '    where kithe=:kithe' . "\r\n" . '    and checked=0' . "\r\n" . '    group by username';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$params = array(':kithe' => $_GET['kithe']);
$stmt = $mydata2_db->prepare('update ka_tan set checked=1 where kithe=:kithe');
$stmt->execute($params);
$sql = 'update mydata1_db.k_user k,mydata1_db.ka_jiesuan_temp t' . "\r\n" . '        set t.checked=1,k.money = k.money+t.paicai+t.tuishui,t.checked=2' . "\r\n" . '        where k.username = t.username';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute();
$creationTime = date('Y-m-d H:i:s', time() - (12 * 3600));
$params = array(':kithe' => $_GET['kithe'], ':creationTime' => $creationTime);
$sql = 'INSERT INTO mydata1_db.k_money_log (uid,userName,gameType,transferType,transferOrder,transferAmount,previousAmount,currentAmount,creationTime)  SELECT k.uid,k.username,\'SIX\',\'RECKON\',concat(k.username,\'_\',t.kithe),t.paicai+t.tuishui,money-(t.paicai+t.tuishui),money,:creationTime FROM mydata1_db.ka_jiesuan_temp t ' . "\r\n" . '            left join mydata1_db.k_user k on t.username = k.username where k.username is not null' . "\r\n" . '        and t.kithe=:kithe';
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$params = array(':kithe' => $_GET['kithe']);
$stmt = $mydata2_db->prepare('update ka_kithe set score=1 where nn=:kithe');
$stmt->execute($params);
unset($_SESSION['reCount' . $store_kithe]);?></td> 
          </tr> 
        </table></td> 
      </tr> 
    </table> 
  </div><?php function Get_wxwx_Color($rrr)
{
	global $mydata2_db;
	$params = array(':m_number' => '%' . $rrr . '%');
	$result23 = $mydata2_db->prepare('Select id,m_number,sx From ka_sxnumber where  m_number LIKE :m_number  and id<=29 and id>=25  Order By id LIMIT 1');
	$result23->execute($params);
	$ka_Color231 = $result23->fetch();
	return $ka_Color231['sx'];
}?>