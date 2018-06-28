<?php

namespace app\common\model;

use think\Model;

class Db1_hunterbetdetail extends Model
{
    protected $table = 'mydata1_db.hunterbetdetail'; // 数据库名

    protected $pk = 'id'; // 主键

    protected $type = [
        'Cost' => 'float',
        'Earn' => 'float',
        'transferAmount' => 'float',
    ];
}
