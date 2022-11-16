@extends('account.base')

@section('title', '重设密码')

@section('content')
    <h2 class="auth-heading text-center mb-5">重设密码</h2>

    <div class="auth-intro mb-4 text-center">在下面填写新的账号密码。</div>

    <div class="auth-form-container text-left">
        <form class="auth-form login-form">         
            <div class="password mb-3">
                <label class="sr-only" for="signin-password">密码</label>
                <input id="signin-password" name="signin-password" type="password" class="form-control signin-password" placeholder="账号密码" required="required">
            </div><!--//form-group-->
            
            <div class="password mb-3">
                <label class="sr-only" for="signin-password2">确认密码</label>
                <input id="signin-password2" name="signin-password2" type="password" class="form-control signin-password" placeholder="确认密码" required="required">
            </div><!--//form-group-->
            
            <div class="text-center">
                <button type="button" class="btn app-btn-primary btn-block theme-btn mx-auto js-save-button">提交</button>
            </div>
        </form>
        
    </div><!--//auth-form-container-->	
@endsection

@section('script')
    <script type="text/javascript">
    (function($) {
        "use strict";
        
        // 确认
        $(".js-save-button").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var password = $("#signin-password").val();
            var password2 = $("#signin-password2").val();

            var url = "{{ route('account.find-password-check', ['hashid' => $hashid]) }}";
            $.post(url, {
                password: password,
                password2: password2,
            }, function(data) {
                if (data.code == 0) {
                    layer.msg("提交成功");
                    
                    $("#signin-password").val('');
                    $("#signin-password2").val('');
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
