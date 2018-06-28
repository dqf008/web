<?php

namespace app\common\model;

use think\Model;

class Db1_huikuan extends Model
{
    protected $table = 'mydata1_db.huikuan'; // 数据库名

    protected $pk = 'id'; // 主键

    protected $type = [
        'money' => 'float',
        'zsjr' => 'float',
    ];

    public static function setStatusAttr($value)
    {
        return $value == 2 ? 0 : ($value == 0 ? 2 : $value);
    }

    public static function getStatusAttr($value)
    {
        return $value == 2 ? 0 : ($value == 0 ? 2 : $value);
    }
}
