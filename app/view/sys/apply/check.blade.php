@extends('common.base')

@section('title', '申请审核')

@section('style')
    @parent
@endsection

@section('content')
    <h1 class="app-page-title">申请审核</h1>
    
    <hr class="mb-4">
    
    <div class="app-card alert alert-dismissible shadow-sm mb-4" role="alert">
        <div class="inner">
            <div class="app-card-body p-1 p-lg-2">
                <h5 class="mb-3">申请信息</h5>
                <div class="row gx-2 gy-3">
                    <div class="col-12 col-lg-9">
                        <div>
                            <div>
                                <div class="text-muted">
                                    AppId：
                                </div>
                                <div class="text-black">
                                    {{ $data['app_id'] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    AppSecret：
                                </div>
                                <div class="text-black">
                                    {{ $data['app_secret'] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    申请理由：
                                </div>
                                <div class="text-black">
                                    {{ $data['apply_content'] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    申请账号：
                                </div>
                                <div class="text-black">
                                    {{ $data['user']['username'] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    申请时间：
                                </div>
                                <div class="text-black">
                                    {{ date('Y-m-d H:i:s', $data['add_time']) }}
                                </div>
                            </div>
                            
                            @if (!empty($data['action_time']))
                            <div class="mt-2">
                                <div class="text-muted">
                                    最后审核时间：
                                </div>
                                <div class="text-black">
                                    {{ date('Y-m-d H:i:s', $data['action_time']) }}
                                </div>
                            </div>
                            @endif
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
                    <form class="apply-form">
                        <div class="mb-3">
                            <label class="form-label">
                                申请状态
                            </label>
                            <div class="form-control">
                                <label class="form-radio-label">
                                    <input class="form-radio-input" 
                                        type="radio" 
                                        name="check"
                                        value="0" 
                                        @if ($data['is_apply'] == 0)
                                        checked=""
                                        @endif
                                        >
                                    <span class="form-radio-sign">未通过</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" 
                                        type="radio" 
                                        name="check"
                                        value="1"
                                        @if ($data['is_apply'] == 1)
                                        checked=""
                                        @endif
                                        >
                                    <span class="form-radio-sign">申请中</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" 
                                        type="radio" 
                                        name="check"
                                        value="2"
                                        @if ($data['is_apply'] == 2)
                                        checked=""
                                        @endif
                                        >
                                    <span class="form-radio-sign">通过</span>
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                设置申请的审核状态
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="setting-action_content" class="form-label">
                                审核结果
                            </label>
                            <textarea class="form-control" 
                                id="setting-action_content" 
                                name="content"
                                style="height: 130px;"
                                required>{{ $data['action_content'] }}</textarea>
                            <small class="form-text text-muted">
                                填写审核的审批内容
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                状态
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
                                设置数据的状态
                            </small>
                        </div>
                        
                        <button type="button" class="btn app-btn-primary js-save-button" >保存更改</button>
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
        $(".submenu-item.nav-settings-apply .submenu-link").addClass("active");

        // 保存
        $(".js-save-button").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var data = $(".apply-form").serialize();

            var url = "{{ route('apply.check-save', ['id' => $data['id']]) }}";
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
