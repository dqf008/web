<?php

namespace app\common\model;

use think\Model;

class Db1_daily_report extends Model
{
    protected $table = 'mydata1_db.daily_report'; // 数据库名

    protected $pk = 'id'; // 主键

    public static function setBetAmountAttr($value)
    {
        return $value * 100;
    }

    public static function getBetAmountAttr($value)
    {
        return $value / 100;
    }

    public static function setNetAmountAttr($value)
    {
        return $value * 100;
    }

    public static function getNetAmountAttr($value)
    {
        return $value / 100;
    }

    public static function setValidAmountAttr($value)
    {
        return $value * 100;
    }

    public static function getValidAmountAttr($value)
    {
        return $value / 100;
    }
}
