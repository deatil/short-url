<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

/**
 * 检测网站开启状态
 *
 * @create 2022-11-17
 * @author deatil
 */
class CheckWebsiteOpen implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        // 管理员
        if (is_admin()) {
            return $next($request);
        }
    
        if (setting('website_status') != 1) {
            if ($request->expectsJson()) {
                return json([
                    'code' => 1, 
                    'msg' => '网站关闭维护中...', 
                    'data' => '', 
                ]);
            }
            
            return msg('网站关闭维护中...');
        }
        
        return $next($request);
    }
}
