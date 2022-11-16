<?php

namespace app\model;

use support\Cache;
use Lakew\BaseModel;

class Setting extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'setting';

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
    
    /**
     * 列表
     */
    public static function getListByKv() 
    {
        $data = static::where('status', 1)
            ->orderBy('key', 'ASC')
            ->get()
            ->toArray();
        
        $ret = [];
        if (! empty($data)) {
            foreach ($data as $value) {
                $ret[$value['key']] = $value['value'];
            }
        }
        
        return $ret;
    }
    
    /**
     * 更新
     */
    public static function updateByKv($data) 
    {
        if (! empty($data) && is_array($data)) {
            foreach ($data as $k => $v) {
                static::where('status', 1)
                    ->where('key', $k)
                    ->update([
                        'value' => $v,
                    ]);
            }
        }
        
        static::clearDataCache();
        
        return true;
    }
    
    /**
     * 列表
     */
    public static function getDataCache() 
    {
        $key = 'short-url-settings';
        
        $data = Cache::get($key);
        if (!$data) {
            $data = static::getListByKv();
            
            Cache::set($key, $data, 432000);
        }
        
        return $data;
    }
    
    /**
     * 删除缓存数据
     */
    public static function clearDataCache()
    {
        $key = 'short-url-settings';

        return Cache::delete($key);
    }

}