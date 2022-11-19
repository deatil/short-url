@extends('common.base')

@section('title', '编辑账号')

@section('style')
    @parent
    
    <style>
    .app-card-settings .avatar-data .avatar-image {
        width: 70px;
        height: 70px;
    }
    </style>
@endsection

@section('content')
    <h1 class="app-page-title">编辑账号</h1>
    
    <hr class="mb-4">
    <div class="app-card alert alert-dismissible shadow-sm mb-4" role="alert">
        <div class="inner">
            <div class="app-card-body p-1 p-lg-2">
                <h5 class="mb-3">账号信息</h5>
                <div class="row gx-2 gy-3">
                    <div class="col-12 col-lg-9">
                        <div>
                            <div>
                                <div class="text-muted">
                                    Id：
                                </div>
                                <div class="text-black">
                                    {{ $data['id'] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    账号：
                                </div>
                                <div class="text-black">
                                    {{ $data['username'] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    最后登录：
                                </div>
                                <div class="text-black">
                                    @if (!empty($data['login_time']))
                                        {{ date('Y-m-d H:i:s', $data['login_time']) }}
                                    @else
                                        --
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    注册时间：
                                </div>
                                <div class="text-black">
                                    {{ date('Y-m-d H:i:s', $data['add_time']) }}
                                </div>
                            </div>

                        </div>
                    </div><!--//col-->
                </div><!--//row-->
            </div><!--//app-card-body-->
            
        </div><!--//inner-->
    </div><!--//app-card-->
        
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
                                value="{{ $data['username'] }}" 
                                placeholder="登录账号"
                                required>
                            <small class="form-text text-muted">
                                填写登录账号，必须
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
                                value="{{ $data['email'] }}" 
                                placeholder="账号邮箱"
                                required>
                            <small class="form-text text-muted">
                                设置账号邮箱，必须
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="setting-phone" class="form-label">
                                账号电话
                            </label>
                            <input type="text" 
                                class="form-control" 
                                id="setting-phone" 
                                name="phone" 
                                value="{{ $data['phone'] }}" 
                                placeholder="账号电话"
                                required>
                            <small class="form-text text-muted">
                                设置账号电话
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                账号头像
                            </label>
                            <div class="avatar-data">
                                <div class="mb-2">
                                    <img class="rounded-circle avatar-image" 
                                        src="{{ avatar_assets($data['avatar']) }}" 
                                        alt="头像">
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="avatar_delete" id="settings-checkbox-avatar_delete" value="1">
                                    <label class="form-check-label small" for="settings-checkbox-avatar_delete">
                                        清空头像数据
                                    </label>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                后台管理只做清空账号头像
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                账号状态
                            </label>
                            <div class="form-control">
                                <label class="form-radio-label">
                                    <input class="form-radio-input" 
                                        type="radio" 
                                        name="status"
                                        value="1" 
                                        @if ($data['status'] == 1)
                                        checked=""
                                        @endif
                                        >
                                    <span class="form-radio-sign">启用</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" 
                                        type="radio" 
                                        name="status"
                                        value="0"
                                        @if ($data['status'] != 1)
                                        checked=""
                                        @endif
                                        >
                                    <span class="form-radio-sign">禁用</span>
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                设置账号的状态
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

            var url = "{{ route('sys.user.update-save', ['id' => $data['id']]) }}";
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
