<?php

namespace app\controller\sys;

use support\Request;

use Lakew\Http\Request as HttpRequest;
use Lakew\Page\Bootstrap as BootstrapPage;
use Lakew\Validate\Check as ValidateCheck;

use app\model\Url as UrlModel;
use app\controller\Base as BaseController;

/**
 * 链接列表
 *
 * @create 2022-11-8
 * @author deatil
 */
class Url extends BaseController
{
    /*
     * 首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $type = $request->get("type", "");
        $keyword = $request->get("keyword", "");
        $page = $request->get("page", "1");
        
        $limit = 10;
        $start = max(((int) $page - 1) * $limit, 0);
        
        $query = UrlModel::query()
            ->where(function($query) use($keyword) {
                $query->orWhere('url', 'like', '%'.$keyword.'%')
                    ->orWhere('url_id', 'like', '%'.$keyword.'%');
            });
            
        if (! empty($type)) {
            $query->where('type', $type);
        }
        
        $total = $query->count(); 
        $list = $query
            ->with('user')
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
        
        return view('sys/url/index', [
            'type' => $type,
            'keyword' => $keyword,
            'page' => $page,
            
            'total' => $total,
            'list' => $list,
            'pageHtml' => $pageHtml,
        ]);
    }
    
    /*
     * 更新
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if (empty($id)) {
            return $this->json(1, 'id 不能为空');
        }

        $data = UrlModel::where('id', $id)
            ->first();
        
        return view('sys/url/update', [
            'data' => $data,
        ]);
    }
    
    /*
     * 更新保存
     *
     * @param Request $request
     * @return Response
     */
    public function updateSave(Request $request, $id)
    {
        $url = $request->post('url', '');
        $status = $request->post('status', '');

        $checked = ValidateCheck::data([
            'url' => $url,
            'status' => $status,
        ], [
            'url' => 'require|url',
            'status' => 'require|in:0,1',
        ], [
            'url.require' => '链接地址不能为空',
            'url.url' => '链接地址不正确',
            'status.require' => '状态不能为空',
            'status.in' => '状态数据错误',
        ]);
        if ($checked !== true) {
            return $this->json(1, $checked);
        }

        $urlData = parse_url($url);
        
        $data = UrlModel::where('id', $id)->first();
        if (empty($data)) {
            return $this->json(1, '数据不存在');
        }

        $updateStatus = UrlModel::where('id', $id)
            ->update([
                'url' => $url,
                'scheme' => $urlData['scheme'] ?? '',
                'host' => $urlData['host'] ?? '',
                'port' => $urlData['port'] ?? 80,
                'status' => $status,
            ]);
        if ($updateStatus === false) {
            return $this->json(1, '更新失败');
        }
        
        UrlModel::deleteDataCache($data['url_id']);
        
        return $this->json(0, '更新成功');
    }
    
    /*
     * 删除
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        if (empty($id)) {
            return $this->json(1, 'id 不能为空');
        }
        
        $data = UrlModel::where('id', $id)->first();
        if (empty($data)) {
            return $this->json(1, '数据不存在');
        }

        $status = UrlModel::where('id', $id)
            ->delete();
        if ($status === false) {
            return $this->json(1, '删除失败');
        }
        
        UrlModel::deleteDataCache($data['url_id']);
        
        return $this->json(0, '删除成功');
    }
    
    /*
     * 启用
     *
     * @param Request $request
     * @return Response
     */
    public function enable(Request $request, $id)
    {
        if (empty($id)) {
            return $this->json(1, 'id 不能为空');
        }

        $data = UrlModel::where('id', $id)->first();
        if (empty($data)) {
            return $this->json(1, '数据不存在');
        }

        $status = UrlModel::where('id', $id)
            ->update([
                'status' => 1,
            ]);
        if ($status === false) {
            return $this->json(1, '启用失败');
        }
        
        UrlModel::deleteDataCache($data['url_id']);
        
        return $this->json(0, '启用成功');
    }
    
    /*
     * 禁用
     *
     * @param Request $request
     * @return Response
     */
    public function disable(Request $request, $id)
    {
        if (empty($id)) {
            return $this->json(1, 'id 不能为空');
        }

        $data = UrlModel::where('id', $id)->first();
        if (empty($data)) {
            return $this->json(1, '数据不存在');
        }

        $status = UrlModel::where('id', $id)
            ->update([
                'status' => 0,
            ]);
        if ($status === false) {
            return $this->json(1, '禁用失败');
        }
        
        UrlModel::deleteDataCache($data['url_id']);
        
        return $this->json(0, '禁用成功');
    }
}
