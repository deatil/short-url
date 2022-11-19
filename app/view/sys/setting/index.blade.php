@extends('common.base')

@section('title', '网站设置')

@section('style')
    @parent
@endsection

@section('content')
    <h1 class="app-page-title">网站设置</h1>
    <hr class="mb-4">
    <div class="row g-4 settings-section">
        <div class="col-12">
            <div class="app-card app-card-settings shadow-sm p-4">
                
                <div class="app-card-body">
                    <form class="settings-form">
                        <div class="mb-3">
                            <label for="setting-website_name" class="form-label">
                                网站名称
                            </label>
                            <input type="text" 
                                class="form-control" 
                                id="setting-website_name" 
                                name="setting[website_name]"
                                value="{{ $data['website_name'] }}" 
                                required>
                            <small class="form-text text-muted">
                                设置网站名称
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="setting-website_keywords" class="form-label">
                                网站关键字
                            </label>
                            <input type="text" 
                                class="form-control" 
                                id="setting-website_keywords" 
                                name="setting[website_keywords]"
                                value="{{ $data['website_keywords'] }}" 
                                required>
                            <small class="form-text text-muted">
                                设置网站关键字
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="setting-website_description" class="form-label">
                                网站描述
                            </label>
                            <textarea class="form-control" 
                                id="setting-website_description" 
                                name="setting[website_description]"
                                style="height: 130px;"
                                required>{{ $data['website_description'] }}</textarea>
                            <small class="form-text text-muted">
                                设置网站描述
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="setting-website_copyright" class="form-label">
                                网站版权
                            </label>
                            <input type="text" 
                                class="form-control" 
                                id="setting-website_copyright" 
                                name="setting[website_copyright]"
                                value="{{ $data['website_copyright'] }}" 
                                required>
                            <small class="form-text text-muted">
                                设置网站版权
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="setting-website_beian" class="form-label">
                                网站备案
                            </label>
                            <input type="text" 
                                class="form-control" 
                                id="setting-website_beian" 
                                name="setting[website_beian]"
                                value="{{ $data['website_beian'] }}" 
                                required>
                            <small class="form-text text-muted">
                                设置网站备案
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                网站状态
                            </label>
                            <div class="form-control">
                                <label class="form-radio-label">
                                    <input class="form-radio-input" 
                                        type="radio" 
                                        name="setting[website_status]"
                                        value="1" 
                                        @if ($data['website_status'] == 1)
                                        checked=""
                                        @endif
                                        >
                                    <span class="form-radio-sign">开启运行</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input" 
                                        type="radio" 
                                        name="setting[website_status]"
                                        value="0"
                                        @if ($data['website_status'] != 1)
                                        checked=""
                                        @endif
                                        >
                                    <span class="form-radio-sign">关闭网站</span>
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                设置网站的状态
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
        $(".submenu-item.nav-settings-setting .submenu-link").addClass("active");

        // 保存
        $(".js-save-button").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var data = $(".settings-form").serialize();

            var url = "{{ route('sys.setting.save') }}";
            $.post(url, data, function(data) {
                if (data.code == 0) {
                    layer.msg("保存成功");
                    
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
