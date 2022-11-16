<?php

return [
    'method' => 'DES-EDE3-CBC',
    'key'    => 'key123456',
    'iv'     => 'iv123456',
    'output' => 'base64',
    
    'avatar_salt' => 'vgdert5r',
    
    // 管理账号
    'admin_ids' => [
        1,
    ],
    
    'find_password_content' => '你正在找回密码，点击链接 {url} 修改密码。',
];
