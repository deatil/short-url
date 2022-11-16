<?php

namespace Lakew\Validate;

use RuntimeException;

/**
 * 验证
 *
 * @create 2022-11-11
 * @author deatil
 */
class Check
{
    /**
     * 获取验证类
     *
     * @return Validate
     */
    public static function validate(): Validate
    {
        return new Validate();
    }
    
    /**
     * 验证数据
     *
     * @param array $data    数据
     * @param array $rules   验证规则
     * @param array $message 错误信息
     * @return bool|string
     */
    public static function data(array $data, array $rules, array $message)
    {
        $validate = new Validate();
        $validate->message($message);
        $validate->batch(false);
        $validate->failException(false);
        
        $checked = $validate->check($data, $rules);
        if ($checked) {
            return true;
        }
        
        return $validate->getError();
    }
    
    /**
     * 验证数据
     *
     * @param mixed $value 字段值
     * @param mixed $rules 验证规则
     * @return bool
     */
    public static function rule($value, $rules): bool
    {
        $validate = new Validate();
        $validate->failException(false);
        
        return $validate->checkRule($value, $rules);
    }
}
