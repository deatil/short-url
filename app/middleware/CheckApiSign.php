<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

use support\Cache;

use Lakew\Sign;

use app\model\App as AppModel;

/**
 * 检测 API 签名
 *
 * @create 2022-11-17
 * @author deatil
 */
class CheckApiSign implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
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
        
        $appId = $request->post('app_id', '');
        if (empty($appId)) {
            return $this->json(1, 'app_id 不能为空');
        }

        // 防止重放
        $cacheCheckId = md5($appId . $nonceStr . $timestamp);
        if (Cache::get($cacheCheckId)) {
            return $this->json(1, '重复提交');
        }
        
        Cache::set($cacheCheckId, time(), 1800);
        
        $app = AppModel::where('app_id', $appId)
            ->where('is_apply', 2)
            ->where('status', 1)
            ->first();
        if (empty($app)) {
            return $this->json(1, 'app_id 没有被授权');
        }

        // 生成的签名
        $post = $request->post();
        $makeSign = Sign::make()->makeSign((array) $post, $app['app_secret']);

        $sign = $request->post('sign', '');
        if ($sign != $makeSign) {
            return $this->json(1, '签名验证失败');
        }
        
        // 设置上下文数据
        $request->appData = $app;
        
        return $next($request);
    }
    
    /**
     * 返回格式化json数据
     *
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return \support\Response
     */
    protected function json(int $code, string $msg = 'ok', array $data = [])
    {
        return response_json($code, $msg, $data);
    }
}
