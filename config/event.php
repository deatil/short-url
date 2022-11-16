<?php

return [
    // 发送找回密码后
    'account.reset-password-check' => [
        [app\listener\Account::class, 'resetPasswordCheck'],
    ],
];
