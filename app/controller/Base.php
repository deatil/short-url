<?php

namespace app\controller;

/**
 * 基础控制器
 */
class Base
{
    /**
     * 返回格式化json数据
     *
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return \support\Response
     */
    protected function json(int $code, string $msg = 'ok', array $data = [])
    {
        return json([
            'code' => $code, 
            'msg' => $msg, 
            'data' => $data, 
        ]);
    }

    /**
     * 返回页面
     *
     * @param string $msg
     * @param string $url
     * @param int    $wait
     * @return \support\Response
     */
    protected function msg(string $msg, string $url = '', int $wait = 5)
    {
        return msg($msg, $url, $wait);
    }

}
