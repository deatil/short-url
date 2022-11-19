<?php

namespace app\controller\sys;

use support\Request;

use Lakew\Http\Request as HttpRequest;
use Lakew\Page\Bootstrap as BootstrapPage;
use Lakew\Validate\Check as ValidateCheck;

use app\model\App as AppModel;
use app\controller\Base as BaseController;

/**
 * 申请管理
 *
 * @create 2022-11-8
 * @author deatil
 */
class Apply extends BaseController
{
    /*
     * 首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userId = $request->session()->get('user_id');
        
        $keyword = $request->get("keyword", "");
        $page = $request->get("page", "1");
        
        $limit = 10;
        $start = max(((int) $page - 1) * $limit, 0);
        
        $query = AppModel::query()
            ->where(function($query) use($keyword) {
                $query->orWhere('app_id', 'like', '%'.$keyword.'%');
            });
        
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
        
        return view('sys/apply/index', [
            'keyword' => $keyword,
            'page' => $page,
            
            'total' => $total,
            'list' => $list,
            'pageHtml' => $pageHtml,
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
        $id = $request->post("id", "");
        if (empty($id)) {
            return $this->json(1, 'id 不能为空');
        }

        $status = AppModel::where('id', $id)
            ->delete();
        if ($status === false) {
            return $this->json(1, '删除申请失败');
        }
        
        return $this->json(0, '删除申请成功');
    }
    
    /*
     * 申请
     *
     * @param Request $request
     * @return Response
     */
    public function check(Request $request, $id)
    {
        if (empty($id)) {
            return $this->msg('id 不能为空');
        }

        $data = AppModel::where('id', $id)
            ->with('user')
            ->first();
        if (empty($data)) {
            return $this->msg('申请信息不存在');
        }
        
        return view('sys/apply/check', [
            'data' => $data,
        ]);
    }
    
    /*
     * 申请保存
     *
     * @param Request $request
     * @return Response
     */
    public function checkSave(Request $request, $id)
    {
        $check = $request->post("check", "0");
        $content = $request->post("content", "");
        $status = $request->post("status", "0");
        
        $checked = ValidateCheck::data([
            'check'   => $check,
            'status'  => $status,
            'content' => $content,
        ], [
            'check'   => 'require|in:0,1,2',
            'status'  => 'require|in:0,1',
            'content' => 'require',
        ], [
            'check.require'   => '审核状态信息必须',
            'check.in'        => '审核状态信息错误',
            'status.require'  => '状态信息必须',
            'status.in'       => '状态信息错误',
            'content.require' => '审核结果不能为空',
        ]);
        if ($checked !== true) {
            return $this->json(1, $checked);
        }

        $status = AppModel::where('id', $id)
            ->update([
                'is_apply' => $check,
                'action_content' => $content,
                'action_time' => time(),
                'status' => $status,
            ]);
        if ($status === false) {
            return $this->json(1, '操作失败');
        }
        
        return $this->json(0, '操作成功');
    }
}
