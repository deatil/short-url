<?php

namespace Lakew;

/**
 * 短链接生成
 *
 * @create 2022-11-12
 * @author deatil
 */
class ShortUrl
{
    /**
     * 短链接生成
     */
    public static function make($value, $b = 62)
    {
        $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $r = $value % $b;
        $result = $base[$r];
        
        $q = floor($value / $b);
        while ($q)
        {
            $r = $q % $b;
            $q = floor($q / $b);
            $result = $base[$r] . $result;
        }
        
        return $result;
    }
    
    /*
     * 返回当前 Unix 时间戳和微秒数(用秒的小数表示)浮点数表示，
     * 常用来计算代码段执行时间
     */
    public static function microtimeFloat()
    {
        list($usec, $sec) = explode(" ", microtime());
        
        return ((float) $usec + (float) $sec);
    }
    
    /*
     * 获取时间
     */
    public static function getDateTimeMillisecond()
    {
        $millisecond = static::getMillisecond();
        $millisecond = str_pad($millisecond, 3, '0', STR_PAD_RIGHT);
        return date("YmdHis").$millisecond;
    }
    
    /*
     * microsecond 微秒
     * millisecond 毫秒
     * 返回时间戳的毫秒数部分
     */
    public static function getMillisecond()
    {
        list($usec, $sec) = explode(" ", microtime());
        $msec = round($usec*1000);

        return $msec;
    }
}