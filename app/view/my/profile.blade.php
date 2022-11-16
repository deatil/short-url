@extends('common.base')

@section('title', '资料')

@section('style')
    @parent
@endsection

@section('content')
    <h1 class="app-page-title">账号信息</h1>
    <div class="row gy-4">
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
                <div class="app-card-header p-3 border-bottom-0">
                    <div class="row align-items-center gx-3">
                        <div class="col-auto">
                            <div class="app-icon-holder">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
</svg>
                            </div><!--//icon-holder-->
                            
                        </div><!--//col-->
                        <div class="col-auto">
                            <h4 class="app-card-title">基本信息</h4>
                        </div><!--//col-->
                    </div><!--//row-->
                </div><!--//app-card-header-->
                <div class="app-card-body px-4 w-100">
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label mb-2">
                                    <strong>头像</strong>
                                </div>
                                <div class="item-data">
                                    <img class="profile-image rounded-circle" src="{{ avatar_assets(user_info('avatar')) }}" alt="头像">
                                </div>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//item-->
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label"><strong>账号</strong></div>
                                <div class="item-data">{{ $userInfo['username'] }}</div>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//item-->
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label"><strong>邮箱</strong></div>
                                <div class="item-data">{{ $userInfo['email'] }}</div>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//item-->
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label"><strong>电话</strong></div>
                                <div class="item-data">
                                    {{ $userInfo['phone'] }}
                                </div>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//item-->
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label"><strong>注册时间</strong></div>
                                <div class="item-data">
                                    {{ date('Y-m-d H:i:s', $userInfo['add_time']) }}
                                </div>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//item-->
                </div><!--//app-card-body-->
                <div class="app-card-footer p-4 mt-auto">
                   <a class="btn app-btn-secondary" href="{{ route('my.settings') }}">管理信息</a>
                </div><!--//app-card-footer-->
               
            </div><!--//app-card-->
        </div><!--//col-->
        
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
                <div class="app-card-header p-3 border-bottom-0">
                    <div class="row align-items-center gx-3">
                        <div class="col-auto">
                            <div class="app-icon-holder">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sliders" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z"/>
</svg>
                            </div><!--//icon-holder-->
                            
                        </div><!--//col-->
                        <div class="col-auto">
                            <h4 class="app-card-title">接口信息</h4>
                        </div><!--//col-->
                    </div><!--//row-->
                </div><!--//app-card-header-->
                <div class="app-card-body px-4 w-100">
                    
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label"><strong>AppId </strong></div>
                                <div class="item-data">{{ $app['app_id'] ?? '--' }}</div>
                            </div><!--//col-->
                            @if (empty($app))
                                <div class="col text-right">
                                    <a class="btn-sm app-btn-secondary" href="{{ route('my.apply') }}">申请</a>
                                </div><!--//col-->
                            @endif
                        </div><!--//row-->
                    </div><!--//item-->
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label"><strong>AppSecret</strong></div>
                                <div class="item-data">{{ $app['app_secret'] ?? '--' }}</div>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//item-->
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label"><strong>状态</strong></div>
                                <div class="item-data">
                                    @if (!empty($app))
                                        @if ($app['is_apply'] == 1)
                                            <span class="badge bg-danger">正在审核</span>
                                        @else
                                            <span class="badge bg-success">审核通过</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">待申请</span>
                                    @endif
                                </div>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//item-->
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label"><strong>申请时间</strong></div>
                                <div class="item-data">
                                @if (!empty($app['add_time']))
                                    {{ date('Y-m-d H:i:s', $app['add_time']) }}
                                @else
                                    --
                                @endif
                                </div>
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//item-->
                </div><!--//app-card-body-->
                <div class="app-card-footer p-4 mt-auto">
                   <a class="btn app-btn-secondary" href="{{ route('my.apply') }}">管理申请</a>
                </div><!--//app-card-footer-->
               
            </div><!--//app-card-->
        </div><!--//col-->
    </div><!--//row-->
      
@endsection

@section('script')
    @parent
    
    <script>
    $(".nav-item.my-index .nav-link").addClass("active");
    </script> 
@endsection
