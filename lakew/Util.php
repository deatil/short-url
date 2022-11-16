<?php

namespace Lakew;

use Throwable;
use support\exception\BusinessException;

class Util
{
    public static function passwordHash($password, $algo = PASSWORD_DEFAULT)
    {
        return password_hash($password, $algo);
    }
    
    public static function passwordVerify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function checkTableName($table)
    {
        if (!preg_match('/^[a-zA-Z_0-9]+$/', $table)) {
            throw new BusinessException('表名不合法');
        }
        
        return true;
    }

    public static function camel($value)
    {
        static $cache = [];
        $key = $value;

        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return $cache[$key] = str_replace(' ', '', $value);
    }

    public static function smCamel($value)
    {
        return lcfirst(static::camel($value));
    }

    public static function getCommentFirstLine($comment)
    {
        if ($comment === false) {
            return false;
        }
        
        foreach (explode("\n", $comment) as $str) {
            if ($s = trim($str, "*/\ \t\n\r\0\x0B")) {
                return $s;
            }
        }
        
        return $comment;
    }

    /**
     * reload webman
     *
     * @return bool
     */
    public static function reloadWebman()
    {
        if (function_exists('posix_kill')) {
            try {
                posix_kill(posix_getppid(), SIGUSR1);
                
                return true;
            } catch (Throwable $e) {}
        }
        
        return false;
    }

}