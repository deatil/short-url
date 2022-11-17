<?php

namespace app\controller;

use support\Request;

/**
 * 首页
 *
 * @create 2022-10-30
 * @author deatil
 */
class Index
{
    /**
     * 首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $request->session()->get('user');
        
        return view('index/index', [
            'user' => $user,
        ]);
    }
}
