<?php

namespace app\controller;

use Webman\Captcha\CaptchaBuilder;

use support\Request;
use Lakew\Random;

use app\model\App as AppModel;
use app\model\User as UserModel;

/**
 * 我的申请
 *
 * @create 2022-11-8
 * @author deatil
 */
class MyApply extends Base
{
    /*
     * 我的申请首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $app = AppModel::where('user_id', $userId)
            ->where('is_apply', '!=', 0)
            ->where('status', 1)
            ->first();

        return view('my_apply/index', [
            'app' => $app,
        ]);
    }
    
    /*
     * 申请保存
     *
     * @param Request $request
     * @return Response
     */
    public function applySave(Request $request)
    {
        $userId = $request->session()->get('user_id');
        
        $app = AppModel::where('user_id', $userId)
            ->where('is_apply', '!=', 0)
            ->where('status', 1)
            ->first();
        if (! empty($app)) {
            return $this->json(1, '你已经申请过了');
        }

        $content = $request->post('content', '');
        if (empty($content)) {
            return $this->json(1, '申请内容不能为空');
        }
        
        $insertData = [
            'user_id' => $userId,
            'app_id' => 'SU' . date('YmdHis') . mt_rand(10000, 99999),
            'app_secret' => Random::alnum(32),
            'apply_content' => $content,
            'is_apply' => 1,
            'status' => 1,
            'add_time' => time(),
            'add_ip' => $request->getRealIp(true),
        ];

        $status = AppModel::create($insertData);
        if ($status === false) {
            return $this->json(1, '申请操作失败');
        }

        return $this->json(0, '申请提交成功');
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
        
        $app = AppModel::where('user_id', $userId)
            ->where('is_apply', 1)
            ->where('status', 1)
            ->first();
        if (empty($app)) {
            return $this->json(1, '没有正在申请信息');
        }
        
        $status = $app->update([
            'is_apply' => 0,
        ]);
        if ($status === false) {
            return $this->json(1, '撤销申请失败');
        }

        return $this->json(0, '撤销申请成功');
    }
}
