<?php

namespace app\model;

use support\Cache;

use Lakew\BaseModel;

class Url extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'url';

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
    
    /**
     * 缓存数据获取
     */
    public static function getDataCache($id)
    {
        if (empty($id)) {
            return [];
        }
        
        $key = 'short-url-' . $id;
        
        $data = Cache::get($key);
        if (!$data) {
            $data = static::where('url_id', $id)
                ->where('status', 1)
                ->first();
            
            if (empty($data)) {
                return [];
            }
            
            // 设置缓存
            Cache::set($key, $data, 432000);
        }
        
        return $data;
    }
    
    /**
     * 删除缓存数据
     */
    public static function deleteDataCache($id)
    {
        if (empty($id)) {
            return false;
        }
        
        $key = 'short-url-' . $id;

        return Cache::delete($key);
    }

}