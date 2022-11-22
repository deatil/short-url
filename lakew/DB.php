<?php

namespace Lakew;

use support\Db;

class DB
{
    /**
     * 连接数据库
     */
    public static function connection($connection = '')
    {
        if (empty($connection)) {
            $connection = config('database.default');
        }
        
        return Db::connection($connection);
    }

    /**
     * 连接数据库
     */
    public static function schema($connection = '')
    {
        if (empty($connection)) {
            $connection = config('database.default');
        }
        
        return Db::schema($connection);
    }

    /**
     * 开启事务
     */
    public static function beginTransaction($connection = '')
    {
        return static::connection($connection)->beginTransaction();
    }

    /**
     * 回滚事务
     */
    public static function rollBack($connection = '')
    {
        return static::connection($connection)->rollBack();
    }

    /**
     * 提交事务
     */
    public static function commit($connection = '')
    {
        return static::connection($connection)->commit();
    }

    /**
     * 事务
     */
    public static function transaction(
        \Closure $callback, 
        $attempts = 1, 
        $connection = ''
    ) {
        return static::connection($connection)->transaction($callback, $attempts);
    }
}