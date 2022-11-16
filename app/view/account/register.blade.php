@extends('account.base')

@section('title', '注册账号')

@section('style')
    <style>
    .captcha {
        position: relative;
    }
    .signup-captcha-image {
        position: absolute;
        top: 24px;
        right: 0;
    }
    .signup-captcha-image > img {
        cursor: pointer;
        border-radius: .25rem;
    }
    </style>
@endsection

@section('content')
    <h2 class="auth-heading text-center mb-4">注册账号</h2>

    <div class="auth-form-container text-left mx-auto">
        <form class="auth-form auth-signup-form">         
            <div class="username mb-3">
                <label class="sr-only" for="signup-username">登录账号</label>
                <input id="signup-username" name="signup-username" type="text" class="form-control signup-username" placeholder="登录账号" required="required">
            </div>
            <div class="email mb-3">
                <label class="sr-only" for="signup-email">你的邮箱</label>
                <input id="signup-email" name="signup-email" type="email" class="form-control signup-email" placeholder="邮箱" required="required">
            </div>
            <div class="password mb-3">
                <label class="sr-only" for="signup-password">密码</label>
                <input id="signup-password" name="signup-password" type="password" class="form-control signup-password" placeholder="账号密码" required="required">
            </div>
            <div class="captcha mb-3">
                <label class="sr-only" for="signup-captcha">验证码</label>
                <input id="signup-captcha" name="signup-captcha" type="text" class="form-control signup-captcha" placeholder="验证码" required="required">
                <div class="signup-captcha-image">
                    <img src="{{ route('account.captcha') }}" 
                        data-src="{{ route('account.captcha') }}" 
                        class="js-captcha-refresh"
                        title="刷新验证码"
                        alt="captcha"/>
                </div>
            </div><!--//form-group-->
            <div class="extra mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="AgreePrivacyPolicy">
                    <label class="form-check-label" for="AgreePrivacyPolicy">
                    我同意 <a href="#" class="app-link">服务条款</a> 和 <a href="#" class="app-link">隐私策略</a>。
                    </label>
                </div>
            </div><!--//extra-->
            
            <div class="text-center">
                <button type="button" class="btn app-btn-primary btn-block theme-btn mx-auto js-save-button">提交</button>
            </div>
        </form><!--//auth-form-->
        
        <div class="auth-option text-center pt-5">已经有了一个账号? <a class="text-link" href="{{ route('account.login') }}" >登录</a></div>
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
        
        // 提交
        $(".js-save-button").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var username = $("#signup-username").val();
            var email = $("#signup-email").val();
            var password = $("#signup-password").val();
            var captcha = $("#signup-captcha").val();
            var agree = $("#AgreePrivacyPolicy").is(":checked") ? 1 : 0;

            var url = "{{ route('account.register-check') }}";
            $.post(url, {
                username: username,
                email: email,
                password: password,
                captcha: captcha,
                agree: agree,
            }, function(data) {
                if (data.code == 0) {
                    layer.msg("注册成功");
                    
                    setTimeout(function() {
                        window.location.href = "{{ route('account.login') }}";
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
