@extends('common.base')

@section('title', '申请API')

@section('style')
    @parent
@endsection

@section('content')
    <h1 class="app-page-title">申请API</h1>
    
    <hr class="mb-4">
    
    @if (!empty($app))
        @if ($app['is_apply'] == 1)
            <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
                <div class="inner">
                    <div class="app-card-body p-1 p-lg-2">
                        <h5 class="mb-3">正在审核中</h5>
                        <div class="row gx-2 gy-3">
                            <div class="col-12 col-lg-9">
                                <div>
                                    <div>
                                        <span class="text-muted">
                                            申请时间：
                                        </span>
                                        <span class="text-black">
                                            {{ date('Y-m-d H:i:s', $app['add_time']) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-muted">
                                            申请理由：
                                        </span>
                                        <span class="text-black">
                                            {{ $app['apply_content'] }}
                                        </span>
                                    </div>
                                </div>
                            </div><!--//col-->
                            <div class="col-12 col-lg-3">
                                <a class="btn btn-danger text-white js-cancel-apply-btn" 
                                    data-url="{{ route('my.apply.delete') }}"
                                    href="javascript:;">
                                    撤销申请
                                </a>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-body-->
                    
                </div><!--//inner-->
            </div><!--//app-card-->
        @else
            <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
                <div class="inner">
                    <div class="app-card-body p-1 p-lg-2">
                        <h5 class="mb-3">申请成功</h5>
                        <div class="row gx-2 gy-3">
                            <div class="col-12 col-lg-9">
                                <div>
                                    <div>
                                        申请时间：{{ date('Y-m-d H:i:s', $app['add_time']) }}
                                    </div>
                                    <div>
                                        通过时间：{{ date('Y-m-d H:i:s', $app['action_time']) }}
                                    </div>
                                </div>
                            </div><!--//col-->
                            <div class="col-12 col-lg-3">
                                <a class="btn app-btn-primary" href="{{ route('my.profile') }}">
                                    <i class="fa fa-eye" style="font-size: 1em;"></i>
                                    查看信息
                                </a>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-body-->
                    
                </div><!--//inner-->
            </div><!--//app-card-->
        @endif
    @else
        <div class="row g-4 settings-section">
            <div class="col-12">
                <div class="app-card app-card-settings shadow-sm p-4">
                    
                    <div class="app-card-body">
                        <form class="settings-form">
                            <div class="mb-3">
                                <label for="setting-content" 
                                    class="form-label">
                                    申请理由
                                    <span class="ml-2" 
                                        data-container="body" 
                                        data-toggle="popover" 
                                        data-trigger="hover" 
                                        data-placement="top" 
                                        data-content="填写你为什么要申请使用api生成短链接的理由。申请后请耐心等待审核"
                                    >
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                                            <circle cx="8" cy="4.5" r="1"/>
                                        </svg>
                                    </span>
                                </label>
                                <textarea class="form-control setting-content" 
                                    id="setting-content" 
                                    placeholder="请填写你申请使用API的理由" 
                                    style="height: 150px;"
                                    required></textarea>
                            </div>
                            <button type="button" class="btn app-btn-primary js-apply-btn">确认申请</button>
                        </form>
                    </div><!--//app-card-body-->
                    
                </div><!--//app-card-->
            </div>
        </div><!--//row-->
    @endif
@endsection

@section('script')
    @parent
    
    <script>
    ;(function($) {
        $(".nav-item.my-index .nav-link").addClass("active");
        
        // 提交申请
        $(".js-apply-btn").click(function(e) {
            e.stopPropagation;
            e.preventDefault;

            var content = $("#setting-content").val();

            var url = "{{ route('my.apply.save') }}";
            $.post(url, {
                content: content,
            }, function(data) {
                if (data.code == 0) {
                    layer.msg(data.msg, {
                        icon: 1
                    });
                    
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    layer.msg(data.msg);
                }
            }).fail(function (xhr, status, info) {
                layer.msg("请求失败");
            });
        });
        
        // 取消申请
        $('.js-cancel-apply-btn').click(function() {
            var url = $(this).data('url');
            
            layer.confirm('您确定要撤销申请吗？', {
                btn: ['确定', '取消']
            }, function(index){
                $.post(url, {}, function(data) {
                    if (data.code == 0) {
                        layer.msg(data.msg, {
                            icon: 1
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        layer.msg(data.msg, {
                            icon: 2
                        });
                    }
                });
            });
        });
    })(jQuery);

    </script> 
@endsection
