<?php

namespace app\controller\sys;

use support\Request;

use Lakew\Util;
use Lakew\Http\Request as HttpRequest;
use Lakew\Page\Bootstrap as BootstrapPage;
use Lakew\Validate\Check as ValidateCheck;

use app\model\User as UserModel;
use app\controller\Base as BaseController;

/**
 * 用户
 *
 * @create 2022-11-8
 * @author deatil
 */
class User extends BaseController
{
    /*
     * 首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get("keyword", "");
        $page = $request->get("page", "1");
        
        $limit = 10;
        $start = max(((int) $page - 1) * $limit, 0);
        
        $query = UserModel::query()
            ->where(function($query) use($keyword) {
                $query->orWhere('username', 'like', '%'.$keyword.'%')
                    ->orWhere('email', 'like', '%'.$keyword.'%')
                    ->orWhere('phone', 'like', '%'.$keyword.'%');
            });
        
        $total = $query->count(); 
        $list = $query
            ->offset($start)
            ->limit($limit)
            ->orderBy('add_time', 'DESC')
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        // 分页页面
        $pageHtml = BootstrapPage::make($limit, (int) $page, $total, false, [
            'path' => $request->path(),
            'query' => HttpRequest::getQueryParams($request),
        ]);
        
        return view('sys/user/index', [
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
        return view('sys/user/create', []);
    }
    
    /*
     * 创建保存
     *
     * @param Request $request
     * @return Response
     */
    public function createSave(Request $request)
    {
        $username = $request->post('username', '');
        $email = $request->post('email', '');

        $checked = ValidateCheck::data([
            'username' => $username,
            'email' => $email,
        ], [
            'username' => 'require|alphaDash|min:3',
            'email' => 'require|email',
        ], [
            'username.require' => '账号不能为空',
            'username.alphaDash' => '账号只能是字母、数字和下划线_及破折号-',
            'username.min' => '账号最少3位字符',
            'email.require' => '邮箱不能为空',
            'email.email' => '邮箱格式错误',
        ]);
        if ($checked !== true) {
            return $this->json(1, $checked);
        }
        
        $user = UserModel::where('username', $username)
            ->OrWhere('email', $email)
            ->first();
        if ($user) {
            return $this->json(1, '账户或者邮箱已经存在');
        }
        
        $newUser = UserModel::create([
                'username' => $username,
                'email' => $email,
                'status' => 1,
                'add_time' => time(),
                'add_ip' => $request->getRealIp(true),
            ]);
        if ($newUser === false) {
            return $this->json(1, '创建账号失败');
        }
        
        return $this->json(0, '创建账号成功');
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
            return $this->msg('id 不能为空');
        }

        $user = UserModel::where('id', $id)
            ->first();
        if (empty($user)) {
            return $this->msg('账户不存在');
        }
        
        return view('sys/user/update', [
            'data' => $user,
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
        if (empty($id)) {
            return $this->json(1, 'id 不能为空');
        }

        $userId = $request->session()->get('user_id');
        if ($userId == $id) {
            return $this->json(1, '你不能修改你的账号信息');
        }

        $user = UserModel::where('id', $id)
            ->first();
        if (empty($user)) {
            return $this->json(1, '账户不存在');
        }
        
        $username = $request->post('username', '');
        $email = $request->post('email', '');
        $phone = $request->post('phone', '');
        $status = $request->post('status', '');
        $avatarDelete = $request->post('avatar_delete', '');

        $checked = ValidateCheck::data([
            'username' => $username,
            'email' => $email,
            'status' => $status,
        ], [
            'username' => 'require|alphaDash|min:3',
            'email' => 'require|email',
            'status' => 'require|in:0,1',
        ], [
            'username.require' => '账号不能为空',
            'username.alphaDash' => '账号只能是字母、数字和下划线_及破折号-',
            'username.min' => '账号最少3位字符',
            'email.require' => '邮箱不能为空',
            'email.email' => '邮箱格式错误',
            'status.require' => '状态不能为空',
            'status.in' => '状态信息错误',
        ]);
        if ($checked !== true) {
            return $this->json(1, $checked);
        }
        
        if (! empty($phone)) {
            $checked = ValidateCheck::data([
                'phone' => $phone,
            ], [
                'phone' => 'require|mobile',
            ], [
                'phone.require' => '电话不能为空',
                'phone.mobile' => '电话格式错误',
            ]);
            if ($checked !== true) {
                return $this->json(1, $checked);
            }
        }

        $user = UserModel::where('id', '!=', $id)
            ->where(function($query) use($username, $email) {
                $query->where('username', $username);
            })
            ->first();
        if ($user) {
            return $this->json(1, '账户已经存在');
        }
        
        $user = UserModel::where('id', '!=', $id)
            ->where(function($query) use($username, $email) {
                $query->where('email', $email);
            })
            ->first();
        if ($user) {
            return $this->json(1, '邮箱已经存在');
        }
        
        $data = [
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
        ];
        
        if ($avatarDelete == 1) {
            $data['avatar'] = '';
        }

        $status = UserModel::where('id', $id)
            ->update($data);
        if ($status === false) {
            return $this->json(1, '更新账号失败');
        }
        
        return $this->json(0, '更新账号成功');
    }
    
    /*
     * 密码
     *
     * @param Request $request
     * @return Response
     */
    public function password(Request $request, $id)
    {
        if (empty($id)) {
            return $this->msg('id 不能为空');
        }

        $user = UserModel::where('id', $id)
            ->first();
        if (empty($user)) {
            return $this->msg('账户不存在');
        }
        
        return view('sys/user/password', [
            'data' => $user,
        ]);
    }
    
    /*
     * 密码保存
     *
     * @param Request $request
     * @return Response
     */
    public function passwordSave(Request $request, $id)
    {
        if (empty($id)) {
            return $this->json(1, 'id 不能为空');
        }

        $userId = $request->session()->get('user_id');
        if ($userId == $id) {
            return $this->json(1, '你不能修改你的账号密码');
        }

        $user = UserModel::where('id', $id)
            ->first();
        if (empty($user)) {
            return $this->json(1, '账户不存在');
        }
        
        $newpassword = $request->post('newpassword', '');
        $newpasswordConfirm = $request->post('newpassword_confirm', '');

        $checked = ValidateCheck::data([
            'newpassword' => $newpassword,
            'newpassword_confirm' => $newpasswordConfirm,
        ], [
            'newpassword' => 'require|min:5',
            'newpassword_confirm' => 'require',
        ], [
            'newpassword.require' => '新密码不能为空',
            'newpassword.min' => '新密码最少5位',
            'newpassword_confirm.require' => '确认密码不能为空',
        ]);
        if ($checked !== true) {
            return $this->json(1, $checked);
        }
        
        if ($newpassword != $newpasswordConfirm) {
            return $this->json(1, '确认密码与新密码不一致');
        }

        $newPasswordHash = Util::passwordHash($newpassword);

        $status = UserModel::where('id', $id)
            ->update([
                'password' => $newPasswordHash,
            ]);
        if ($status === false) {
            return $this->json(1, '密码修改失败');
        }
        
        return $this->json(0, '更新密码成功');
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

        $userId = $request->session()->get('user_id');
        if ($userId == $id) {
            return $this->json(1, '你不能删除你的账号');
        }

        $user = UserModel::where('id', $id)
            ->first();
        if (empty($user)) {
            return $this->json(1, '账户不存在');
        }
        
        $status = UserModel::where('id', $id)
            ->delete();
        if ($status === false) {
            return $this->json(1, '删除账号失败');
        }
        
        return $this->json(0, '删除账号成功');
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

        $userId = $request->session()->get('user_id');
        if ($userId == $id) {
            return $this->json(1, '你不能修改你的账号信息');
        }

        $status = UserModel::where('id', $id)
            ->update([
                'status' => 1,
            ]);
        if ($status === false) {
            return $this->json(1, '启用失败');
        }
        
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

        $userId = $request->session()->get('user_id');
        if ($userId == $id) {
            return $this->json(1, '你不能修改你的账号信息');
        }

        $status = UserModel::where('id', $id)
            ->update([
                'status' => 0,
            ]);
        if ($status === false) {
            return $this->json(1, '禁用失败');
        }
        
        return $this->json(0, '禁用成功');
    }
}
