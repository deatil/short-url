@extends('account.base')

@section('title', '账号登录')

@section('style')
    <style>
    .captcha {
        position: relative;
    }
    .signin-captcha-image {
        position: absolute;
        top: 24px;
        right: 0;
    }
    .signin-captcha-image > img {
        cursor: pointer;
        border-radius: .25rem;
    }
    </style>
@endsection

@section('content')
    <h2 class="auth-heading text-center mb-5">账号登录</h2>
    <div class="auth-form-container text-left">
        <form class="auth-form login-form">         
            <div class="username mb-3">
                <label class="sr-only" for="signin-username">账号</label>
                <input id="signin-username" name="signin-username" type="username" class="form-control signin-username" placeholder="登录账号" required="required">
            </div><!--//form-group-->
            
            <div class="password mb-3">
                <label class="sr-only" for="signin-password">密码</label>
                <input id="signin-password" name="signin-password" type="password" class="form-control signin-password" placeholder="账号密码" required="required">
            </div><!--//form-group-->
            
            <div class="captcha mb-3">
                <label class="sr-only" for="signin-captcha">验证码</label>
                <input id="signin-captcha" name="signin-captcha" type="text" class="form-control signin-captcha" placeholder="验证码" required="required">
                <div class="signin-captcha-image">
                    <img src="{{ route('account.captcha') }}" 
                        data-src="{{ route('account.captcha') }}" 
                        class="js-captcha-refresh"
                        title="刷新验证码"
                        alt="captcha"/>
                </div>
            </div><!--//form-group-->
            
            <div class="extra mt-3 mb-3 row justify-content-between">
                <div class="col-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="RememberPassword">
                        <label class="form-check-label" for="RememberPassword">
                        记住登录状态
                        </label>
                    </div>
                </div><!--//col-6-->
                <div class="col-6">
                    <div class="forgot-password text-right">
                        <a href="{{ route('account.reset-password') }}">找回密码?</a>
                    </div>
                </div><!--//col-6-->
            </div><!--//extra-->
            <div class="text-center">
                <button type="button" class="btn app-btn-primary btn-block theme-btn mx-auto js-login-button">登录</button>
            </div>
        </form>
        
        <div class="auth-option text-center pt-5">还没有账号? 点击 <a class="text-link" href="{{ route('account.register') }}" >这里</a> 注册账号。</div>
    </div><!--//auth-form-container-->	
@endsection

@section('script')
    <script type="text/javascript">
    (function($) {
        "use strict";
        
        // 刷新验证码
        $(".js-captcha-refresh").click(function(e) {
            e.stopPropagation;
            e.preventDefault;
            
            var url = $(this).data("src") + "?t=" + Math.random();
            $(this).attr("src", url);
        });
        
        // 登录
        $(".js-login-button").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var username = $("#signin-username").val();
            var password = $("#signin-password").val();
            var captcha = $("#signin-captcha").val();
            var rememberme = $("#RememberPassword").is(":checked") ? 1 : 0;

            var url = "{{ route('account.login-check') }}";
            $.post(url, {
                username: username,
                password: password,
                captcha: captcha,
                rememberme: rememberme,
            }, function(data) {
                if (data.code == 0) {
                    layer.msg("登录成功");
                    
                    setTimeout(function() {
                        window.location.href = "{{ route('my.index') }}";
                    }, 1500);
                } else {
                    layer.msg(data.msg);
                }
            }).fail(function (xhr, status, info) {
                layer.msg("请求失败");
            });
        });
    })(jQuery);
    </script>
@endsection
