<?php

namespace Lakew;

/**
 * 签名
 * 
 * @create 2022-11-15
 * @author deatil
 */
class Sign 
{
    /**
     * 生成
     */
    public static function make()
    {
        return new static();
    }
    
    /**
     * 生成内容签名
     *
     * @param $data
     * @return string
     */
    public function makeSign($data, $key = '') 
    {
        ksort($data);
        
        $string = md5($this->makeSignContent($data) . '&key=' . $key);
        
        return strtoupper($string);
    }

    /**
     * 生成签名内容
     *
     * @param $data
     * @return string
     */
    public function makeSignContent($data)
    {
        $buff = '';
        
        foreach ($data as $k => $v) {
            $buff .= ($k != 'sign' && $v != '' && !is_array($v)) ? $k . '=' . $v . '&' : '';
        }
        
        return trim($buff, '&');
    }

    /**
     * 生成随机字符串
     *
     * @param int $length
     * @return string
     */
    public function createNonceStr($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        
        $str = '';
        
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        
        return $str;
    }
    
}
