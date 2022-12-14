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
     * @param array $data          数据
     * @param array $rules         验证规则
     * @param array $message       错误信息
     * @param bool  $batch         批量返回
     * @param bool  $failException 抛出异常
     * @return bool|string
     */
    public static function data(
        array $data, 
        array $rules, 
        array $message,
        bool $batch = false,
        bool $failException = false
    ) {
        $validate = new Validate();
        $validate->message($message);
        $validate->batch($batch);
        $validate->failException($failException);
        
        $checked = $validate->check($data, $rules);
        if ($checked) {
            return true;
        }
        
        return $validate->getError();
    }
    
    /**
     * 验证单个数据
     *
     * @param mixed $value         字段值
     * @param mixed $rules         验证规则
     * @param bool  $failException 抛出异常
     * @return bool
     */
    public static function value($value, $rules, bool $failException = false): bool
    {
        $validate = new Validate();
        $validate->failException($failException);
        
        return $validate->checkRule($value, $rules);
    }
}
