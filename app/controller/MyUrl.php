<?php

namespace app\controller;

use Webman\Captcha\CaptchaBuilder;

use support\Request;

use Lakew\Uuid;
use Lakew\ShortUrl;
use Lakew\Http\Request as HttpRequest;
use Lakew\Page\Bootstrap as BootstrapPage;
use Lakew\Validate\Check as ValidateCheck;

use app\model\Url as UrlModel;

/**
 * 我的短链接
 *
 * @create 2022-11-8
 * @author deatil
 */
class MyUrl extends Base
{
    /*
     * 我的首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userId = $request->session()->get('user_id');
        
        $type = $request->get("type", "");
        $keyword = $request->get("keyword", "");
        $page = $request->get("page", "1");
        
        $limit = 10;
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
            ->toArray();

        // 分页页面
        $pageHtml = BootstrapPage::make($limit, (int) $page, $total, false, [
            'path' => $request->path(),
            'query' => HttpRequest::getQueryParams($request),
        ]);
        
        return view('my_url/index', [
            'type' => $type,
            'keyword' => $keyword,
            'page' => $page,
            
            'total' => $total,
            'list' => $list,
            'pageHtml' => $pageHtml,
        ]);
    }
    
    /*
     * 创建
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        return view('my_url/create', []);
    }
    
    /*
     * 创建保存
     *
     * @param Request $request
     * @return Response
     */
    public function createSave(Request $request)
    {
        $userId = $request->session()->get('user_id');
        
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

        return $this->json(0, '短链接创建成功');
    }
    
    /*
     * 删除
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $userId = $request->session()->get('user_id');
        
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
