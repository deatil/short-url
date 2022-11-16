<?php

namespace Lakew;

use DateTimeInterface;
use support\Model;

class BaseModel extends Model
{
    /**
     * @var string
     */
    // protected $connection = 'shorturl';
    
    // 可以赋值的
    // protected $fillable = [];
    
    // 不可以赋值
    protected $guarded = [];
    
    /**
     * 隐藏
     *
     * @var array
     */
    protected $hidden = [];
    
    /**
     * 显示
     *
     * @var array
     */
    protected $visible = [];

    /**
     * 格式化日期
     *
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
