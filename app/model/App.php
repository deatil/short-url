<?php

namespace app\model;

use Lakew\BaseModel;

class App extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    // 是否使用添加默认时间字段数据
    public $incrementing = false;
    
    /**
     * 所属用户
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
}