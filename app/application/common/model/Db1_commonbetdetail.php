<?php

namespace app\common\model;

use think\Model;

class Db1_commonbetdetail extends Model
{
    protected $type = [
        'betAmount' => 'float',
        'validBetAmount' => 'float',
        'netAmount' => 'float',
    ];
}
