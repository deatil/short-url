<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

use Lakew\Auth;

use app\model\User as UserModel;

/**
 * 设置登录信息
 *
 * @create 2022-10-30
 * @author deatil
 */
class SetLoginInfo implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        $session = $request->session();
        
        // 用户未登录
        if (! $session->get('user_id')) {
            $loginData = $request->cookie('keep-login', '');
            if (! empty($loginData)) {
                $deData = Auth::make()->decrypt($loginData);
                if (! empty($deData)) {
                    $session->set('user_id', $deData);
                }
            }
        }
        
        $userId = $session->get('user_id');
        if (! empty($userId)) {
            $userInfo = $session->get('user');
            if (empty($userInfo)) {
                $user = UserModel::where('id', $userId)->first();

                // 保存登录信息
                $session->set('user', $user->toArray());
            }
        }
        
        return $next($request);
    }
}
