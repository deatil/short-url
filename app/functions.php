<?php

use Lakew\Email;
use app\model\Setting as SettingModel;

// 页面提示
function msg($msg, $url = '', int $wait = 5)
{
    return view('error/error', [
        'msg'  => $msg,
        'url'  => $url,
        'wait' => $wait,
    ]);
}

// 短链接生成
function short_route($name, ...$parameters) 
{
    return '//' . request()->host() . route($name, ...$parameters);
}

// 短链接生成
function short_url($url) 
{
    return '//' . request()->host() . $url;
}

// 短链接生成
function share_url($id) 
{
    $url = config('url.share_url');
    
    return str_ireplace('{id}', $id, $url);
}

// 邮件
function email(array $options = []) 
{
    $config = array_merge(config("email", []), $options);
    $email = new Email($config);
    
    return $email;
}

// 静态路径
function assets($url) 
{
    $url = "/static/" . $url;
    
    return $url;
}

// 静态路径
function public_assets($url) 
{
    $url = "/" . $url;
    
    return $url;
}

// 上传静态路径
function upload_assets($url) 
{
    $url = "/upload/" . $url;
    
    return $url;
}

// 用户信息
function user_info($key = '') 
{
    $userInfo = request()->session()->get('user');
    if (! empty($key)) {
        return $userInfo[$key] ?? '';
    }
    
    return $userInfo;
}

// 用户ID
function user_id() 
{
    $userId = request()->session()->get('user_id');
    
    return $userId;
}

// 头像
function avatar_assets($avatar) 
{
    if (empty($avatar)) {
        $url = assets('images/avatar-default.jpg');
    } else {
        $url = upload_assets($avatar);
    }
    
    return $url;
}

// 是否为管理员
function is_admin() 
{
    $userId = user_id();
    
    $adminIds = config('auth.admin_ids');
    
    return in_array($userId, $adminIds);
}

// 用户ID
function setting($name = '') 
{
    $data = SettingModel::getDataCache();
    
    return $data[$name] ?? '';
}
