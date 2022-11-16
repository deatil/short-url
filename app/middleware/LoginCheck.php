<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

/**
 * 登录检测
 *
 * @create 2022-10-30
 * @author deatil
 */
class LoginCheck implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        $session = $request->session();
        $user = $session->get('user');
        
        // 用户未登录
        if (!$user || $user['status'] != 1) {
            $session->delete('user');
            $session->delete('user_id');
            
            return redirect(route('account.login'));
        }
        
        return $next($request);
    }
}
