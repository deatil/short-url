<?php

namespace app\listener;

use support\Log;

/**
 * 事件监听 - 登录相关
 *
 * @create 2022-10-30
 * @author deatil
 */
class Account
{
    // 发送验证邮件
    function resetPasswordCheck($data)
    {
        $url = $data['url'];
        $email = $data['email'];
        $content = $data['content'];
        
        if (empty($email)) {
            Log::error("发送找回密码邮件失败, 邮件为空: " . $email);
            return;
        }
        
        if (empty($content)) {
            Log::error("发送找回密码邮件失败, 内容为空。");
            return;
        }
        
        $confg = config('email');
        
        $object = email($confg);
        $status = $object
            ->subject('找回密码')
            ->to($email)
            ->message($content)
            ->send();
        
        if (!$status) {
            Log::error("发送找回密码邮件失败, 错误信息为: " . $object->getError());
        }
    }
}