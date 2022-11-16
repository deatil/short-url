<?php

namespace app\controller;

use Webman\Event\Event;

use support\Request;

use app\model\Url as UrlModel;

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
    
    /**
     * 跳转
     *
     * @param Request $request
     * @return Response
     */
    public function redirect(Request $request, $id)
    {
        if (empty($id)) {
            return response('访问错误');
        }
        
        $urlData = UrlModel::getDataCache($id);
        if (empty($urlData)) {
            return response('访问错误');
        }
        
        $url = $urlData['url'];
        
        Event::emit('index.redirect', [
            'url' => $url,
        ]);
        
        
        return redirect($url);
    }
}
