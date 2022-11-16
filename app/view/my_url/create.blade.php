@extends('common.base')

@section('title', '添加链接')

@section('style')
    @parent
@endsection

@section('content')
    <h1 class="app-page-title">添加链接</h1>
    
    <hr class="mb-4">
    
    <div class="row g-4 settings-section">
        <div class="col-12">
            <div class="app-card app-card-settings shadow-sm p-4">
                
                <div class="app-card-body">
                    <form class="settings-form">
                        <div class="mb-3">
                            <label for="url-addres" 
                                class="form-label">
                                链接地址
                                <span class="ml-2" 
                                    data-container="body" 
                                    data-toggle="popover" 
                                    data-trigger="hover" 
                                    data-placement="top" 
                                    data-content="填写需要转换的链接地址，需要以 http 或者 https 开头"
                                >
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                                        <circle cx="8" cy="4.5" r="1"/>
                                    </svg>
                                </span>
                            </label>
                            <textarea class="form-control" 
                                id="url-addres" 
                                placeholder="链接地址以 http 或者 https 开头" 
                                style="height: 150px;"
                                required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                类型
                                <span class="ml-2" 
                                    data-container="body" 
                                    data-toggle="popover" 
                                    data-trigger="hover" 
                                    data-placement="top" 
                                    data-content="设置生成链接的类型"
                                >
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                                        <circle cx="8" cy="4.5" r="1"/>
                                    </svg>
                                </span>
                            </label>
                            <div class="form-control">
                                <label class="form-radio-label">
                                    <input class="form-radio-input url-type" 
                                        type="radio" 
                                        name="type"
                                        value="1" 
                                        checked=""
                                        >
                                    <span class="form-radio-sign">临时链接</span>
                                </label>
                                <label class="form-radio-label ml-3">
                                    <input class="form-radio-input url-type" 
                                        type="radio" 
                                        name="type"
                                        value="2"
                                        >
                                    <span class="form-radio-sign">永久链接</span>
                                </label>
                            </div>
                        </div>
                        
                        <button type="button" class="btn app-btn-primary js-save-btn" >提交创建</button>
                    </form>
                </div><!--//app-card-body-->
                
            </div><!--//app-card-->
        </div>
    </div><!--//row-->
        
@endsection

@section('script')
    @parent
    
    <script>
    (function($) {
        "use strict";
        
        $(".nav-item.my-url-create .nav-link").addClass("active");
        
        // 提交
        $(".js-save-btn").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var content = $("#url-addres").val();
            var type = $(".url-type:checked").val();

            var url = "{{ route('my.url.create') }}";
            $.post(url, {
                content: content,
                type: type,
            }, function(data) {
                if (data.code == 0) {
                    layer.msg("提交成功");
                    
                    setTimeout(function() {
                        window.location.href = "{{ route('my.url') }}";
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
