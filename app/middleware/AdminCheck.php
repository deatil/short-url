<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

/**
 * 管理员检测
 *
 * @create 2022-11-12
 * @author deatil
 */
class AdminCheck implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        // 不是管理员
        if (!is_admin()) {
            return msg('你不能访问该页面');
        }
        
        return $next($request);
    }
}
