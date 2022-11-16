<?php

namespace Lakew;

use Ramsey\Uuid\Uuid as RamseyUuid;

/**
 * Uuid
 *
 * @create 2022-7-16
 * @author deatil
 */
class Uuid
{
    /**
     * 生成 uuid 字符
     *
     * @return string
     */
    public static function make(): string
    {
        $uuid = RamseyUuid::uuid4();
        
        return $uuid->toString();
    }
}