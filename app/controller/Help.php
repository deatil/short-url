<?php

namespace app\controller;

use Webman\Captcha\CaptchaBuilder;

use support\Request;

use app\model\User as UserModel;

/**
 * 帮助文档
 *
 * @create 2022-11-8
 * @author deatil
 */
class Help
{
    /*
     * 首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('help/index', []);
    }
}
