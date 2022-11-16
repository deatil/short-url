<?php

namespace app\controller;

use Webman\Event\Event;

use support\Cache;
use support\Request;

use Lakew\Sign;
use Lakew\Uuid;
use Lakew\ShortUrl;
use Lakew\Validate\Check as ValidateCheck;

use app\model\App as AppModel;
use app\model\Url as UrlModel;

/**
 * Api
 *
 * @create 2022-11-16
 * @author deatil
 */
class Api extends Base
{
    /**
     * 生成短链接
     *
     * @param Request $request
     * @return Response
     */
    public function createUrl(Request $request)
    {
        $nonceStr = $request->post('nonce_str', '');
        if (empty($nonceStr)) {
            return $this->json(1, 'nonce_str错误');
        }
        if (strlen($nonceStr) != 16) {
            return $this->json(1, 'nonce_str格式错误');
        }

        $timestamp = $request->post('timestamp', '');
        if (empty($timestamp)) {
            return $this->json(1, '时间戳错误');
        }
        if (strlen($timestamp) != 10) {
            return $this->json(1, '时间戳格式错误');
        }
        if (time() - ((int) $timestamp) > 1800) {
            return $this->json(1, '时间错误，请确认你的时间为正确的北京时间');
        }
        
        // 防止重放
        $cacheCheckId = md5($nonceStr.$timestamp);
        if (Cache::get($cacheCheckId)) {
            return $this->json(1, '重复提交');
        }
        
        Cache::set($cacheCheckId, time(), 1800);
        
        $appId = $request->post('app_id', '');
        if (empty($appId)) {
            return $this->json(1, 'app_id 不能为空');
        }

        $app = AppModel::where('app_id', $appId)
            ->where('is_apply', 2)
            ->where('status', 1)
            ->first();
        if (empty($appId)) {
            return $this->json(1, 'app_id 没有被授权');
        }

        // 生成的签名
        $post = $request->post();
        $makeSign = Sign::make()->makeSign($post, $app['app_secret']);

        $sign = $request->post('sign', '');
        if ($sign != $makeSign) {
            return $this->json(1, '签名验证失败');
        }
        
        $userId = $app['user_id'];
        
        $content = $request->post('content', '');
        $type = $request->post('type', '');
        
        $checked = ValidateCheck::data([
            'content' => $content,
            'type' => $type,
        ], [
            'content' => 'require|url',
            'type' => 'require|in:1,2',
        ], [
            'content.require' => '链接地址不能为空',
            'content.url' => '链接地址不正确',
            'type.require' => '链接类型不能为空',
            'type.in' => '链接类型不正确',
        ]);
        if ($checked !== true) {
            return $this->json(1, $checked);
        }
        
        // 生成 url 的 id
        $timeUuid = ShortUrl::getDateTimeMillisecond();
        $urlId = ShortUrl::make($timeUuid);
        
        // parse_url($url) = ["scheme", "host", "port", 
        //    "user", "pass", "path", "query", "fragment"]
        $urlData = parse_url($content);
        
        $id = Uuid::make();

        $newUrl = UrlModel::create([
            'id' => $id,
            'url' => $content,
            'url_id' => $urlId,
            'user_id' => $userId,
            'scheme' => $urlData['scheme'] ?? '',
            'host' => $urlData['host'] ?? '',
            'port' => $urlData['port'] ?? 80,
            'type' => $type,
            'status' => 1,
            'add_time' => time(),
            'add_ip' => $request->getRealIp(true),
        ]);
        if ($newUrl === false) {
            return $this->json(1, '短链接创建失败');
        }
        
        return $this->json(0, '短链接创建成功', [
            'url' => share_url($urlId),
        ]);
    }
}
