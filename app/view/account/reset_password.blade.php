@extends('account.base')

@section('title', '找回密码')

@section('style')
    <style>
    .captcha {
        position: relative;
    }
    .reg-captcha-image {
        position: absolute;
        top: 24px;
        right: 0;
    }
    .reg-captcha-image > img {
        cursor: pointer;
        border-radius: .25rem;
    }
    </style>
@endsection

@section('content')
    <h2 class="auth-heading text-center mb-4">找回密码</h2>

    <div class="auth-intro mb-4 text-center">在下面填写邮箱地址，我们将发送重置密码地址到你的邮箱。</div>

    <div class="auth-form-container text-left">
        
        <form class="auth-form resetpass-form">                
            <div class="email mb-3">
                <label class="sr-only" for="reg-email">你的邮箱</label>
                <input id="reg-email" name="reg-email" type="email" class="form-control login-email" placeholder="你的邮箱" required="required">
            </div><!--//form-group-->
            
            <div class="captcha mb-3">
                <label class="sr-only" for="reg-captcha">验证码</label>
                <input id="reg-captcha" name="reg-captcha" type="text" class="form-control reg-captcha" placeholder="验证码" required="required">
                <div class="reg-captcha-image">
                    <img src="{{ route('account.captcha') }}" 
                        data-src="{{ route('account.captcha') }}" 
                        class="js-captcha-refresh"
                        title="刷新验证码"
                        alt="captcha"/>
                </div>
            </div><!--//form-group-->
            
            <div class="text-center">
                <button type="button" class="btn app-btn-primary btn-block theme-btn mx-auto js-save-button">提交申请</button>
            </div>
        </form>
        
        <div class="auth-option text-center pt-5"><a class="app-link" href="{{ route('account.login') }}" >登录</a> <span class="px-2">|</span> <a class="app-link" href="{{ route('account.register') }}" >注册</a></div>
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
        $(".js-save-button").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var email = $("#reg-email").val();
            var captcha = $("#reg-captcha").val();

            var url = "{{ route('account.reset-password-check') }}";
            $.post(url, {
                email: email,
                captcha: captcha,
            }, function(data) {
                if (data.code == 0) {
                    layer.msg("提交成功");
                    
                    $("#reg-email").val('');
                    $("#reg-captcha").val('');
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
