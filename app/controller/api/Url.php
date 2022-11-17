<?php

namespace app\controller\api;

use Webman\Event\Event;

use support\Request;

use Lakew\Uuid;
use Lakew\ShortUrl;
use Lakew\Validate\Check as ValidateCheck;

use app\model\Url as UrlModel;
use app\controller\Base as BaseController;

/**
 * Url
 *
 * @create 2022-11-16
 * @author deatil
 */
class Url extends BaseController
{
    /*
     * 列表
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userId = $request->appData['user_id'] ?? '';
        if (empty($userId)) {
            return $this->json(1, 'app_id 错误');
        }
        
        $type = $request->post("type", "");
        $keyword = $request->post("keyword", "");
        $page = $request->post("page", "1");
        
        $limit = $request->post("limit", "10");
        $limit = max($limit, 1);
        
        $start = max(((int) $page - 1) * $limit, 0);
        
        $query = UrlModel::where('status', 1)
            ->where('user_id', $userId)
            ->where(function($query) use($keyword) {
                $query->orWhere('url', 'like', '%'.$keyword.'%')
                    ->orWhere('url_id', 'like', '%'.$keyword.'%');
            });
            
        if (! empty($type)) {
            $query->where('type', $type);
        }
        
        $total = $query->count(); 
        $list = $query
            ->offset($start)
            ->limit($limit)
            ->orderBy('add_time', 'DESC')
            ->get()
            ->map(function($data) {
                return [
                    'id' => $data['id'],
                    'url' => $data['url'],
                    'short_url' => share_url($data['url_id']),
                    'type' => $data['type'],
                    'add_time' => $data['add_time'],
                ];
            })
            ->toArray();
        
        return $this->json(0, '获取成功', [
            'total' => $total,
            'list' => $list,
        ]);
    }
    
    /**
     * 生成短链接
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $userId = $request->appData['user_id'] ?? '';
        if (empty($userId)) {
            return $this->json(1, 'app_id 错误');
        }
        
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
    
    /*
     * 删除
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $userId = $request->appData['user_id'] ?? '';
        if (empty($userId)) {
            return $this->json(1, 'app_id 错误');
        }
        
        $id = $request->post("id", "");
        if (empty($id)) {
            return $this->json(1, 'id 不能为空');
        }
        
        $data = UrlModel::where('id', $id)
            ->where('user_id', $userId)
            ->where('status', 1)
            ->first();
        if (empty($data)) {
            return $this->json(1, '数据不存在');
        }

        $status = UrlModel::where('id', $id)
            ->where('user_id', $userId)
            ->where('status', 1)
            ->delete();
        if ($status === false) {
            return $this->json(1, '删除短链接失败');
        }
        
        UrlModel::deleteDataCache($data['url_id']);
        
        return $this->json(0, '删除短链接成功');
    }

}
