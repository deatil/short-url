<?php

namespace Lakew\Validate;

use RuntimeException;

/**
 * 数据验证异常
 *
 * @create 2022-11-11
 * @author deatil
 */
class ValidateException extends RuntimeException
{
    protected $error;

    /**
     * 构造函数
     */
    public function __construct($error)
    {
        $this->error   = $error;
        $this->message = is_array($error) ? implode(PHP_EOL, $error) : $error;
    }

    /**
     * 获取验证错误信息
     *
     * @access public
     * @return array|string
     */
    public function getError()
    {
        return $this->error;
    }
}
