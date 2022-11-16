<?php

namespace app\controller;

use Webman\Captcha\CaptchaBuilder;

use support\Request;

use Lakew\Util;
use Lakew\Validate\Check as ValidateCheck;

use app\model\User as UserModel;

/**
 * 我的设置
 *
 * @create 2022-11-8
 * @author deatil
 */
class MySettings extends Base
{
    /*
     * 我的设置
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userInfo = $request->session()->get('user');

        return view('my_settings/index', [
            'userInfo' => $userInfo,
        ]);
    }
    
    /*
     * 个人信息
     *
     * @param Request $request
     * @return Response
     */
    public function profileSave(Request $request)
    {
        $userId = $request->session()->get('user_id');

        $username = $request->post('username', '');
        $email = $request->post('email', '');
        $phone = $request->post('phone', '');
        
        $checked = ValidateCheck::data([
            'username' => $username,
            'email'    => $email,
            'phone'    => $phone,
        ], [
            'username' => 'require|alphaDash|min:3',
            'email'    => 'require|email',
            'phone'    => 'mobile',
        ], [
            'username.require'   => '账号必须',
            'username.alphaDash' => '账号只能是字母、数字和下划线_及破折号-',
            'username.min'       => '账号最少需要3个字符',
            'email.require'      => '邮箱必须',
            'email.email'        => '邮箱格式错误',
            'phone.mobile'       => '电话格式错误',
        ]);
        if ($checked !== true) {
            return $this->json(1, $checked);
        }

        $user = UserModel::where('id', '!=', $userId)
            ->where(function($query) use($username, $email) {
                $query->where('username', $username)
                    ->OrWhere('email', $email);
            })
            ->first();
        if ($user) {
            return $this->json(1, '账户或者邮箱已经存在');
        }
        
        $status = UserModel::where('id', $userId)
            ->update([
                'username' => $username,
                'email' => $email,
                'phone' => $phone,
            ]);
        if ($status === false) {
            return $this->json(1, '个人信息修改失败');
        }
        
        // 清空当前信息，重新更新
        $request->session()->delete('user');

        return $this->json(0, '个人信息修改成功');
    }
    
    /*
     * 密码修改
     *
     * @param Request $request
     * @return Response
     */
    public function passwordSave(Request $request)
    {
        $oldpassword = $request->post('oldpassword', '');
        $newpassword = $request->post('newpassword', '');
        $newpasswordConfirm = $request->post('newpassword_confirm', '');

        $checked = ValidateCheck::data([
            'oldpassword' => $oldpassword,
            'newpassword' => $newpassword,
            'newpassword_confirm' => $newpasswordConfirm,
        ], [
            'oldpassword' => 'require',
            'newpassword' => 'require|min:5',
            'newpassword_confirm' => 'require',
        ], [
            'oldpassword.require' => '旧密码不能为空',
            'newpassword.require' => '新密码不能为空',
            'newpassword.min' => '新密码最少5位',
            'newpassword_confirm.require' => '确认密码不能为空',
        ]);
        if ($checked !== true) {
            return $this->json(1, $checked);
        }
        
        if ($newpassword == $oldpassword) {
            return $this->json(1, '新密码不能和旧密码一样');
        }
        if ($newpassword != $newpasswordConfirm) {
            return $this->json(1, '确认密码与新密码不一致');
        }

        $userInfo = $request->session()->get('user');
        if (!Util::passwordVerify($oldpassword, $userInfo['password'])) {
            return $this->json(1, '旧密码错误');
        }

        $newPasswordHash = Util::passwordHash($newpassword);

        $status = UserModel::where('id', $userInfo['id'])
            ->update([
                'password' => $newPasswordHash,
            ]);
        if ($status === false) {
            return $this->json(1, '密码修改失败');
        }
        
        // 清空当前信息，重新更新
        $request->session()->delete('user');

        return $this->json(0, '密码修改成功');
    }
    
    /*
     * 头像修改
     *
     * @param Request $request
     * @return Response
     */
    public function avatarSave(Request $request)
    {
        $avatar = $request->post('avatar', '');

        $checked = ValidateCheck::data([
            'avatar' => $avatar,
        ], [
            'avatar' => 'require',
        ], [
            'avatar.require' => '头像不能为空',
        ]);
        if ($checked !== true) {
            return $this->json(1, $checked);
        }
        
        $userId = $request->session()->get('user_id');

        $status = UserModel::where('id', $userId)
            ->update([
                'avatar' => $avatar,
            ]);
        if ($status === false) {
            return $this->json(1, '头像修改失败');
        }
        
        // 清空当前信息，重新更新
        $request->session()->delete('user');
        
        return $this->json(0, '头像修改成功');
    }
}
