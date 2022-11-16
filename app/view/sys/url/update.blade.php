@extends('common.base')

@section('title', '编辑链接')

@section('style')
    @parent
@endsection

@section('content')
    <h1 class="app-page-title">编辑链接</h1>
    
    <hr class="mb-4">
    
    <div class="app-card alert alert-dismissible shadow-sm mb-4" role="alert">
        <div class="inner">
            <div class="app-card-body p-1 p-lg-2">
                <h5 class="mb-3">链接信息</h5>
                <div class="row gx-2 gy-3">
                    <div class="col-12 col-lg-9">
                        <div>
                            <div>
                                <div class="text-muted">
                                    跳转链接：
                                </div>
                                <div class="text-black">
                                    {{ $data['url'] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    存储ID：
                                </div>
                                <div class="text-black">
                                    {{ $data['url_id'] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    短链接：
                                </div>
                                <div class="text-black">
                                    {{ share_url($data['url_id']) }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    系统地址：
                                </div>
                                <div class="text-black">
                                    {{ short_route('index.redirect', ['id' => $data['url_id']]) }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    链接信息：
                                </div>
                                <div class="text-black">
                                    @if (!empty($data['scheme']))
                                    <span class="badge bg-warning">{{ $data['scheme'] }}</span>
                                    @endif
                                    
                                    <span class="badge bg-success">{{ $data['host'] }}</span>
                                    
                                    @if (!empty($data['port']))
                                    <span class="badge bg-danger">{{ $data['port'] }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    所属账号：
                                </div>
                                <div class="text-black">
                                    {{ $data['user']['username'] }}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="text-muted">
                                    添加时间：
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
                    <form class="url-form">
                        <div class="mb-3">
                            <label for="setting-website_description" class="form-label">
                                链接地址 
                            </label>
                            <textarea class="form-control" 
                                id="setting-website_description" 
                                name="url"
                                style="height: 130px;"
                                placeholder="链接地址以 http 或者 https 开头" 
                                required>{{ $data['url'] }}</textarea>
                            <small class="form-text text-muted">
                                填写跳转链接地址
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="setting-input-1" class="form-label">
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
        $(".submenu-item.nav-settings-url .submenu-link").addClass("active");

        // 保存
        $(".js-save-button").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var data = $(".url-form").serialize();

            var url = "{{ route('url.update-save', ['id' => $data['id']]) }}";
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
