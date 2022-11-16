<?php

namespace app\controller;

use Webman\Event\Event;
use Webman\Captcha\CaptchaBuilder;

use support\Cache;
use support\Request;

use Lakew\Auth;
use Lakew\Util;
use Lakew\Validate\Check as ValidateCheck;

use app\model\User as UserModel;

/**
 * 登录相关
 *
 * @create 2022-10-30
 * @author deatil
 */
class Account extends Base
{
    /**
     * 验证码
     *
     * @param Request $request
     * @return Response
     */
    public function captcha(Request $request)
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        $request->session()->set("captcha-account", strtolower($builder->getPhrase()));
        $imgContent = $builder->get();
        
        return response($imgContent, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }

    /**
     * 登录
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $session = $request->session();
        if ($session->get('user_id')) {
            return redirect(route('my.index'));
        }
        
        return view('account/login');
    }
    
    /**
     * 登录
     *
     * @param Request $request
     * @return Response
     */
    public function loginCheck(Request $request)
    {
        $session = $request->session();
        if ($session->get('user_id')) {
            return $this->json(1, '你已经登录了');
        }
        
        $captcha = $request->post('captcha');
        if (strtolower($captcha) !== session('captcha-account')) {
            return $this->json(1, '验证码错误');
        }
        
        $session->forget('captcha-account');
        
        $username = $request->post('username', '');
        $password = $request->post('password', '');
        
        if (!$username) {
            return $this->json(1, '用户名不能为空');
        }
        
        $user = UserModel::where('username', $username)->first();
        if (!$user || !Util::passwordVerify($password, $user->password)) {
            return $this->json(1, '账户不存在或密码错误');
        }
        
        $session->set('user_id', $user->id);
        
        $response = $this->json(0, '登录成功', []);

        $rememberme = $request->post('rememberme', '0');
        if ($rememberme == 1) {
            // cookie($name, $value = '', $max_age = null, $path = '', $domain = '', $secure = false, $http_only = false, $same_site  = false)
            $value = Auth::make()->encrypt($user['id']);
            $maxAge = time() + 604800;
            $response->cookie('keep-login', $value, $maxAge, '/');
        }
        
        return $response;
    }

    /**
     * 注册
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $request->session()->delete('user_id');
        
        return view('account/register');
    }
    
    /**
     * 注册确认
     *
     * @param Request $request
     * @return Response
     */
    public function registerCheck(Request $request)
    {
        $captcha = $request->post('captcha');
        if (strtolower($captcha) !== session('captcha-account')) {
            return $this->json(1, '验证码错误');
        }
        
        $session = $request->session();
        $session->forget('captcha-account');

        $username = $request->post('username', '');
        $email = $request->post('email', '');
        $password = $request->post('password', '');
        $agree = $request->post('agree', '');
        
        $checked = ValidateCheck::data([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
            'agree'    => $agree,
        ], [
            'username' => 'require|alphaDash|min:3',
            'email'    => 'require|email',
            'password' => 'require',
            'agree'    => 'require|eq:1',
        ], [
            'username.require'   => '用户名不能为空',
            'username.alphaDash' => '用户名只能是字母、数字和下划线_及破折号-',
            'username.min'       => '用户名最少需要3个字符',
            'email.require'      => '邮箱不能为空',
            'email.email'        => '邮箱格式错误',
            'password.require'   => '密码不能为空',
            'agree.require'      => '请选择同意',
            'agree.eq'           => '请选择同意',
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
        
        $newPassword = Util::passwordHash($password);
        
        $newUser = UserModel::create([
            'username' => $username,
            'password' => $newPassword,
            'email' => $email,
            'status' => 1,
            'add_time' => time(),
            'add_ip' => $request->getRealIp(true),
        ]);
        if ($newUser === false) {
            return $this->json(1, '注册账号失败');
        }
        
        return $this->json(0, '注册账号成功', []);
    }

    /**
     * 重设密码
     *
     * @param Request $request
     * @return Response
     */
    public function resetPassword(Request $request)
    {
        $request->session()->delete('user_id');
        
        return view('account/reset_password');
    }
    
    /**
     * 重设密码确认
     *
     * @param Request $request
     * @return Response
     */
    public function resetPasswordCheck(Request $request)
    {
        $captcha = $request->post('captcha');
        if (strtolower($captcha) !== session('captcha-account')) {
            return $this->json(1, '验证码错误');
        }
        
        $session = $request->session();
        $session->forget('captcha-account');

        $email = $request->post('email', '');
        if (!$email) {
            return $this->json(1, '邮箱不能为空');
        }
        
        $user = UserModel::where('email', $email)->first();
        if (!$user) {
            return $this->json(1, '邮箱不存在');
        }
        
        $hashid = md5(time().$user['id']);
        
        // 设置缓存
        Cache::set($hashid, $user['id'], 300);
        
        $url = route('account.find-password', [
            'hashid' => $hashid,
        ]);
        
        $url = $request->host() . $url;
        $content = config('auth.find_password_content');
        $content = str_ireplace('{url}', $url, $content);
        
        $data = [
            'email' => $email,
            'url' => $url,
            'content' => $content,
        ];
        Event::emit('account.reset-password-check', $data);
        
        return $this->json(0, '提交成功', []);
    }

    /**
     * 找回密码
     *
     * @param Request $request
     * @return Response
     */
    public function findPassword(Request $request, $hashid)
    {
        if (!$hashid) {
            return $this->msg('访问错误');
        }
        
        $userid = Cache::get($hashid);
        if (!$userid) {
            return $this->msg('链接已过期');
        }
        
        return view('account/find_password', [
            'hashid' => $hashid,
        ]);
    }
    
    /**
     * 找回密码确认
     *
     * @param Request $request
     * @return Response
     */
    public function findPasswordCheck(Request $request, $hashid)
    {
        if (!$hashid) {
            return $this->json(1, '访问错误');
        }
        
        $password = $request->post('password', '');
        $password2 = $request->post('password2', '');
        
        if (!$password) {
            return $this->json(1, '密码不能为空');
        }
        if (!$password2) {
            return $this->json(1, '确认密码不能为空');
        }
        if ($password2 != $password) {
            return $this->json(1, '两次密码不一致');
        }
        
        $userid = Cache::get($hashid);
        if (!$userid) {
            return $this->json(1, '链接已过期');
        }
        
        // 删除缓存
        Cache::delete($hashid);
        
        $user = UserModel::where('id', $userid)->first();
        if (!$user) {
            return $this->json(1, '账号不存在');
        }
        
        $status = $user->update([
            'password' => Util::passwordHash($password),
        ]);
        if ($status === false) {
            return $this->json(1, '更改密码失败');
        }
        
        return $this->json(0, '更改密码成功', []);
    }

    /**
     * 退出
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        $session = $request->session();
        $session->delete('user_id');
        $session->delete('user');
        
        $response = $this->msg('退出成功', route('account.login'));
        $response->cookie('keep-login', '', time() - 3600, '/');
        
        return $response;
    }

}
