<?php

use Webman\Route;
use app\middleware;
use app\controller;
use app\controller\sys as sysController;
use app\controller\api as apiController;

// 默认
Route::group('', function() {
    // 首页
    Route::get('/', [controller\Index::class, 'index'])->name('index.index');
})->middleware([
    middleware\CheckWebsiteOpen::class,
    middleware\SetLoginInfo::class,
]);

// 登录相关
Route::group('/account', function() {
    Route::get('/captcha', [controller\Account::class, 'captcha'])->name('account.captcha');
    Route::get('/login', [controller\Account::class, 'login'])->name('account.login');
    Route::post('/login', [controller\Account::class, 'loginCheck'])->name('account.login-check');
    Route::get('/logout', [controller\Account::class, 'logout'])->name('account.logout');
    
    Route::group('', function() {
        Route::get('/register', [controller\Account::class, 'register'])->name('account.register');
        Route::post('/register', [controller\Account::class, 'registerCheck'])->name('account.register-check');
        Route::get('/reset-password', [controller\Account::class, 'resetPassword'])->name('account.reset-password');
        Route::post('/reset-password', [controller\Account::class, 'resetPasswordCheck'])->name('account.reset-password-check');
        Route::get('/find-password/{hashid}', [controller\Account::class, 'findPassword'])->name('account.find-password');
        Route::post('/find-password/{hashid}', [controller\Account::class, 'findPasswordCheck'])->name('account.find-password-check');
    
    })->middleware([
        middleware\CheckWebsiteOpen::class,
    ]);
});

// 需登录检测路由
Route::group('', function() {
    // 账号相关中间件
    $userMiddleware = [
        middleware\CheckWebsiteOpen::class,
        middleware\SetLoginInfo::class,
        middleware\LoginCheck::class,
    ];

    // 我的
    Route::group('/my', function() {
        Route::get('/index', [controller\My::class, 'index'])->name('my.index');
        Route::get('/profile', [controller\My::class, 'profile'])->name('my.profile');
        
        Route::get('/settings', [controller\MySettings::class, 'index'])->name('my.settings');
        Route::post('/settings-profile', [controller\MySettings::class, 'profileSave'])->name('my.settings.profile-save');
        Route::post('/settings-password', [controller\MySettings::class, 'passwordSave'])->name('my.settings.password-save');
        Route::post('/settings-avatar', [controller\MySettings::class, 'avatarSave'])->name('my.settings.avatar-save');

        // 申请
        Route::get('/apply', [controller\MyApply::class, 'index'])->name('my.apply');
        Route::post('/apply', [controller\MyApply::class, 'applySave'])->name('my.apply.save');
        Route::post('/apply-delete', [controller\MyApply::class, 'delete'])->name('my.apply.delete');

        // 短链接
        Route::get('/url', [controller\MyUrl::class, 'index'])->name('my.url');
        Route::get('/url-create', [controller\MyUrl::class, 'create'])->name('my.url.create');
        Route::post('/url-create', [controller\MyUrl::class, 'createSave'])->name('my.url.create-save');
        Route::post('/url-delete', [controller\MyUrl::class, 'delete'])->name('my.url.delete');
    })->middleware($userMiddleware);

    // 帮助中心
    Route::group('/help', function() {
        Route::get('', [controller\Help::class, 'index'])->name('help.index');
    })->middleware($userMiddleware);

    // 上传
    Route::group('/upload', function() {
        Route::post('/avatar', [controller\Upload::class, 'avatar'])->name('upload.avatar');
    })->middleware($userMiddleware);

});

// =====================

// 跳转
Route::get('/r/{id}', [controller\Redirect::class, 'url'])->name('redirect.url');

// =====================

// api 接口
Route::group('/api', function() {
    Route::post('/url/index', [apiController\Url::class, 'index'])->name('api.url.index');
    Route::post('/url/create', [apiController\Url::class, 'create'])->name('api.url.create');
    Route::post('/url/delete', [apiController\Url::class, 'delete'])->name('api.url.delete');
})->middleware([
    middleware\CheckWebsiteOpen::class,
    middleware\CheckApiSign::class,
]);

// =====================

// 系统管理
Route::group('/sys', function() {
    // 系统中间件
    $sysMiddleware = [
        middleware\SetLoginInfo::class,
        middleware\LoginCheck::class,
        middleware\AdminCheck::class,
    ];

    // 用户管理
    Route::group('/user', function() {
        Route::get('/index', [sysController\User::class, 'index'])->name('sys.user.index');
        Route::get('/create', [sysController\User::class, 'create'])->name('sys.user.create');
        Route::post('/create', [sysController\User::class, 'createSave'])->name('sys.user.create-save');
        Route::get('/update/{id}', [sysController\User::class, 'update'])->name('sys.user.update');
        Route::post('/update/{id}', [sysController\User::class, 'updateSave'])->name('sys.user.update-save');
        Route::get('/password/{id}', [sysController\User::class, 'password'])->name('sys.user.password');
        Route::post('/password/{id}', [sysController\User::class, 'passwordSave'])->name('sys.user.password-save');
        Route::post('/delete/{id}', [sysController\User::class, 'delete'])->name('sys.user.delete');
        Route::post('/enable/{id}', [sysController\User::class, 'enable'])->name('sys.user.enable');
        Route::post('/disable/{id}', [sysController\User::class, 'disable'])->name('sys.user.disable');
    })->middleware($sysMiddleware);

    // 链接管理
    Route::group('/url', function() {
        Route::get('/index', [sysController\Url::class, 'index'])->name('sys.url.index');
        Route::get('/update/{id}', [sysController\Url::class, 'update'])->name('sys.url.update');
        Route::post('/update/{id}', [sysController\Url::class, 'updateSave'])->name('sys.url.update-save');
        Route::post('/delete/{id}', [sysController\Url::class, 'delete'])->name('sys.url.delete');
        Route::post('/enable/{id}', [sysController\Url::class, 'enable'])->name('sys.url.enable');
        Route::post('/disable/{id}', [sysController\Url::class, 'disable'])->name('sys.url.disable');
    })->middleware($sysMiddleware);

    // 申请管理
    Route::group('/apply', function() {
        Route::get('/index', [sysController\Apply::class, 'index'])->name('sys.apply.index');
        Route::post('/delete', [sysController\Apply::class, 'delete'])->name('sys.apply.delete');
        Route::get('/check/{id}', [sysController\Apply::class, 'check'])->name('sys.apply.check');
        Route::post('/check/{id}', [sysController\Apply::class, 'checkSave'])->name('sys.apply.check-save');
    })->middleware($sysMiddleware);

    // 网站设置
    Route::group('/setting', function() {
        Route::get('', [sysController\Setting::class, 'index'])->name('sys.setting.index');
        Route::post('', [sysController\Setting::class, 'save'])->name('sys.setting.save');
    })->middleware($sysMiddleware);
    
});

// =====================

// 处理404
Route::fallback(function() {
    return msg('页面不存在');
});

// 关闭默认路由
Route::disableDefaultRoute();


