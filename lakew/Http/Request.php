<?php

namespace Lakew\Http;

use support\Request as WebmanRequest;

/**
 * Request
 *
 * @create 2022-11-14
 * @author deatil
 */
class Request
{
    /**
     * 获取 query 数组
     *
     * @return mixed
     */
    public static function getQueryParams(WebmanRequest $request)
    {
        $queryParams = [];
        parse_str($request->queryString(), $queryParams);
        
        return (array)$queryParams;
    }
}