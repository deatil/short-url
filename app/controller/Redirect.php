<?php

namespace app\controller;

use Webman\Event\Event;

use support\Request;

use app\model\Url as UrlModel;

/**
 * 跳转
 *
 * @create 2022-10-30
 * @author deatil
 */
class Redirect
{
    /**
     * 跳转
     *
     * @param Request $request
     * @return Response
     */
    public function url(Request $request, $id)
    {
        // 判断是否网站已关闭
        if (setting('website_status') != 1) {
            return response('网站关闭维护中...');
        }
        
        if (empty($id)) {
            return response('访问错误');
        }
        
        $urlData = UrlModel::getDataCache($id);
        if (empty($urlData)) {
            return response('访问错误');
        }
        
        // 限制时间
        $limitTime = config('url.limit_time');
        
        $type = $urlData['type'];
        $addTime = $urlData['add_time'];
        if ($type == 1 && ((time() - $addTime) > $limitTime)) {
            return response('链接已过期');
        }
        
        $url = $urlData['url'];
        
        Event::emit('index.redirect', [
            'url' => $url,
        ]);
        
        return redirect($url);
    }
}
