<?php

namespace Lakew;

use support\Db;

class DB
{
    public static function connection()
    {
        return Db::connection('shorturl.mysql');
    }

    public static function schema()
    {
        return Db::schema('shorturl.mysql');
    }
}