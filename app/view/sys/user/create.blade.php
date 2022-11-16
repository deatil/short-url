@extends('common.base')

@section('title', '创建账号')

@section('style')
    @parent
@endsection

@section('content')
    <h1 class="app-page-title">创建账号</h1>
    
    <hr class="mb-4">
    
    <div class="row g-4 settings-section">
        <div class="col-12">
            <div class="app-card app-card-settings shadow-sm p-4">
                
                <div class="app-card-body">
                    <form class="user-form">
                        <div class="mb-3">
                            <label for="setting-username" class="form-label">
                                 登录账号
                            </label>
                            <input type="text" 
                                class="form-control" 
                                id="setting-username" 
                                name="username" 
                                value="" 
                                placeholder="登录账号"
                                required>
                            <small class="form-text text-muted">
                                填写登录账号
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="setting-email" class="form-label">
                                账号邮箱
                            </label>
                            <input type="text" 
                                class="form-control" 
                                id="setting-email" 
                                name="email" 
                                value="" 
                                placeholder="账号邮箱"
                                required>
                            <small class="form-text text-muted">
                                设置账号邮箱
                            </small>
                        </div>
                        
                        <button type="button" class="btn app-btn-primary js-save-button" >确认创建</button>
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

            var url = "{{ route('user.create-save') }}";
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
