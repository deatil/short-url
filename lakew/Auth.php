<?php

namespace Lakew;

/**
 * Auth
 *
 * @create 2022-10-1
 * @author deatil
 */
class Auth
{
    // 方法
    private $method = 'DES-EDE3-CBC';
    
    // 密钥
    private $key = '';
    
    // 向量
    private $iv = '';
    
    // 输出类型
    private $output = Crypto::OUTPUT_BASE64;
    
    /**
     * 构造函数
     */
    public function __construct($key, $method, $output, $iv)
    {
        $this->key = $key;
        $this->method = $method;
        $this->output = $output;
        $this->iv = $iv;
    }
    
    /**
     * 生成
     */
    public static function make()
    {
        $config = config('auth', []);
        
        $key = $config['key'];
        $method = $config['method'];
        $iv = $config['iv'];
        $output = $config['output'];
        
        $des = new static($key, $method, $output, $iv);
        return $des;
    }
    
    /**
     * 加密
     *
     * @param string $data 数据
     */
    public function encrypt($data)
    {
        $crypto = new Crypto($this->key, $this->method, $this->output, $this->iv);
        $res = $crypto->encrypt($data);
        
        return $res;
    }
    
    /**
     * 解密
     *
     * @param string $data 数据
     */
    public function decrypt($data)
    {
        $crypto = new Crypto($this->key, $this->method, $this->output, $this->iv);
        $res = $crypto->decrypt($data);
        
        return $res;
    }
    
}