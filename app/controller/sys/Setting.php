<?php

namespace app\controller\sys;

use Webman\Captcha\CaptchaBuilder;

use support\Request;

use app\model\Setting as SettingModel;
use app\controller\Base as BaseController;

/**
 * 网站设置
 *
 * @create 2022-11-8
 * @author deatil
 */
class Setting extends BaseController
{
    /*
     * 首页
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = SettingModel::getListByKv();
        
        return view('sys/setting/index', [
            'data' => $data,
        ]);
    }
    
    /*
     * 保存
     *
     * @param Request $request
     * @return Response
     */
    public function save(Request $request)
    {
        $setting = $request->post('setting', []);

        SettingModel::updateByKv($setting);
        
        return $this->json(0, '设置保存成功');
    }
}
