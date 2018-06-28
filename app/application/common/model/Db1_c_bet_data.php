<?php

namespace app\common\model;

use think\Model;

class Db1_c_bet_data extends Model
{
    protected $table = 'mydata1_db.c_bet_data'; // 数据库名

    protected $pk = 'id'; // 主键

    public static function setValueAttr($value)
    {
        return serialize($value);
    }

    public static function getValueAttr($value)
    {
        return unserialize($value);
    }

    public static function setWinAttr($value)
    {
        return $value * 100;
    }

    public static function getWinAttr($value)
    {
        return $value / 100;
    }

    public static function setMoneyAttr($value)
    {
        return $value * 100;
    }

    public static function getMoneyAttr($value)
    {
        return $value / 100;
    }
}
