@extends('common.base')

@section('title', '账号密码')

@section('style')
    @parent
@endsection

@section('content')
    <h1 class="app-page-title">账号密码</h1>
    
    <hr class="mb-4">
    
    <div class="row g-4 settings-section">
        <div class="col-12">
            <div class="app-card app-card-settings shadow-sm p-4">
                
                <div class="app-card-body">
                    <form class="user-form">
                        <div class="mb-3">
                            <label class="form-label">
                                 账号
                            </label>
                            <input type="text" 
                                class="form-control" 
                                value="{{ $data['username'] }}" 
                                placeholder="账号"
                                disabled
                                required>
                            <small class="form-text text-muted">
                                登录账号
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="setting-newpassword" class="form-label">
                                 新密码
                            </label>
                            <input type="password" 
                                class="form-control" 
                                id="setting-newpassword" 
                                name="newpassword" 
                                value="" 
                                placeholder="新密码"
                                required>
                            <small class="form-text text-muted">
                                填写新密码
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="setting-newpassword_confirm" class="form-label">
                                确认密码
                            </label>
                            <input type="password" 
                                class="form-control" 
                                id="setting-newpassword_confirm" 
                                name="newpassword_confirm" 
                                value="" 
                                placeholder="确认密码"
                                required>
                            <small class="form-text text-muted">
                                设置确认密码
                            </small>
                        </div>
                        
                        <button type="button" class="btn app-btn-primary js-save-button" >确认提交</button>
                    </form>
                </div><!--//app-card-body-->
                
            </div><!--//app-card-->
        </div>
    </div><!--//row-->

@endsection

@section('script')
    @parent
    
    <script>
    $(function() {
        $(".nav-item.nav-settings .nav-link").addClass("active").attr("aria-expanded", "true");
        $(".nav-item.nav-settings .submenu").addClass("show");
        $(".submenu-item.nav-settings-user .submenu-link").addClass("active");

        // 保存
        $(".js-save-button").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var data = $(".user-form").serialize();

            var url = "{{ route('sys.user.password-save', ['id' => $data['id']]) }}";
            $.post(url, data, function(data) {
                if (data.code == 0) {
                    layer.msg(data.msg);
                    
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                } else {
                    layer.msg(data.msg);
                }
            }).fail(function (xhr, status, info) {
                layer.msg("请求失败");
            });
        });

    });
    </script> 
@endsection
