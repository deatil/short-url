<?php

use Webman\Route;
use app\middleware;
use app\controller;
use app\controller\sys as sysController;

// 默认
Route::group('', function() {
    // 首页
    Route::get('/', [controller\Index::class, 'index'])->name('index.index');
    Route::get('/r/{id}', [controller\Index::class, 'redirect'])->name('index.redirect');
})->middleware([
    middleware\SetLoginInfo::class,
]);

// api
Route::group('/api', function() {
    Route::post('/create-url', [controller\Api::class, 'createUrl'])->name('api.create-url');
});

// 登录相关
Route::group('/account', function() {
    Route::get('/captcha', [controller\Account::class, 'captcha'])->name('account.captcha');
    Route::get('/login', [controller\Account::class, 'login'])->name('account.login');
    Route::post('/login', [controller\Account::class, 'loginCheck'])->name('account.login-check');
    Route::get('/register', [controller\Account::class, 'register'])->name('account.register');
    Route::post('/register', [controller\Account::class, 'registerCheck'])->name('account.register-check');
    Route::get('/reset-password', [controller\Account::class, 'resetPassword'])->name('account.reset-password');
    Route::post('/reset-password', [controller\Account::class, 'resetPasswordCheck'])->name('account.reset-password-check');
    Route::get('/find-password/{hashid}', [controller\Account::class, 'findPassword'])->name('account.find-password');
    Route::post('/find-password/{hashid}', [controller\Account::class, 'findPasswordCheck'])->name('account.find-password-check');
    Route::get('/logout', [controller\Account::class, 'logout'])->name('account.logout');
});

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

})->middleware([
    middleware\SetLoginInfo::class,
    middleware\LoginCheck::class,
]);

// 上传
Route::group('/upload', function() {
    Route::post('/avatar', [controller\Upload::class, 'avatar'])->name('upload.avatar');

})->middleware([
    middleware\SetLoginInfo::class,
    middleware\LoginCheck::class,
]);

// 帮助中心
Route::group('/help', function() {
    Route::get('', [controller\Help::class, 'index'])->name('help.index');

})->middleware([
    middleware\SetLoginInfo::class,
    middleware\LoginCheck::class,
]);

// 用户管理
Route::group('/user', function() {
    Route::get('/index', [sysController\User::class, 'index'])->name('user.index');
    Route::get('/create', [sysController\User::class, 'create'])->name('user.create');
    Route::post('/create', [sysController\User::class, 'createSave'])->name('user.create-save');
    Route::get('/update/{id}', [sysController\User::class, 'update'])->name('user.update');
    Route::post('/update/{id}', [sysController\User::class, 'updateSave'])->name('user.update-save');
    Route::get('/password/{id}', [sysController\User::class, 'password'])->name('user.password');
    Route::post('/password/{id}', [sysController\User::class, 'passwordSave'])->name('user.password-save');
    Route::post('/delete/{id}', [sysController\User::class, 'delete'])->name('user.delete');
    Route::post('/enable/{id}', [sysController\User::class, 'enable'])->name('user.enable');
    Route::post('/disable/{id}', [sysController\User::class, 'disable'])->name('user.disable');

})->middleware([
    middleware\SetLoginInfo::class,
    middleware\LoginCheck::class,
    middleware\AdminCheck::class,
]);

// 链接管理
Route::group('/url', function() {
    Route::get('/index', [sysController\Url::class, 'index'])->name('url.index');
    Route::get('/update/{id}', [sysController\Url::class, 'update'])->name('url.update');
    Route::post('/update/{id}', [sysController\Url::class, 'updateSave'])->name('url.update-save');
    Route::post('/delete/{id}', [sysController\Url::class, 'delete'])->name('url.delete');
    Route::post('/enable/{id}', [sysController\Url::class, 'enable'])->name('url.enable');
    Route::post('/disable/{id}', [sysController\Url::class, 'disable'])->name('url.disable');

})->middleware([
    middleware\SetLoginInfo::class,
    middleware\LoginCheck::class,
    middleware\AdminCheck::class,
]);

// 申请管理
Route::group('/apply', function() {
    Route::get('/index', [sysController\Apply::class, 'index'])->name('apply.index');
    Route::post('/delete', [sysController\Apply::class, 'delete'])->name('apply.delete');
    Route::get('/check/{id}', [sysController\Apply::class, 'check'])->name('apply.check');
    Route::post('/check/{id}', [sysController\Apply::class, 'checkSave'])->name('apply.check-save');

})->middleware([
    middleware\SetLoginInfo::class,
    middleware\LoginCheck::class,
]);

// 网站设置
Route::group('/setting', function() {
    Route::get('', [sysController\Setting::class, 'index'])->name('setting.index');
    Route::post('', [sysController\Setting::class, 'save'])->name('setting.save');

})->middleware([
    middleware\SetLoginInfo::class,
    middleware\LoginCheck::class,
    middleware\AdminCheck::class,
]);

// 处理404
Route::fallback(function() {
    return msg('页面不存在');
});

// 关闭默认路由
Route::disableDefaultRoute();


