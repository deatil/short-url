<?php

namespace app\controller;

use Webman\Captcha\CaptchaBuilder;

use support\Request;

use app\model\App as AppModel;
use app\model\User as UserModel;

/**
 * 我的
 *
 * @create 2022-11-8
 * @author deatil
 */
class My
{
    /*
     * 我的首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('my/index', []);
    }
    
    /*
     * 我的信息
     *
     * @param Request $request
     * @return Response
     */
    public function profile(Request $request)
    {
        $userInfo = $request->session()->get('user');

        $app = AppModel::where('user_id', $userInfo['id'])
            ->where('status', 1)
            ->first();
        
        return view('my/profile', [
            'app' => $app,
            'userInfo' => $userInfo,
        ]);
    }
}
